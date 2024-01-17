const Setting = require('../models/settingModel');
const User = require('../models/userModel');
const Order = require('../models/orderModel');
const Product = require('../models/productModel');
const Currency = require('../models/currencyModel');
const Review = require('../models/reviewModel');
const Promotion = require('../models/promotionModel');
const Userpromotion = require('../models/userpromotionModel');
const Address = require('../models/addressModel');
const Commission = require('../models/commissionModel');


// email service
const mailerController = require('./mailController');

const logController = require("../controllers/logController");
let fcmController = require("../controllers/fcmController");



exports.balancesheet = async function (req, res) {
    if (!req.body.lang_code || !req.body.price || !req.body.currency || !req.body.user_id || !req.body.item_id) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {

    try {

	let appSettings = await Setting.findOne({});

        let userDetails = await User.findOne({ _id: req.body.user_id })

        if (userDetails.status === 0) {
            return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });
        }

        let itemDetail = await Product.findById(req.body.item_id);

        if(itemDetail.productAvailability == "sold") {
            return res.status(200).json({ status: "false", short_code: "block", message: res.__("Item already Sold") });

        }


        const stripe = require('stripe')(appSettings.privatekey);

        const customer = await stripe.customers.create();

        const ephemeralKey = await stripe.ephemeralKeys.create(
            {customer: customer.id},
            {apiVersion: '2020-08-27'}
          );

        var amount = req.body.price * 100;

          const paymentIntent = await stripe.paymentIntents.create({
            amount: amount,
            currency: req.body.currency,
            customer: customer.id,
          });

          return res.status(200).json({ status: "true", paymentIntent: paymentIntent.client_secret,
            ephemeralKey: ephemeralKey.secret,
            customer: customer.id
             });

      } catch (err) {
            console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }

    }

};





