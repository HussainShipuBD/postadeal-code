const express = require("express");
const router = express.Router();

// auth middleware
const authMiddleware = require("../middlewares/auth");

// controllers
const userController = require("../controllers/userController");
const categoryController = require("../controllers/categoryController");
const productpropertiesController = require("../controllers/productpropertiesController");
const adminController = require("../controllers/adminController");
const reviewController = require("../controllers/reviewController");
const paymentController = require("../controllers/paymentController");
const chatController = require("../controllers/chatController");
const logController = require("../controllers/logController");
const devicetokenController = require("../controllers/devicetokenController");
const productController = require("../controllers/productController");
const addressController = require("../controllers/addressController");


// user routes
router.post("/user/signup", userController.signUp);
router.post("/user/signin", userController.signIn);
router.post("/user/sociallogin", userController.socialLogin);
router.post("/user/forgotpassword", userController.forgotPassword);
router.get("/user/onetimefee", userController.oneTimeFee);
router.post("/user/registerdevice", devicetokenController.registerDevice);
router.post("/user/removedevice", authMiddleware.userJwt, devicetokenController.removedevice);
router.get("/category/getparentcategory/:lang_code?", categoryController.parentCategories);
router.get("/category/getsubcategories/:lang_code?/:category_id?", categoryController.getSubcategories);
router.get("/product/propertydetails/:lang_code?", productpropertiesController.productProperties);
router.get("/product/getlocation/:lang_code?/:search_query?/:offset?/:limit?", productpropertiesController.getLocation);
router.get("/product/gethome/:lang_code?", productController.getHome);
router.get("/product/getitems/:lang_code?", productController.getItems);


router.post("/product/add", authMiddleware.userJwt, productController.addProduct);
router.post("/product/itemlike", authMiddleware.userJwt, productController.itemLike);
router.post("/product/itemreport", authMiddleware.userJwt, productController.itemReport);
router.get("/product/itemdetails/:lang_code?/:item_id?", productController.itemDetails);
router.get("/product/selleritems/:lang_code?/:seller_id?", productController.sellerItems);
router.post("/product/changeitemstatus", authMiddleware.userJwt, productController.changeitemStatus);
router.get("/product/likeditems/:lang_code?/:user_id?", productController.likedItems);
router.post("/product/setsharelink", authMiddleware.userJwt, productController.setshareLink);
router.post("/product/itemdelete", authMiddleware.userJwt, productController.itemdelete);



router.post("/user/editprofile", authMiddleware.userJwt, userController.editProfile);
router.get("/user/getprofile/:lang_code?/:user_id?", userController.getProfile);
router.post("/user/changepassword", authMiddleware.userJwt, userController.changePassword);
router.post("/user/verifymail", userController.verifyMail);

router.post("/chat/createchat", authMiddleware.userJwt, chatController.createChat);
router.post("/chat/postmessage", authMiddleware.userJwt, chatController.postMessage);
router.post("/chat/getchats", authMiddleware.userJwt, chatController.getChats);
router.post("/chat/getmessages", authMiddleware.userJwt, chatController.getMessages);
router.post("/chat/readmessage", authMiddleware.userJwt, chatController.readMessage);
router.post("/chat/chatblock", authMiddleware.userJwt, chatController.chatBlock);
router.post("/chat/readmessage", authMiddleware.userJwt, chatController.readMessage);
router.post("/chat/onlineupdate", authMiddleware.userJwt, chatController.onlineUpdate);
router.post("/chat/chatclear", authMiddleware.userJwt, chatController.chatclear);


router.get("/help/:lang_code?", adminController.appHelps);
router.post("/contactus", adminController.contactAdmin);
router.get("/termsandconditions", adminController.termsandconditions);
router.get("/privacypolicy", adminController.privacypolicy);


router.post("/log/getnotification", authMiddleware.userJwt, logController.getNotification);
router.post("/log/getunreadcount", authMiddleware.userJwt, logController.getUnreadcount);


router.post("/payment/balancesheet", authMiddleware.userJwt, paymentController.balancesheet);
router.post("/payment/buynowpayment", authMiddleware.userJwt, paymentController.buynowpayment);
router.post("/payment/myorders", authMiddleware.userJwt, paymentController.myorders);
router.post("/payment/mysales", authMiddleware.userJwt, paymentController.mysales);
router.post("/payment/orderdetails", authMiddleware.userJwt, paymentController.orderdetails);
router.post("/payment/markdelivered", authMiddleware.userJwt, paymentController.markasDelivered);
router.post("/payment/markcancelled", authMiddleware.userJwt, paymentController.markasCancelled);

router.post("/review/writereview", authMiddleware.userJwt, reviewController.writereview);
router.get("/review/getreviews", reviewController.getreviews);

router.post("/product/getpromotion", authMiddleware.userJwt, productController.getPromotions);
router.post("/payment/promotionbalancesheet", authMiddleware.userJwt, paymentController.promotionbalancesheet);
router.post("/payment/paypromotion", authMiddleware.userJwt, paymentController.paypromotion);
router.post("/product/mypromotion", authMiddleware.userJwt, productController.mypromotion);

router.post("/address/addaddress", authMiddleware.userJwt, addressController.addaddress);
router.post("/address/deleteaddress", authMiddleware.userJwt, addressController.deleteaddress);
router.post("/address/myaddress", authMiddleware.userJwt, addressController.myaddress);



module.exports = router;
