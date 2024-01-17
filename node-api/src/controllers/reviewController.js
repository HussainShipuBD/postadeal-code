const mongoose = require("mongoose");

const User = require('../models/userModel');
const Review = require('../models/reviewModel');
const Order = require('../models/orderModel');
const Product = require('../models/productModel');

// fcm service
const fcmService = require('../controllers/fcmController');

const logController = require("../controllers/logController");

exports.writereview = async function (req, res) {
    if (!req.body.lang_code || !req.body.user_id || !req.body.item_id || !req.body.seller_id || !req.body.order_id | !req.body.rating_count || !req.body.review_message) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {

            let userDetails = await User.findOne({ _id: req.body.user_id });

            if (userDetails.status === 0)
            return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });

            if (req.body.review_id) {

                let reviewDetails = await Review.findById(req.body.review_id);

                if (!reviewDetails)
                  return res.status(200).json({ status: "true", result:  "Review doesn't Exists" });

                reviewDetails.rating = req.body.rating_count;
                reviewDetails.message = req.body.review_message;
                reviewDetails.save();

                sellerRatings(reviewDetails.sellerId);

                
                return res.status(200).json({ status: "true", message:  "Review updated successfully" });
            }
            else {

                let orderDetails = await Order.findById(req.body.order_id);

                if (!orderDetails)
                  return res.status(200).json({ status: "true", result:  "Order doesn't Exists" });

                let reviewData = {};

                reviewData.userId = userDetails._id;
                reviewData.sellerId = req.body.seller_id;
                reviewData.itemId = req.body.item_id;
                reviewData.orderId = req.body.order_id;
                reviewData.rating = req.body.rating_count;
                reviewData.message = req.body.review_message;
                reviewData.reviewDate = Date.now();

                let newReview = new Review(reviewData);
                await newReview.save(function (error, reviewDetails) {
                    if (!error) {
                        sellerRatings(reviewData.sellerId);
                        return res.status(200).json({ status: "true", message:  "Review posted successfully" });
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

exports.getreviews = async function (req, res) {
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

            let userReviews = await Review.find({"sellerId": req.query.user_id}).populate("userId").populate("itemId").sort({ "reviewDate": -1 }).limit(limit).skip(offset);

            if (userReviews.length === 0)
                 return res.status(200).json({ status: "true", result:  "No Reviews Found" });

            let reviewList = [];

            for (var i = 0; i < userReviews.length; i++) {


                let productImg = JSON.parse(userReviews[i].itemId.images);
                let userImage = (userReviews[i].userId.image) ? process.env.BASE_URL + process.env.USER_THUMB100_URL + userReviews[i].userId.image : "";

                reviewList.push({
                        review_id: userReviews[i]._id,
                        rating: userReviews[i].rating,
                        review: userReviews[i].message,
                        item_id: userReviews[i].itemId._id,
                        item_name: userReviews[i].itemId.itemTitle,
                        item_image: process.env.BASE_URL + process.env.PRODUCT_THUMB300_MEDIA_URL + productImg[0],
                        user_id: userReviews[i].userId._id,
                        user_name: userReviews[i].userId.name,
                        user_image: userImage,
                        date: userReviews[i].reviewDate

                });

            }

                return res.status(200).json({ status: "true", result:  reviewList });

        }
        catch (err) {
                return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};

let sellerRatings = async function (sellerId) {

    let totalReviews = await Review.countDocuments({ sellerId: mongoose.Types.ObjectId(sellerId) });

    if (totalReviews) {

        let totalRatings = await Review.aggregate([{ $match: { sellerId: mongoose.Types.ObjectId(sellerId) } }, {
            $group: {
                _id: "sellerId", total: {
                    $sum: {
                        $toDouble: "$rating"
                    }
                }
            }
        }]).exec();

        let sellerratings = (totalRatings[0].total) ? parseFloat(totalRatings[0].total / totalReviews) : 0;

        if (sellerratings) {
            User.findByIdAndUpdate(sellerId, { reviews: totalReviews, rating: sellerratings.toFixed(1) }, function (error, result) {
                if (error) {
                    // console.log(error);
                }
            });
        }

    }
};