exports.buynowpayment = async function (req, res) {
    if (!req.body.lang_code || !req.body.item_id || !req.body.pay_token || !req.body.user_id || !req.body.address_id) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {

    try {
    
    	let appSettings = await Setting.findOne({});

        let userDetails = await User.findOne({ _id: req.body.user_id })

        if (userDetails.status === 0) {
            return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });
        }

        const stripe = require('stripe')(appSettings.privatekey);

        const paymentIntent = await stripe.paymentIntents.retrieve(req.body.pay_token);

        //console.log(paymentIntent);

        let orderData = {};
        orderData.userId = req.body.user_id;
        orderData.itemId = req.body.item_id;
        orderData.addressId = req.body.address_id;

        let itemDetail = await Product.findById(req.body.item_id).populate("CurrencyID");

        let sellerDetails = await User.findOne({ _id: itemDetail.userId });

        orderData.sellerId = itemDetail.userId;
        orderData.price = itemDetail.price;
        orderData.shippingprice = itemDetail.shippingprice;
        totalprice = parseInt(itemDetail.price) + parseInt(itemDetail.shippingprice);
        orderData.totalprice = totalprice;

        let commissions = await Commission.find();

        for (var i = 0; i < commissions.length; i++) {
            minrange = commissions[i].minrange;
            maxrange =  commissions[i].maxrange;

            if (totalprice >= minrange && totalprice <= maxrange) {
                amount = (parseFloat(totalprice) / 100) * (commissions[i].percentage);
                orderData.commissionprice = amount;
                
            }


        }

        orderData.currency = itemDetail.CurrencyID.currencysymbol;
        orderData.currencyCode = itemDetail.CurrencyID.currencycode;
        orderData.pay_token = req.body.pay_token;
        orderData.orderDate = Date.now();
        orderData.otp = Math.floor(1000 + Math.random() * 9000);


        if (paymentIntent.status == "succeeded") {

            orderData.status = "paid";

            itemDetail.productAvailability = "sold";
            await itemDetail.save();


            let order = new Order(orderData);

            await order.save(function (error, orderDetail) {

            if (!error) {


                let mailData = {};
                mailData.to = userDetails.email;
                mailData.userid = userDetails._id;
                mailData.purpose = "buyerorder";
                mailData.subject = res.__("Your Order is confirmed for the Product #")+itemDetail.itemTitle;
                mailData.title = res.__("Your Order is confirmed for the Product #")+itemDetail.itemTitle;
                mailData.orderid = orderDetail._id;
                mailData.orderdate = orderDetail.orderDate;
                mailData.sellername = sellerDetails.name;
                mailData.productname = itemDetail.itemTitle;
                mailData.productprice = itemDetail.price+" "+itemDetail.CurrencyID.currencycode;
                mailData.shippingprice = itemDetail.shippingprice+" "+itemDetail.CurrencyID.currencycode;
                mailData.totalprice = itemDetail.totalprice+" "+itemDetail.CurrencyID.currencycode;
                mailerController.sendMail(mailData);

                let buyerlogMessage = res.__("Hello") + " " + userDetails.name + "! , " + res.__("Your Order is confirmed for the Product #") + " " + itemDetail.itemTitle;
                logController.createLog(sellerDetails._id, userDetails._id, itemDetail._id, "0", "buyerorder", buyerlogMessage);

                let buyermessageData = {};
                let buyerorderDetail = {};
                let buyerorder = [];
                buyerorderDetail.type = "buyerorder";
                buyerorderDetail.id = itemDetail._id;
                buyermessageData.body = "Your Order is confirmed for the Product #'" + itemDetail.itemTitle + "'";
                buyermessageData.title = userDetails.name;
                buyerorder.push(userDetails._id);
                console.log('messageData: ',buyermessageData);
                fcmController.sendNotification(buyerorder, buyermessageData, buyerorderDetail);

                let sellermailData = {};
                sellermailData.to = sellerDetails.email;
                sellermailData.userid = sellerDetails._id;
                sellermailData.purpose = "sellerorder";
                sellermailData.subject = res.__("New Order is placed for your Product #")+itemDetail.itemTitle;
                sellermailData.title = res.__("New Order is placed for your Product #")+itemDetail.itemTitle;
                sellermailData.orderid = orderDetail._id;
                sellermailData.orderdate = orderDetail.orderDate;
                sellermailData.buyername = userDetails.name;
                sellermailData.productname = itemDetail.itemTitle;
                sellermailData.productprice = itemDetail.price+" "+itemDetail.CurrencyID.currencycode;
                sellermailData.shippingprice = itemDetail.shippingprice+" "+itemDetail.CurrencyID.currencycode;
                sellermailData.totalprice = itemDetail.totalprice+" "+itemDetail.CurrencyID.currencycode;
                mailerController.sendMail(sellermailData);

                console.log(userDetails._id);
                console.log(sellerDetails._id);

                let sellerlogMessage = res.__("Hello") + " " + sellerDetails.name + "! , " + res.__("New Order is placed for your Product #") + " " + itemDetail.itemTitle;
                logController.createLog(userDetails._id, itemDetail.userId, itemDetail._id, "0", "sellerorder", sellerlogMessage);

                let sellermessageData = {};
                let sellerorderDetail = {};
                let sellerorder = [];
                sellerorderDetail.type = "sellerorder";
                sellerorderDetail.id = itemDetail._id;
                sellermessageData.body = "New Order is placed for your Product #'" + itemDetail.itemTitle + "'";
                sellermessageData.title = sellerDetails.name;
                sellerorder.push(sellerDetails._id);
                console.log('messageData: ',buyermessageData);
                fcmController.sendNotification(sellerorder, sellermessageData, sellerorderDetail);

                return res.status(200).json({ status: "true", order_id: orderDetail._id, message: "Ordered Successfully"});

            } else {

                console.log(error);

                return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });

            }

            });

        } else {

            orderData.status = "incomplete";

            let order = new Order(orderData);

            await order.save(function (error, orderDetail) {

            if (!error) {


                return res.status(200).json({ status: "true", order_id: orderDetail._id, message: "Payment Incompleted"});

            } else {

                console.log(error);

                return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });

            }

            });


        }


      } catch (err) {
            console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }

    }

};

