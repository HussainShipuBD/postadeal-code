const mongoose = require("mongoose");
const moment = require("moment");
var fs = require('fs');

const User = require('../models/userModel');
const Product = require('../models/productModel');
const Category = require('../models/categoryModel');
const Subcategory = require('../models/subcategoryModel');
const Supercategory = require('../models/supercategoryModel');
const Location = require('../models/locationModel');
const Productcondition = require('../models/productConditionModel');
const Currency = require('../models/currencyModel');
const Banner = require('../models/bannerModel');
const Like = require('../models/likeModel');
const Report = require('../models/reportModel');
const Promotion = require('../models/promotionModel');
const Userpromotion = require('../models/userpromotionModel');
const Setting = require('../models/settingModel');

const logController = require("../controllers/logController");
let fcmController = require("../controllers/fcmController");



exports.addProduct = async function (req, res) {
	//console.log("hai");
    if (!req.body.user_id || !req.body.images || !req.body.item_title || !req.body.item_desc || !req.body.price || 
    	!req.body.currency_id || !req.body.item_condition_id || !req.body.cat_id ) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {

        	userDetails = await User.findOne({ _id: req.body.user_id });
    		
    		if(userDetails) {
    			if (userDetails.status === 0)
                		return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });
            }

            /*if(req.body.buy_now == "true") {
                if(!userDetails.stripeSecretKey || !userDetails.stripePublicKey) {
                    return res.status(200).json({ status: "false", short_code: "block", message: res.__("Payout Preferences are not updated") });

                }
            }*/

        	if(req.body.item_id) {

                    
                    
 		        let itemDetail = await Product.findById(req.body.item_id).exec();

 		        if(itemDetail) {
	        		
	        		/*await Product.findByIdAndUpdate(itemDetail._id, { images: req.body.images, itemTitle: req.body.item_title, itemDesc: req.body.item_desc, price: req.body.price,
	        		CurrencyID: req.body.currency_id, locationID: req.body.location_id, productCondition: req.body.item_condition_id, 
	        		mainCategory: req.body.cat_id, subCategory: subcat_id, superCategory: supercat_id, itemType: req.body.item_type}, function (error, result) {
	                if (error) {
	                    // console.log(error);

	                    //return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });

						}                	
	            	});*/
	            	
	            	itemDetail.images = req.body.images;
	            	itemDetail.itemTitle = req.body.item_title;
	            	itemDetail.itemDesc = req.body.item_desc;
	            	itemDetail.price = req.body.price;
	            	itemDetail.CurrencyID = req.body.currency_id;
                    if(req.body.location_id) {
	            	  itemDetail.locationID = req.body.location_id;
                    } else {
                   
                      itemDetail.latitude = req.body.lat;
                      itemDetail.longitude = req.body.lon;
                      //loc = "["req.body.lon, req.body.lat"]";
                      lat = req.body.lat;
                      lon = req.body.lon;
                      itemDetail.location = {type:"Point",coordinates:[parseFloat(lon),parseFloat(lat)]};
                      itemDetail.locationName = req.body.location;
                    }
	            	itemDetail.productCondition = req.body.item_condition_id;
	            	itemDetail.mainCategory = req.body.cat_id;
	            	if(req.body.subcat_id) {
	            		itemDetail.subCategory = req.body.subcat_id;
	            	}
	            	if(req.body.supercat_id) {
	            		itemDetail.superCategory = req.body.supercat_id;
	            	}
	            	itemDetail.itemType = req.body.item_type;

                    if(req.body.buy_now) {
                        itemDetail.buynow = req.body.buy_now;
                        itemDetail.shippingprice = req.body.shipping_price;
                    }
                    itemDetail.postingDate = Date.now();
                    itemDetail.updateDate = Date.now();
	            	await itemDetail.save();


                    return res.status(200).json({ status: "true", item_id: req.body.item_id , message: res.__("Item edited successfully") });
	            } else {
	            	return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });

	            }

	        } else {

	        	let itemData = {};
	            itemData.itemTitle = req.body.item_title;
	            itemData.itemDesc = req.body.item_desc;
	            itemData.images = req.body.images;
	            itemData.price = req.body.price;
                itemData.shippingprice = req.body.shipping_price;
	            itemData.userId = req.body.user_id;
	            itemData.CurrencyID = req.body.currency_id;
                if(req.body.location_id) {
                      itemData.locationID = req.body.location_id;
                } else {
                      itemData.latitude = req.body.lat;
                      itemData.longitude = req.body.lon;
                      //loc = "["req.body.lon, req.body.lat"]";
                      lat = req.body.lat;
                      lon = req.body.lon;
                      itemData.location = {type:"Point",coordinates:[parseFloat(lon),parseFloat(lat)]};
                      itemData.locationName = req.body.location;
                }
	            itemData.productCondition = req.body.item_condition_id;
	            itemData.mainCategory = req.body.cat_id;
	            if(req.body.subcat_id) {
	            	itemData.subCategory = req.body.subcat_id;
	            }
	           	if(req.body.supercat_id) {
	           		itemData.superCategory = req.body.supercat_id;
	           	}
	            if(req.body.item_type) {
                    itemData.itemType = req.body.item_type;

                }
                itemData.buynow = req.body.buy_now;

	           	itemData.status = "1";
	           	itemData.featured = "0";
                itemData.productAvailability = "available";

	           	let product = new Product(itemData);
	           	//console.log(product);
            	await product.save(function (error, itemDetails) {
                if (!error) {
                	return res.status(200).json({ status: "true", item_id: itemDetails._id , message: res.__("Item added successfully") });

                } else {
                	console.log(error);
                    return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
                }
            });

  			}

        }
        catch (err) {
        	console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }

    }

};