exports.myorders = async function (req, res) {
    if (!req.body.lang_code || !req.body.user_id) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {

    try {

        let userDetails = await User.findOne({ _id: req.body.user_id })

        if (userDetails.status === 0) {
            return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });
        }

        if(req.body.offset) {
            offset = parseInt(req.body.offset);
        } else {
            offset = 0;

        }
        if(req.body.limit) {
            limit = parseInt(req.body.limit);
        } else {
            limit = 10;
        }

        let getOrders = await Order.find({userId: req.body.user_id}).limit(limit).skip(offset).sort({orderDate: -1}).populate("itemId").populate("userId").populate("sellerId").populate("addressId");
            
        if(getOrders.length == 0) {

          return res.status(200).json({ status: "true", result:  "No Order Found" });

        }

        let orderList = [];

        for (var i = 0; i < getOrders.length; i++) {

            let userImage = (getOrders[i].userId.image) ? process.env.BASE_URL + process.env.USER_THUMB100_URL + getOrders[i].userId.image : "";
            let sellerImage = (getOrders[i].sellerId.image) ? process.env.BASE_URL + process.env.USER_THUMB100_URL + getOrders[i].sellerId.image : "";

            let deliveredDate = (getOrders[i].deliveredDate) ? getOrders[i].deliveredDate : "";

            let reviewDetails = await Review.findOne({"orderId": getOrders[i]._id});

            if(reviewDetails) {
                reviewId = reviewDetails._id;
                reviewCount = reviewDetails.rating;
                reviewMsg = reviewDetails.message;

            } else {
                reviewId = "";
                reviewCount = "";
                reviewMsg = "";
            }

            if(getOrders[i].addressId) {
                address_id = getOrders[i].addressId._id;
                name = getOrders[i].addressId.name;
                phone = getOrders[i].addressId.phone;
                address_line1 = getOrders[i].addressId.addressOne;
                address_line2 = getOrders[i].addressId.addressTwo;
                country = getOrders[i].addressId.country;
                pincode = getOrders[i].addressId.pincode;

            } else {
                address_id = "";
                name = "";
                phone = "";
                address_line1 = "";
                address_line2 = "";
                country = "";
                pincode = "";

            }
            
            if(getOrders[i].itemId) {

                itemId = getOrders[i].itemId._id;
                itemTitle  = getOrders[i].itemId.itemTitle;

                let productImg = JSON.parse(getOrders[i].itemId.images);
                itemImage = process.env.BASE_URL + process.env.PRODUCT_THUMB300_MEDIA_URL + productImg[0];

            } else {

                itemId = "";
                itemTitle  = "";
                itemImage = "";

            }

            orderList.push({
                    order_id: getOrders[i]._id,
                    order_status: getOrders[i].status,
                    currency: getOrders[i].currency,
                    order_date: getOrders[i].orderDate,
                    delivered_date: deliveredDate,
                    price: getOrders[i].totalprice,
                    pay_token: getOrders[i].pay_token,
                    item_id: itemId,
                    item_name: itemTitle,
                    item_image: itemImage,
                    seller_id: getOrders[i].sellerId._id,
                    seller_name: getOrders[i].sellerId.name,
                    seller_image: sellerImage,
                    buyer_id: getOrders[i].userId._id,
                    buyer_name: getOrders[i].userId.name,
                    buyer_image: userImage,
                    otp: getOrders[i].otp,
                    review_id: reviewId,
                    review_count: reviewCount,
                    review_message: reviewMsg,
                    address_id: address_id,
                    name: name,
                    phone: phone,
                    address_line1: address_line1,
                    address_line2: address_line2,
                    country: country,
                    pincode: pincode,
                    item_price: getOrders[i].price,
                    shipping_price: getOrders[i].shippingprice,
                });


        }

                  return res.status(200).json({ status: "true", result:  orderList });


      } catch (err) {
            console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }

    }

};


exports.mysales = async function (req, res) {
    if (!req.body.lang_code || !req.body.user_id) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {

    try {

        let userDetails = await User.findOne({ _id: req.body.user_id })

        if (userDetails.status === 0) {
            return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });
        }

        if(req.body.offset) {
            offset = parseInt(req.body.offset);
        } else {
            offset = 0;

        }
        if(req.body.limit) {
            limit = parseInt(req.body.limit);
        } else {
            limit = 10;
        }

        let getOrders = await Order.find({sellerId: req.body.user_id}).limit(limit).skip(offset).sort({orderDate: -1}).populate("itemId").populate("userId").populate("sellerId").populate("addressId");
            

        if(getOrders.length == 0) {

          return res.status(200).json({ status: "true", result:  "No Sales Found" });

        }

        let orderList = [];

        for (var i = 0; i < getOrders.length; i++) {

            let userImage = (getOrders[i].userId.image) ? process.env.BASE_URL + process.env.USER_THUMB100_URL + getOrders[i].userId.image : "";
            let sellerImage = (getOrders[i].sellerId.image) ? process.env.BASE_URL + process.env.USER_THUMB100_URL + getOrders[i].sellerId.image : "";

            let deliveredDate = (getOrders[i].deliveredDate) ? getOrders[i].deliveredDate : "";

            let reviewDetails = await Review.findOne({"orderId": getOrders[i]._id});

            if(reviewDetails) {
                reviewId = reviewDetails._id;
                reviewCount = reviewDetails.rating;
                reviewMsg = reviewDetails.message;

            } else {
                reviewId = "";
                reviewCount = "";
                reviewMsg = "";
            }

            if(getOrders[i].addressId) {
                address_id = getOrders[i].addressId._id;
                name = getOrders[i].addressId.name;
                phone = getOrders[i].addressId.phone;
                address_line1 = getOrders[i].addressId.addressOne;
                address_line2 = getOrders[i].addressId.addressTwo;
                country = getOrders[i].addressId.country;
                pincode = getOrders[i].addressId.pincode;

            } else {
                address_id = "";
                name = "";
                phone = "";
                address_line1 = "";
                address_line2 = "";
                country = "";
                pincode = "";

            }
            
            if(getOrders[i].itemId) {

                itemId = getOrders[i].itemId._id;
                itemTitle  = getOrders[i].itemId.itemTitle;

                let productImg = JSON.parse(getOrders[i].itemId.images);
                itemImage = process.env.BASE_URL + process.env.PRODUCT_THUMB300_MEDIA_URL + productImg[0];

            } else {

                itemId = "";
                itemTitle  = "";
                itemImage = "";

            }

            orderList.push({
                    order_id: getOrders[i]._id,
                    order_status: getOrders[i].status,
                    currency: getOrders[i].currency,
                    order_date: getOrders[i].orderDate,
                    delivered_date: deliveredDate,
                    price: getOrders[i].totalprice,
                    pay_token: getOrders[i].pay_token,
                    item_id: itemId,
                    item_name: itemTitle,
                    item_image: itemImage,
                    seller_id: getOrders[i].sellerId._id,
                    seller_name: getOrders[i].sellerId.name,
                    seller_image: sellerImage,
                    buyer_id: getOrders[i].userId._id,
                    buyer_name: getOrders[i].userId.name,
                    buyer_image: userImage,
                    review_id: reviewId,
                    review_count: reviewCount,
                    review_message: reviewMsg,
                    address_id: address_id,
                    name: name,
                    phone: phone,
                    address_line1: address_line1,
                    address_line2: address_line2,
                    country: country,
                    pincode: pincode,
                    item_price: getOrders[i].price,
                    shipping_price: getOrders[i].shippingprice,
            });



        }

        return res.status(200).json({ status: "true", result:  orderList });


      } catch (err) {
            console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }

    }

};