exports.getHome = async function (req, res) {
    if (!req.query.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {
            let allCategories = await Category.find();

            
            let categoryList = [];
            
            /*allCategories.filter(function (mainCategory) {
                categoryList.push({
                    category_id: mainCategory._id,
                    category_name: mainCategory.name,
                    category_image: process.env.BASE_URL + process.env.CATEGORY_MEDIA_URL + mainCategory.image,
                });
            });*/

            for (var i = 0; i < allCategories.length; i++) {

                let subCategoryCount = await Subcategory.countDocuments({ parentCategory: allCategories[i]._id });


                categoryList.push({
                    category_id: allCategories[i]._id,
                    category_name: allCategories[i].name,
                    category_image: process.env.BASE_URL + process.env.CATEGORY_MEDIA_URL + allCategories[i].image,
                    sub_count: subCategoryCount,              

                });


            }

            let allBanners = await Banner.find({ status: '1' });
          
            let bannerList = [];
            allBanners.filter(function (bannerDetail) {
                bannerList.push({
                    banner_id: bannerDetail._id,
                    banner_link: bannerDetail.url,
                    banner_image: process.env.BASE_URL + process.env.BANNER_MEDIA_URL + bannerDetail.image,
                });
            });


            let featureProducts = await Product.find({ status: '1', featured: '1', }).limit(4).sort({postingDate: -1}).populate("CurrencyID");
            
            let itemList = [];

            for (var i = 0; i < featureProducts.length; i++) {

            	let productImg = JSON.parse(featureProducts[i].images);
                let itemStatus = (featureProducts[i].productAvailability) ? featureProducts[i].productAvailability : "available";


            	itemList.push({
                    item_id: featureProducts[i]._id,
                    item_title: featureProducts[i].itemTitle,
                    item_thumbimage: process.env.BASE_URL + process.env.PRODUCT_THUMB300_MEDIA_URL + productImg[0],
                    item_image: featureProducts[i].images,
                    item_price: featureProducts[i].price,
                    item_type: featureProducts[i].itemType,
                    currency: featureProducts[i].CurrencyID.currencysymbol,
                    featured: "true",
                    posted_date: featureProducts[i].postingDate,
                    item_status: itemStatus

                });


			}
            

            return res.status(200).json({ status: "true", invite_url: "http://onelink.to/5f8qj3", category: categoryList, banner: bannerList, featured_items:  itemList });
            //return res.status(200).json({ status_code: 200, category: categoryList });
        }
        catch (err) {
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};


exports.getItems = async function (req, res) {
    if (!req.query.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {


        	let getQuery = {};

        	if(req.query.cat_id) {
        		getQuery.mainCategory = req.query.cat_id;
        	}
        	if(req.query.subcat_id) {
        		getQuery.subCategory = req.query.subcat_id;
        	}
        	if(req.query.supercat_id) {
        		getQuery.superCategory = req.query.supercat_id;
        	}
        	if(req.query.location_id) {
        		getQuery.locationID = req.query.location_id;
        	}
            
        	if(req.query.item_condition_id) {
        		getQuery.productCondition = req.query.item_condition_id;
        	}
        	if(req.query.search_query) {
        		getQuery.itemTitle = { $regex: req.query.search_query, $options: "i" };
        	}
        	if(req.query.posted_within) {
        		if(req.query.posted_within == 'today') {
        			var start = moment().startOf('day'); 
					var end = moment().endOf('day');
					
					getQuery.postingDate =  {$gte: start, $lt: end};
        		}
        		if(req.query.posted_within == 'week') {
        			var start = moment().startOf('week'); 
					var end = moment().endOf('week');
					
					getQuery.postingDate =  {$gte: start, $lt: end};
        		}
        		if(req.query.posted_within == 'month') {
        			var start = moment().startOf('month'); 
					var end = moment().endOf('month');
					
					getQuery.postingDate =  {$gte: start, $lt: end};
        		}
        	}
        	if(req.query.sort_by) {
        		if(req.query.sort_by == 'htl') {
        			sortBy = {featured: -1, price: -1};
        		}
        		if(req.query.sort_by == 'lth') {
        			sortBy = {featured: -1, price: 1};
        		}
        		if(req.query.sort_by == 'recent') {
        			sortBy = {featured: -1, postingDate: -1};
        		}
        	} else {
        		sortBy = {featured: -1, postingDate: -1};

        	}
        	if(req.query.price_min && req.query.price_max) {

        		let min = parseInt(req.query.price_min);
  				let max = parseInt(req.query.price_max);
        		getQuery.price =  {$gte: min, $lt: max};

        	}
			getQuery.status = 1;

            getQuery.productAvailability = "available";

			if(req.query.offset) {
           		offset = parseInt(req.query.offset);
           	} else {
           		offset = 0;

           	}
           	if(req.query.limit) {
            	limit = parseInt(req.query.limit);
            } else {
            	limit = 10;
            }


            if(req.query.lat && req.query.lon && req.query.distance) {
                lat = parseFloat(req.query.lat);
                lon = parseFloat(req.query.lon);
                distance = req.query.distance * 1000;
                getQuery.location = { $near : {$maxDistance: distance, $geometry: {type:"Point" , coordinates: [parseFloat(lon),parseFloat(lat)]}}};

            }
//console.log(getQuery);

            let getProducts = await Product.find(getQuery).limit(limit).skip(offset).sort(sortBy).populate("CurrencyID");
            
            let itemList = [];

            for (var i = 0; i < getProducts.length; i++) {

            	let productImg = JSON.parse(getProducts[i].images);
                let itemStatus = (getProducts[i].productAvailability) ? getProducts[i].productAvailability : "available";

            	if(getProducts[i].featured == 1) {
            		feature_status = "true";
            	}  else {
            		feature_status = "false";
            	}

            	itemList.push({
                    item_id: getProducts[i]._id,
                    item_title: getProducts[i].itemTitle,
                    item_thumbimage: process.env.BASE_URL + process.env.PRODUCT_THUMB300_MEDIA_URL + productImg[0],
                    item_image: getProducts[i].images,
                    item_price: getProducts[i].price,
                    item_type: getProducts[i].itemType,
                    currency: getProducts[i].CurrencyID.currencysymbol,
                    featured: feature_status,
                    posted_date: getProducts[i].postingDate,
                    item_status: itemStatus

                });


			}
            

            return res.status(200).json({ status: "true", items:  itemList });
            //return res.status(200).json({ status_code: 200, category: categoryList });
        }
        catch (err) {
            console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};


exports.itemLike = async function (req, res) {
    if (!req.body.user_id || !req.body.item_id || !req.body.type || !req.body.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {

            userDetails = await User.findOne({ _id: req.body.user_id });

            const likeExists = await Like.findOne({ userId: req.body.user_id , itemId: req.body.item_id });

            const itemData = await Product.findOne({ _id: req.body.item_id }); 

            if(itemData.userId == req.body.user_id) {

                return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") }); 

            }

            //console.log(likeExists.itemId.userId);

            if(req.body.type == 'like') {

                if (likeExists) {

                    return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") }); 
                } else {
                    let itemlikeData = {};
                    itemlikeData.userId = req.body.user_id;
                    itemlikeData.itemId = req.body.item_id;

                    let itemlike = new Like(itemlikeData);
                    await itemlike.save(function (error, itemlikeDetails) {
                        if (!error) {
                           
                            let logMessage = userDetails.name + " " + res.__("liked your product");
                            logController.createLog(userDetails._id, itemData.userId, itemData._id, "0", "like", logMessage);

                            let userUpdate = User.findByIdAndUpdate(itemData.userId, {$inc : {'notificationCount' : 1}} );

                            let messageData = {};
                            let itemDetail = {};
                            let likes = [];
                            itemDetail.type = "liked";
                            itemDetail.id = itemData._id;
                            messageData.body = "Likes your product '" + itemData.itemTitle + "'";
                            messageData.title = userDetails.name;
                            likes.push(itemData.userId);
                              console.log('messageData: ',messageData);
                            fcmController.sendNotification(likes, messageData, itemDetail);


                            return res.status(200).json({ status: "true", message: res.__("Item liked") });

                        } else {
                            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") }); 

                        }
                    });

                }

            } else {

                if (!likeExists) {
                    return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") }); 
                } else {

                    Like.deleteOne({ itemId: req.body.item_id , userId: req.body.user_id }, function(err) {
                        if (!err) {
                            return res.status(200).json({ status: "true", message: res.__("Item unliked") });
                        }
                        else {
                            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") }); 
                        }
                    });

                }

            }

        }
        catch (err) {
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
          
    }
};


exports.itemReport = async function (req, res) {
    if (!req.body.user_id || !req.body.item_id || !req.body.type || !req.body.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {

            const reportExists = await Report.findOne({ userId: req.body.user_id , itemId: req.body.item_id });

            const itemData = await Product.findOne({ _id: req.body.item_id }); 

            if(itemData.userId == req.body.user_id) {

                return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") }); 

            }


            if(req.body.type == 'report') {

                if (reportExists) {

                    return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") }); 
                } else {

                    lastreportDate = Date.now();

                    await Product.findByIdAndUpdate(req.body.item_id, {$inc : {'reportCount' : 1}, reportDate: lastreportDate} );


                    let itemreportData = {};
                    itemreportData.userId = req.body.user_id;
                    itemreportData.itemId = req.body.item_id;

                    let itemreport = new Report(itemreportData);
                    await itemreport.save(function (error, itemreportDetails) {
                        if (!error) {
                            return res.status(200).json({ status: "true", message: res.__("Item reported") });

                        } else {
                            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") }); 

                        }
                    });

                }

            } else {

                if (!reportExists) {
                    return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") }); 
                } else {


                    await Product.findByIdAndUpdate(req.body.item_id, {$inc : {'reportCount' : -1}} );


                    Report.deleteOne({ itemId: req.body.item_id , userId: req.body.user_id }, function(err) {
                        if (!err) {
                            return res.status(200).json({ status: "true", message: res.__("Item undo reported") });
                        }
                        else {
                            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") }); 
                        }
                    });

                }

            }

        }
        catch (err) {
            console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
          
    }
};


exports.itemDetails = async function (req, res) {
    if (!req.query.lang_code || !req.query.item_id) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {
            

            let getProducts = await Product.findOne({ _id: req.query.item_id }).populate("locationID").populate("userId").populate("productCondition").populate("CurrencyID").populate("mainCategory").populate("subCategory").populate("superCategory");
            
            let itemexists = await Product.countDocuments({ _id: req.query.item_id });

            if (itemexists == 0)
                return res.status(200).json({ status: "false", short_code: "block", message: res.__("Item is not available") });
                
            if (getProducts.status === 0)
                return res.status(200).json({ status: "false", short_code: "block", message: res.__("Product has been disabled by Admin") });
                
            

                //console.log(getProducts.length);
                if(req.query.user_id) {

                    const likeExists = await Like.findOne({ userId: req.query.user_id , itemId: req.query.item_id });

                    if(likeExists) {
                        liked = "true";
                    } else {
                        liked = "false";
                    }

                    const reportExists = await Report.findOne({ userId: req.query.user_id , itemId: req.query.item_id });

                    if(reportExists) {
                        reported = "true";
                    } else {
                        reported = "false";
                    }

                } else {

                    liked = "false";
                    reported = "false";
                }

                if(getProducts.featured == 1) {
                    feature_status = "true";
                }  else {
                    feature_status = "false";
                }

                let profileImage = (getProducts.userId.image) ? process.env.BASE_URL + process.env.USER_THUMB100_URL + getProducts.userId.image : "";
                let itemStatus = (getProducts.productAvailability) ? getProducts.productAvailability : "available";
                let sharelink = (getProducts.sharelink) ? getProducts.sharelink : "";

                let sellerItemsCount = await Product.countDocuments({ userId: getProducts.userId._id });


                if(!getProducts.subCategory) {

                     subCategoryId = "";
                     subCategoryName = "";

                } else {

                     subCategoryId = (getProducts.subCategory._id) ? getProducts.subCategory._id : "";
                     subCategoryName = (getProducts.subCategory.name) ? getProducts.subCategory.name : "";

                }

                if(!getProducts.superCategory) {
                    
                     superCategoryId = "";
                     superCategoryName = "";
                
                } else {

                     superCategoryId = (getProducts.superCategory._id) ? getProducts.superCategory._id : "";
                     superCategoryName = (getProducts.superCategory.name) ? getProducts.superCategory.name : "";

                }

                if(getProducts.locationID) {
                    locationId = getProducts.locationID._id;
                    locationName = getProducts.locationID.name;
                    lat = "";
                    lon = "";

                } else {
                    locationId = "";
                    locationName = getProducts.locationName;
                    lat = getProducts.latitude;
                    lon = getProducts.longitude;
                }

                itemList = {
                    item_id: getProducts._id,
                    item_title: getProducts.itemTitle,
                    item_images: getProducts.images,
                    item_price: getProducts.price,
                    item_type: getProducts.itemType,
                    buy_now: getProducts.buynow,
                    currency: getProducts.CurrencyID.currencysymbol,
                    currency_code: getProducts.CurrencyID.currencycode,
                    featured: feature_status,
                    posted_date: getProducts.postingDate,
                    description: getProducts.itemDesc,
                    location_id: locationId,
                    location: locationName,
                    lat: lat,
                    lon: lon,
                    seller_id: getProducts.userId._id,
                    seller_name: getProducts.userId.name,
                    seller_image: profileImage,
                    seller_join: getProducts.userId.createdAt, 
                    seller_ratings: getProducts.userId.rating,
                    seller_reviews: getProducts.userId.reviews,
                    liked: liked,
                    reported: reported,
                    share_url: "",
                    item_status: itemStatus,
                    item_condition_id: getProducts.productCondition._id,
                    item_condition_name: getProducts.productCondition.name,
                    category_id: getProducts.mainCategory._id,
                    category_name: getProducts.mainCategory.name,
                    sub_category_id: subCategoryId,
                    sub_category_name: subCategoryName,
                    super_category_id: superCategoryId,
                    super_category_name: superCategoryName,
                    currency_id: getProducts.CurrencyID._id,
                    share_link: sharelink,
                    seller_items: sellerItemsCount,
                    shipping_price: getProducts.shippingprice
                };


           // }
            

            return res.status(200).json({ status: "true", result:  itemList });

        }
        catch (err) {
            console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};


exports.sellerItems = async function (req, res) {
    if (!req.query.lang_code || !req.query.seller_id) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {

        try {

            if(req.query.offset) {
                offset = parseInt(req.query.offset);
            } else {
                offset = 0;

            }
            if(req.query.limit) {
                limit = parseInt(req.query.limit);
            } else {
                limit = 10;
            }

                
            let getProducts = await Product.find( { userId: req.query.seller_id , $nor: [ { _id: req.query.item_id } ] } ).limit(limit).skip(offset).sort({updatedAt: -1}).populate("CurrencyID");
            
            

            //console.log(getProducts);
            let itemList = [];

            for (var i = 0; i < getProducts.length; i++) {

                let productImg = JSON.parse(getProducts[i].images);
                let itemStatus = (getProducts[i].productAvailability) ? getProducts[i].productAvailability : "available";


                if(getProducts[i].featured == 1) {
                    feature_status = "true";
                }  else {
                    feature_status = "false";
                }

                itemList.push({
                    item_id: getProducts[i]._id,
                    item_title: getProducts[i].itemTitle,
                    item_thumbimage: process.env.BASE_URL + process.env.PRODUCT_THUMB300_MEDIA_URL + productImg[0],
                    item_image: getProducts[i].images,
                    item_price: getProducts[i].price,
                    item_type: getProducts[i].itemType,
                    currency: getProducts[i].CurrencyID.currencysymbol,
                    featured: feature_status,
                    posted_date: getProducts[i].postingDate,
                    item_status: itemStatus
                });


            }
            

            return res.status(200).json({ status: "true", items:  itemList });
            

            
        }
        catch (err) {
           // console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};


exports.changeitemStatus = async function (req, res) {
    if (!req.body.user_id || !req.body.item_id || !req.body.type || !req.body.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {

            const itemData = await Product.findOne({ _id: req.body.item_id }); 

            if(itemData.userId != req.body.user_id) {

                return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") }); 

            }

            //console.log(likeExists.itemId.userId);

            itemData.productAvailability = req.body.type;

            await itemData.save();

            if(req.body.type == "sold") {
                
                return res.status(200).json({ status: "true", message: res.__("Item changed as sold") });

            } else {

                return res.status(200).json({ status: "true", message: res.__("Item changed as available") });

            }
            

        }
        catch (err) {
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
          
    }
};


exports.setshareLink = async function (req, res) {
    if (!req.body.user_id || !req.body.item_id || !req.body.link || !req.body.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {

            const itemData = await Product.findOne({ _id: req.body.item_id }); 

            itemData.sharelink = req.body.link;

            await itemData.save();

            
            return res.status(200).json({ status: "true", message: res.__("Share link added") });


        }
        catch (err) {
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
          
    }
};


exports.likedItems = async function (req, res) {
    if (!req.query.lang_code || !req.query.user_id) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {

        try {

            if(req.query.offset) {
                offset = parseInt(req.query.offset);
            } else {
                offset = 0;

            }
            if(req.query.limit) {
                limit = parseInt(req.query.limit);
            } else {
                limit = 10;
            }

                
            let getProducts = await Like.find( { userId: req.query.user_id } ).limit(limit).skip(offset).sort({updatedAt: -1}).populate("itemId");
            
            

            //console.log(getProducts);
            let itemList = [];

            for (var i = 0; i < getProducts.length; i++) {

                const currencyData = await Currency.findOne({ _id: getProducts[i].itemId.CurrencyID }); 

                let productImg = JSON.parse(getProducts[i].itemId.images);
                let itemStatus = (getProducts[i].itemId.productAvailability) ? getProducts[i].itemId.productAvailability : "available";


                if(getProducts[i].itemId.featured == 1) {
                    feature_status = "true";
                }  else {
                    feature_status = "false";
                }

                itemList.push({
                    item_id: getProducts[i].itemId._id,
                    item_title: getProducts[i].itemId.itemTitle,
                    item_thumbimage: process.env.BASE_URL + process.env.PRODUCT_THUMB300_MEDIA_URL + productImg[0],
                    item_image: getProducts[i].itemId.images,
                    item_price: getProducts[i].itemId.price,
                    item_type: getProducts[i].itemId.itemType,
                    currency: currencyData.currencysymbol,
                    featured: feature_status,
                    posted_date: getProducts[i].itemId.postingDate,
                    item_status: itemStatus
                });


            }
            

            return res.status(200).json({ status: "true", items:  itemList });
            

            
        }
        catch (err) {
           // console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};


exports.getPromotions = async function (req, res) {
    if (!req.body.lang_code || !req.body.user_id) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {

        try{

            let getPromotions = await Promotion.find();
            
            let settings = await Setting.findOne({}).limit(1);

            console.log(settings.promotioncurrencysymbol);

            //console.log(getProducts);
            let promotionList = [];

            for (var i = 0; i < getPromotions.length; i++) {


                promotionList.push({
                    id: getPromotions[i]._id,
                    name: getPromotions[i].name,
                    days: getPromotions[i].duration,
                    price: getPromotions[i].price,
                    currency_sym: settings.promotioncurrencysymbol,
                    currency_code: settings.promotioncurrencycode,
                });


            }
            

            return res.status(200).json({ status: "true", result:  promotionList });
            

            
        }
        catch (err) {
            console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};


exports.mypromotion = async function (req, res) {
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


                
            let getPromotions = await Userpromotion.find( { userId: req.body.user_id } ).limit(limit).skip(offset).sort({activeOn: -1}).populate("itemId").populate("promotionId");
            
            if (getPromotions.length == 0)
                  return res.status(200).json({ status: "false", message:  "No promotions found" });


            console.log(getPromotions);
            let promotionList = [];

            for (var i = 0; i < getPromotions.length; i++) {

                var today = new Date();
                var expireOn = getPromotions[i].expireOn;

                if(expireOn.getTime() > today.getTime()){

                    activeStatus = "Active";
                } else {

                    activeStatus = "Expired";
                }

                if(getPromotions[i].itemId) {

                    itemId = getPromotions[i].itemId._id;
                    itemTitle  = getPromotions[i].itemId.itemTitle;

                    let productImg = JSON.parse(getPromotions[i].itemId.images);
                    itemImage = process.env.BASE_URL + process.env.PRODUCT_THUMB300_MEDIA_URL + productImg[0];

                } else {

                    itemId = "";
                    itemTitle  = "";
                    itemImage = "";

                }

                promotionList.push({
                    id: getPromotions[i].promotionId._id,
                    name: getPromotions[i].promotionId.name,
                    days: getPromotions[i].promotionId.duration,
                    price: getPromotions[i].promotionId.price,
                    currency_sym: getPromotions[i].currencySymbol,
                    currency_code: getPromotions[i].currencyCode,
                    active_on: getPromotions[i].activeOn,
                    expired_on: getPromotions[i].expireOn,
                    status: activeStatus,
                    item_id: itemId,
                    item_name: itemTitle,
                    item_image: itemImage
                });


            }
            

            return res.status(200).json({ status: "true", result:  promotionList });
            

            
        }
        catch (err) {
            console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};


exports.itemdelete = async function (req, res) {
    if (!req.body.user_id || !req.body.item_id || !req.body.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {


            let productDetails = await Product.findOne({ _id: req.body.item_id});

            let productImg = JSON.parse(productDetails.images);

            for (var i = 0; i < productImg.length; i++) {
                let imageName = productImg[i];
                fs.unlinkSync('../storage/app/public/products/original/'+ imageName);
                fs.unlinkSync('../storage/app/public/products/thumb300/'+ imageName);
                
            }

            Product.deleteOne({ _id: req.body.item_id , userId: req.body.user_id }).exec();
            Like.deleteMany({ itemId: req.body.item_id }).exec();

            
            return res.status(200).json({ status: "true", message: res.__("Item deleted successfully") });
            

        }
        catch (err) {
            console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
          
    }
};