exports.orderdetails = async function (req, res) {
    if (!req.body.lang_code || !req.body.user_id || !req.body.order_id) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {

    try {

        let userDetails = await User.findOne({ _id: req.body.user_id })

        if (userDetails.status === 0) {
            return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });
        }


        let getOrders = await Order.findOne({_id: req.body.order_id}).populate("itemId").populate("userId").populate("sellerId").populate("addressId");
        
        

            let productImg = JSON.parse(getOrders.itemId.images);
            let userImage = (getOrders.userId.image) ? process.env.BASE_URL + process.env.USER_THUMB100_URL + getOrders.userId.image : "";
            let sellerImage = (getOrders.sellerId.image) ? process.env.BASE_URL + process.env.USER_THUMB100_URL + getOrders.sellerId.image : "";

            let deliveredDate = (getOrders.deliveredDate) ? getOrders.deliveredDate : "";

            let reviewDetails = await Review.findOne({"orderId": getOrders._id});

            if(reviewDetails) {
                reviewId = reviewDetails._id;
                reviewCount = reviewDetails.rating;
                reviewMsg = reviewDetails.message;

            } else {
                reviewId = "";
                reviewCount = "";
                reviewMsg = "";
            }

            if(getOrders.addressId) {
                address_id = getOrders.addressId._id;
                name = getOrders.addressId.name;
                phone = getOrders.addressId.phone;
                address_line1 = getOrders.addressId.addressOne;
                address_line2 = getOrders.addressId.addressTwo;
                country = getOrders.addressId.country;
                pincode = getOrders.addressId.pincode;

            } else {
                address_id = "";
                name = "";
                phone = "";
                address_line1 = "";
                address_line2 = "";
                country = "";
                pincode = "";

            }
            
            if(getOrders.itemId) {

                itemId = getOrders.itemId._id;
                itemTitle  = getOrders.itemId.itemTitle;

                let productImg = JSON.parse(getOrders.itemId.images);
                itemImage = process.env.BASE_URL + process.env.PRODUCT_THUMB300_MEDIA_URL + productImg[0];

            } else {

                itemId = "";
                itemTitle  = "";
                itemImage = "";

            }

            orderList = {
                    order_id: getOrders._id,
                    order_status: getOrders.status,
                    currency: getOrders.currency,
                    order_date: getOrders.orderDate,
                    delivered_date: deliveredDate,
                    price: getOrders.totalprice,
                    pay_token: getOrders.pay_token,
                    item_id: itemId,
                    item_name: itemTitle,
                    item_image: itemImage,
                    seller_id: getOrders.sellerId._id,
                    seller_name: getOrders.sellerId.name,
                    seller_image: sellerImage,
                    buyer_id: getOrders.userId._id,
                    buyer_name: getOrders.userId.name,
                    buyer_image: userImage,
                    otp: getOrders.otp,
                    review_id: reviewId,
                    review_count: reviewCount,
                    review_message: reviewMsg,
                    address_id: address_id,
                    name: name,
                    phone: phone,
                    address_line1: address_line1,
                    address_line2: address_line2,
                    country: country,
                    pincode: pincode,
                    item_price: getOrders.price,
                    shipping_price: getOrders.shippingprice,

            };

          return res.status(200).json({ status: "true", result:  orderList });



      } catch (err) {
            console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }

    }

};


exports.markasDelivered = async function (req, res) {
    if (!req.body.lang_code || !req.body.user_id || !req.body.order_id || !req.body.otp) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {

    try {

        let userDetails = await User.findOne({ _id: req.body.user_id })

        if (userDetails.status === 0) {
            return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });
        }


        const orderDetail = await Order.findOne({_id: req.body.order_id});

        let itemDetail = await Product.findById(orderDetail.itemId).populate("CurrencyID");

        let sellerDetails = await User.findOne({ _id: itemDetail.userId });

        if(orderDetail.otp !== req.body.otp) {
            return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Incorrect OTP") });

        }
        
        orderDetail.status = 'delivered';
        orderDetail.deliveredDate = Date.now();

        await orderDetail.save();


                let mailData = {};
                mailData.to = userDetails.email;
                mailData.userid = userDetails._id;
                mailData.purpose = "buyerdelivered";
                mailData.subject = res.__("Your Order is successfully delivered for the Product #")+itemDetail.itemTitle;
                mailData.title = res.__("Your Order is successfully delivered for the Product #")+itemDetail.itemTitle;
                mailData.orderid = orderDetail._id;
                mailData.orderdate = orderDetail.orderDate;
                mailData.sellername = sellerDetails.name;
                mailData.productname = itemDetail.itemTitle;
                mailData.productprice = itemDetail.price+" "+itemDetail.CurrencyID.currencycode;
                mailData.shippingprice = itemDetail.shippingprice+" "+itemDetail.CurrencyID.currencycode;
                mailData.totalprice = itemDetail.totalprice+" "+itemDetail.CurrencyID.currencycode;
                mailerController.sendMail(mailData);

                let buyerlogMessage = res.__("Hello") + " " + userDetails.name + "! , " + res.__("Your Order is successfully delivered for the Product #") + "" + itemDetail.itemTitle;
                logController.createLog(itemDetail.userId, userDetails._id, itemDetail._id, "0", "buyerdelivered", buyerlogMessage);

                let buyermessageData = {};
                let buyerorderDetail = {};
                let buyerorder = [];
                buyerorderDetail.type = "buyerorder";
                buyerorderDetail.id = itemDetail._id;
                buyermessageData.body = "Your Order is successfully delivered for the Product #'" + itemDetail.itemTitle + "'";
                buyermessageData.title = userDetails.name;
                buyerorder.push(userDetails._id);
                console.log('messageData: ',buyermessageData);
                fcmController.sendNotification(buyerorder, buyermessageData, buyerorderDetail);

                let sellermailData = {};
                sellermailData.to = sellerDetails.email;
                sellermailData.userid = sellerDetails._id;
                sellermailData.purpose = "sellerdelivered";
                sellermailData.subject = res.__("Your order has been marked as delivered for your Product #")+itemDetail.itemTitle;
                sellermailData.title = res.__("Your order has been marked as delivered for your Product #")+itemDetail.itemTitle;
                sellermailData.orderid = orderDetail._id;
                sellermailData.orderdate = orderDetail.orderDate;
                sellermailData.buyername = userDetails.name;
                sellermailData.productname = itemDetail.itemTitle;
                sellermailData.productprice = itemDetail.price+" "+itemDetail.CurrencyID.currencycode;
                sellermailData.shippingprice = itemDetail.shippingprice+" "+itemDetail.CurrencyID.currencycode;
                sellermailData.totalprice = itemDetail.totalprice+" "+itemDetail.CurrencyID.currencycode;
                mailerController.sendMail(sellermailData);

                let sellerlogMessage = res.__("Hello") + " " + sellerDetails.name + "! , " + res.__("Your order has been marked as delivered for your Product #") + "" + itemDetail.itemTitle;
                logController.createLog(userDetails._id, sellerDetails._id, itemDetail._id, "0", "sellerdelivered", sellerlogMessage);

                let sellermessageData = {};
                let sellerorderDetail = {};
                let sellerorder = [];
                sellerorderDetail.type = "sellerorder";
                sellerorderDetail.id = itemDetail._id;
                sellermessageData.body = "Your order has been marked as delivered for your Product #'" + itemDetail.itemTitle + "'";
                sellermessageData.title = sellerDetails.name;
                sellerorder.push(sellerDetails._id);
                console.log('messageData: ',buyermessageData);
                fcmController.sendNotification(sellerorder, sellermessageData, sellerorderDetail);
        

        return res.status(200).json({ status: "true", message:  "Order marked as Delivered" });



      } catch (err) {
            console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }

    }

};


exports.markasCancelled = async function (req, res) {
    if (!req.body.lang_code || !req.body.user_id || !req.body.order_id) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {

    try {

        let userDetails = await User.findOne({ _id: req.body.user_id })

        if (userDetails.status === 0) {
            return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });
        }


        const orderData = await Order.findOne({_id: req.body.order_id}).populate("itemId");

        orderData.status = 'cancelled';

        await orderData.save();


        let itemDetail = await Product.findById(orderData.itemId._id);

        itemDetail.productAvailability = "available";
        await itemDetail.save();
        

        return res.status(200).json({ status: "true", message:  "Order marked as Cancelled" });



      } catch (err) {
            console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }

    }

};



exports.promotionbalancesheet = async function (req, res) {
    if (!req.body.lang_code || !req.body.price || !req.body.currency || !req.body.user_id) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {

    try {

        let appSettings = await Setting.findOne({});
        
        let userDetails = await User.findOne({ _id: req.body.user_id })

        if (userDetails.status === 0) {
            return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });
        }

        const stripe = require('stripe')(appSettings.privatekey);

        const customer = await stripe.customers.create();

        const ephemeralKey = await stripe.ephemeralKeys.create(
            {customer: customer.id},
            {apiVersion: '2020-08-27'}
          );

        var amount = req.body.price * 100;

          const paymentIntent = await stripe.paymentIntents.create({
            amount: amount,
            currency: req.body.currency,
            customer: customer.id,
          });

          return res.status(200).json({ status: "true", paymentIntent: paymentIntent.client_secret,
            ephemeralKey: ephemeralKey.secret,
            customer: customer.id });

      } catch (err) {
            console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }

    }

};


exports.paypromotion = async function (req, res) {
    if (!req.body.lang_code || !req.body.item_id || !req.body.pay_token || !req.body.user_id || !req.body.promotion_id) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {

    try {
    
        let appSettings = await Setting.findOne({});

        let userDetails = await User.findOne({ _id: req.body.user_id })

        if (userDetails.status === 0) {
            return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });
        }

        const stripe = require('stripe')(appSettings.privatekey);

        const paymentIntent = await stripe.paymentIntents.retrieve(req.body.pay_token);

        

        if (paymentIntent.status == "succeeded") {

            const itemDetail = await Product.findOne({ _id: req.body.item_id }); 

            const promotionDetail = await Promotion.findOne({ _id: req.body.promotion_id});

            let expireOn = Date.now() + promotionDetail.duration*24*60*60*1000;


            itemDetail.featured = 1;
            itemDetail.featureDuration = promotionDetail.duration;
            itemDetail.featureactiveOn = Date.now();
            itemDetail.featureexpireOn = expireOn;
            await itemDetail.save();

            let itemData = await Product.findById(req.body.item_id).populate("CurrencyID");

            let userpromotionData = {};


            userpromotionData.userId = req.body.user_id;
            userpromotionData.itemId = req.body.item_id;
            userpromotionData.promotionId = req.body.promotion_id;
            userpromotionData.currencySymbol = "$";
            userpromotionData.currencyCode = "USD";
            userpromotionData.activeOn = Date.now();
            userpromotionData.expireOn = expireOn;

            let userpromotion = new Userpromotion(userpromotionData);
            await userpromotion.save(function (error, userpromotionDetails) {
                if (!error) {


                    let mailData = {};
                    mailData.to = userDetails.email;
                    mailData.userid = userDetails._id;
                    mailData.purpose = "promotion";
                    mailData.subject = res.__("Your product has been promoted successfully #")+itemData.itemTitle;
                    mailData.title = res.__("Your product has been promoted successfully #")+itemData.itemTitle;
                    mailData.username = userDetails.name;
                    mailData.productname = itemData.itemTitle;
                    mailData.promotionduration = promotionDetail.duration;
                    mailData.promotionprice = promotionDetail.price+" "+itemData.CurrencyID.currencycode;
                    mailerController.sendMail(mailData);

                    let logMessage = res.__("Hello") + " " + userDetails.name + "! , " + res.__("Your product has been promoted successfully #") + "" + itemData.itemTitle;
                    logController.createLog(userDetails._id, userDetails._id, itemData._id, "0", "promotion", logMessage);

                    let messageData = {};
                    let itemDetailPro = {};
                    let itemList = [];
                    itemDetailPro.type = "promotion";
                    itemDetailPro.id = itemDetailPro._id;
                    messageData.body = "Your product has been promoted successfully #'" + itemData.itemTitle + "'";
                    messageData.title = userDetails.name;
                    itemList.push(userDetails._id);
                    console.log('messageData: ',messageData);
                    fcmController.sendNotification(itemList, messageData, itemDetailPro);
                
                    return res.status(200).json({ status: "true", message: "Product promoted Successfully"});

                } else {
console.log(error);
                    return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });

                }
            });

        } else {

            
            return res.status(200).json({ status: "true", message: "Payment Incompleted"});

            


        }


      } catch (err) {
            console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }

    }

};
