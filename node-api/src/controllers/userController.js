const { v4: uuidv4 } = require('uuid');
const { nanoid } = require('nanoid');

// auth middleware
const userAuth = require("../middlewares/auth");

// models
const User = require('../models/userModel');
const Banner = require('../models/bannerModel');
const Category = require('../models/categoryModel');
const Subcategory = require('../models/subcategoryModel');

const Setting = require('../models/settingModel');
const Review = require('../models/reviewModel');


// email service
const mailerController = require('./mailController');

const logController = require("../controllers/logController");


exports.oneTimeFee = async function (req, res) {
    try {
        let settingDetail = {};    
        settingDetail = await Setting.findOne(); 

        var e = JSON.parse(JSON.stringify(settingDetail))
        
        // return res.json({key: "key: " + e.privateKey, setting: settingDetail, status: 'true'});
        
        
        const stripe = require('stripe')(e.privateKey);
        const price = await stripe.prices.retrieve(
            'price_1JtILlFG3E1gkIPmeUT7BvUT'
            );

        const customer = await stripe.customers.create();

        const ephemeralKey = await stripe.ephemeralKeys.create(
            {customer: customer.id},
            {apiVersion: '2020-08-27'}
        );


        const paymentIntent = await stripe.paymentIntents.create({
            amount: price.unit_amount,
            currency: price.currency,
            customer: customer.id,
        });

        return res.status(200).json({
            paymentIntent: paymentIntent.client_secret,
            ephemeralKey: ephemeralKey.secret,
            customer: customer.id
                                
        })
        
    } catch (err) {
        return res.status(401).json(err);
    }
}


exports.signUp = async function (req, res) {
//console.log("hai");
    if (!req.body.full_name || !req.body.email || !req.body.password || !req.body.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {

            const emailExists = await User.findOne({ email: req.body.email })

            if (emailExists)
                return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Email Already exists") }); 
                
            let settingDetail = {};    
            settingDetail = await Setting.findOne(); 

            let userData = {};
            userData.name = req.body.full_name;
            userData.userId = uuidv4();
            userData.email = req.body.email.replace(/\s+/g, '');
            userData.password = req.body.password;
            
            
           	userData.emailVerification = "0";
           	email_verification = "false";
           	userData.status = "1";
           
           	userData.notificationCount = "1";
            

            let user = new User(userData);
            await user.save(function (error, userDetails) {
                if (!error) {

                    //let profileImage = (userDetails.image) ? process.env.BASE_URL + process.env.USER_MEDIA_URL + userDetails.image : "";

                    // welcome mail
                    let mailData = {};
                    mailData.to = req.body.email;
                    mailData.userid = userDetails._id;
                    mailData.purpose = "verify";
                    mailData.subject = res.__("Welcome Mail");
                    mailData.title = res.__("Welcome to") + " " + settingDetail.siteName;
                    mailData.message = res.__("Your user account is registered successfully. Signin to continue to your account");
                    mailData.message_details = res.__("Please click on the button below to verify your email address!");
                    mailerController.sendMail(mailData); 

                    let logMessage = res.__("Hello") + " " + userDetails.name + "! , " + res.__("Welcome to the") + " " + settingDetail.siteName;
                    logController.createLog(userDetails._id, userDetails._id, userDetails._id, "admin", logMessage);

                    

                    return res.status(200).json({
                        status: "true",
                        result:{
                        user_id: userDetails._id,
                        auth_token: userAuth.createJwt(userDetails),
                        full_name: userDetails.name,
                        email: userDetails.email,
                        phone: "",
                        user_image: "",
                        fb_id: "",
                        google_id:"",
                        fb_verification:"false",
                        mail_verification:email_verification,
                        email_notification: userDetails.emailNotification,
                        push_notification: userDetails.pushNotification,
                        ratings: "",
                        reviews: "",
                        stripe_secretkey: "",
                        stripe_publickey: "",
                            
                        user_join: userDetails.createdAt
                        }
                    });
                } else {
                	console.log(error);
                    return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
                }
            });
        }
        catch (err) {
        	console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};

exports.socialLogin = async function (req, res) {
//console.log("hai");
    if(req.body.google_id && req.body.email) {
     try {
    	
    		//userDetails = await User.findOne({ googleId: req.body.google_id });

    		userDetails = await User.findOne({$or: [{ googleId: req.body.google_id, email: req.body.email } , { facebookId: req.body.fb_id, email: req.body.email }]});
    		
    		if(userDetails) {
    			if (userDetails.status === 0)
                		return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });
                	
            //let profileImage = (userDetails.image) ? process.env.BASE_URL + process.env.USER_MEDIA_URL + userDetails.image : "";
            let profileImage = (userDetails.image) ? process.env.BASE_URL + process.env.USER_THUMB100_URL + userDetails.image : "";		    
		    let phone = (userDetails.mobile) ? userDetails.mobile : "";
		    let fb_id = (userDetails.facebookId) ? userDetails.facebookId : "";
		    let google_id = (userDetails.googleId) ? userDetails.googleId : "";
		    let stripeSecretKey = (userDetails.stripeSecretKey) ? userDetails.stripeSecretKey : "";
		    let stripePublicKey = (userDetails.stripePublicKey) ? userDetails.stripePublicKey : "";


		    if(userDetails.emailVerification == '1'){
		    	email_verification = "true";
		    } else {
		    	email_verification = "false";
		    }
		    
		    if(userDetails.fbVerification == '1'){
		    	fb_verification = "true";
		    } else {
		    	fb_verification = "false";
		    }

		    
		    return res.status(200).json({
		                status: "true",
		                result:{
		                user_id: userDetails._id,
		                auth_token: userAuth.createJwt(userDetails),
		                full_name: userDetails.name,
		                email: userDetails.email,
		                phone: phone,
		                user_image: profileImage,
		                fb_id: fb_id,
		                google_id:google_id,
		                fb_verification:fb_verification,
		                mail_verification:email_verification,
		                email_notification: userDetails.emailNotification,
                        push_notification: userDetails.pushNotification,
                        ratings: userDetails.rating,
                        reviews: userDetails.reviews,
                        stripe_secretkey: stripeSecretKey,
                        stripe_publickey: stripePublicKey,
                        user_join: userDetails.createdAt
		                }
		            });

    		} else {
    		
    		    const emailExists = await User.findOne({ email: req.body.email })

		    if (emailExists)
		        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Email Already exists") }); 
		       
		    let userData = {};
		    userData.name = req.body.full_name;
		    userData.userId = uuidv4();
		    userData.email = req.body.email.replace(/\s+/g, '');
		    userData.googleId = req.body.google_id;
		    
		    userData.emailVerification = "1";

            userData.notificationCount = "1";

		    
		   // userData.createdAt = Date.now();

		   let user = new User(userData);
		    await user.save(function (error, userDetails) {
		    
		        if (!error) {

		        	let profileImage = (userDetails.image) ? process.env.BASE_URL + process.env.USER_THUMB100_URL + userDetails.image : "";
		            //let profileImage = (userDetails.image) ? process.env.BASE_URL + process.env.USER_MEDIA_URL + userDetails.image : "";
		            let phone = (userDetails.mobile) ? userDetails.mobile : "";
		    	    let fb_id = (userDetails.facebookId) ? userDetails.facebookId : "";
		    	    let google_id = (userDetails.googleId) ? userDetails.googleId : "";
					let stripeSecretKey = (userDetails.stripeSecretKey) ? userDetails.stripeSecretKey : "";
		    		let stripePublicKey = (userDetails.stripePublicKey) ? userDetails.stripePublicKey : "";

		    	    let logMessage = res.__("Hello") + " " + userDetails.name + "! , " +res.__("Welcome to the Classibuy");
                    logController.createLog(userDetails._id, userDetails._id, userDetails._id, "admin", logMessage);

		            return res.status(200).json({
		                status: "true",
		                result:{
		                user_id: userDetails._id,
		                auth_token: userAuth.createJwt(userDetails),
		                full_name: userDetails.name,
		                email: userDetails.email,
		                phone: phone,
		                user_image: profileImage,
		                fb_id: fb_id,
		                google_id:google_id,
		                fb_verification:"false",
		                mail_verification:"true",
		                email_notification: userDetails.emailNotification,
                        push_notification: userDetails.pushNotification,
                        ratings: "",
                        reviews: "",                       
                        stripe_secretkey: stripeSecretKey,
                        stripe_publickey: stripePublicKey,
                        user_join: userDetails.createdAt
		                }
		            });
	    		
    			}
    	
    		}); 
    		} 
    	} catch (err) {
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    	
    
    } else if(req.body.fb_id && req.body.email) {
    
    	try {
    	
    		userDetails = await User.findOne({$or: [{ googleId: req.body.google_id, email: req.body.email } , { facebookId: req.body.fb_id, email: req.body.email }]});
    		
    		if(userDetails) {
    			if (userDetails.status === 0)
                		return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });
                	
            //let profileImage = (userDetails.image) ? process.env.BASE_URL + process.env.USER_MEDIA_URL + userDetails.image : "";
		    let profileImage = (userDetails.image) ? process.env.BASE_URL + process.env.USER_THUMB100_URL + userDetails.image : "";
		    let phone = (userDetails.mobile) ? userDetails.mobile : "";
		    let fb_id = (userDetails.facebookId) ? userDetails.facebookId : "";
		    let google_id = (userDetails.googleId) ? userDetails.googleId : "";
		    let stripeSecretKey = (userDetails.stripeSecretKey) ? userDetails.stripeSecretKey : "";
		    let stripePublicKey = (userDetails.stripePublicKey) ? userDetails.stripePublicKey : "";

		    if(userDetails.emailVerification == '1'){
		    	email_verification = "true";
		    } else {
		    	email_verification = "false";
		    }
		    
		    if(userDetails.fbVerification == '1'){
		    	fb_verification = "true";
		    } else {
		    	fb_verification = "false";
		    }

		    
		    return res.status(200).json({
		                status: "true",
		                result:{
		                user_id: userDetails._id,
		                auth_token: userAuth.createJwt(userDetails),
		                full_name: userDetails.name,
		                email: userDetails.email,
		                phone: phone,
		                user_image: profileImage,
		                fb_id: fb_id,
		                google_id:google_id,
		                fb_verification:fb_verification,
		                mail_verification:email_verification,
		                email_notification: userDetails.emailNotification,
                        push_notification: userDetails.pushNotification,
                        ratings: userDetails.rating,
                        reviews: userDetails.reviews,                      
                        stripe_secretkey: stripeSecretKey,
                        stripe_publickey: stripePublicKey,
                        user_join: userDetails.createdAt
		                }
		            });

    		} else {
    		
    		    const emailExists = await User.findOne({ email: req.body.email })

		    if (emailExists)
		        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Email Already exists") }); 
		       
		    let userData = {};
		    userData.name = req.body.full_name;
		    userData.userId = uuidv4();
		    userData.email = req.body.email.replace(/\s+/g, '');
		    userData.facebookId = req.body.fb_id;
		    
		    userData.emailVerification = "1";
		    userData.fbVerification = "1";

           	userData.notificationCount = "1";

		    
		   // userData.createdAt = Date.now();

		    let user = new User(userData);
		    await user.save(function (error, userDetails) {
		        if (!error) {

		            let profileImage = (userDetails.image) ? process.env.BASE_URL + process.env.USER_THUMB100_URL + userDetails.image : "";
		            let phone = (userDetails.mobile) ? userDetails.mobile : "";
		    	    let fb_id = (userDetails.facebookId) ? userDetails.facebookId : "";
		    	    let google_id = (userDetails.googleId) ? userDetails.googleId : "";
		    	    let stripeSecretKey = (userDetails.stripeSecretKey) ? userDetails.stripeSecretKey : "";
		    	    let stripePublicKey = (userDetails.stripePublicKey) ? userDetails.stripePublicKey : "";

		    	    let logMessage = res.__("Hello") + " " + userDetails.name + "! , " +res.__("Welcome to the Classibuy");
                    logController.createLog(userDetails._id, userDetails._id, userDetails._id, "admin", logMessage);

		            return res.status(200).json({
		                status: "true",
		                result:{
		                user_id: userDetails._id,
		                auth_token: userAuth.createJwt(userDetails),
		                full_name: userDetails.name,
		                email: userDetails.email,
		                phone: phone,
		                user_image: profileImage,
		                fb_id: fb_id,
		                google_id:google_id,
		                fb_verification:"true",
		                mail_verification:"true",
		                email_notification: userDetails.emailNotification,
                        push_notification: userDetails.pushNotification,
                        ratings: "",
                        reviews: "",                       
                        stripe_secretkey: stripeSecretKey,
                        stripe_publickey: stripePublicKey,
                        user_join: userDetails.createdAt
		                }
		            });
	    		
    			}
    	
    		}); 
    		} 
    	} catch (err) {
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    
    } else {
    	return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
};

exports.signIn = async function (req, res) {
    if (!req.body.email || !req.body.password || !req.body.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {

            let userDetails = {};

            if (req.body.email) {
                userDetails = await User.findOne({ email: req.body.email });
            }

            /*if (req.body.login_type == "apple" && req.body.login_id && !req.body.email) {
                userDetails = await User.findOne({ appleId: req.body.login_id });
            }*/

            if (!userDetails)
                return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("User not registered") });
                
            //if (userDetails.emailVerification === 0)
              //  return res.status(200).json({ status: "false", short_code: "verify", message: res.__("Verify your email to continue") });

            if (userDetails.status === 0)
                return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });


                const isValid = await User.isValidPassword(req.body.password, userDetails.password);

                if (!isValid)
                    return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Credentials") });
                
                userDetails = await User.findOne({ email: req.body.email })
            

          /*  if ((req.body.login_type == "facebook") && (req.body.email && req.body.login_id)) {
                userDetails = await User.findOneAndUpdate({ email: req.body.email }, { facebookId: req.body.login_id, deviceToken: req.body.device_token, deviceMode: req.body.device_mode, devicePlatform: req.body.device_platform, deviceActive: 1 })
            }

            if ((req.body.login_type == "google") && (req.body.email && req.body.login_id)) {
                userDetails = await User.findOneAndUpdate({ email: req.body.email }, { googleId: req.body.login_id, deviceToken: req.body.device_token, deviceMode: req.body.device_mode, devicePlatform: req.body.device_platform, deviceActive: 1 })
            }

            if ((req.body.login_type == "apple") && (req.body.email && req.body.login_id)) {
                userDetails = await User.findOneAndUpdate({ email: req.body.email }, { appleId: req.body.login_id, deviceToken: req.body.device_token, deviceMode: req.body.device_mode, devicePlatform: req.body.device_platform, deviceActive: 1 })
            } */

            let profileImage = (userDetails.image) ? process.env.BASE_URL + process.env.USER_THUMB100_URL + userDetails.image : "";

            //let profileImage = (userDetails.image) ? process.env.BASE_URL + process.env.USER_MEDIA_URL + userDetails.image : "";
            let phone = (userDetails.mobile) ? userDetails.mobile : "";
            let fb_id = (userDetails.facebookId) ? userDetails.facebookId : "";
            let google_id = (userDetails.googleId) ? userDetails.googleId : "";
            let stripeSecretKey = (userDetails.stripeSecretKey) ? userDetails.stripeSecretKey : "";
		    let stripePublicKey = (userDetails.stripePublicKey) ? userDetails.stripePublicKey : "";
 
            if(userDetails.emailVerification == '1'){
            	email_verification = "true";
            } else {
            	email_verification = "false";
            }
            
            if(userDetails.fbVerification == '1'){
            	fb_verification = "true";
            } else {
            	fb_verification = "false";
            }
		    
            
            return res.status(200).json({
                        status: "true",
                        result:{
                        user_id: userDetails._id,
                        auth_token: userAuth.createJwt(userDetails),
                        full_name: userDetails.name,
                        email: userDetails.email,
                        phone: phone,
                        user_image: profileImage,
                        fb_id: fb_id,
                        google_id:google_id,
                        fb_verification:fb_verification,
                        mail_verification:email_verification,
                        email_notification: userDetails.emailNotification,
                        push_notification: userDetails.pushNotification,
                        ratings: userDetails.rating,
                        reviews: userDetails.reviews,
                        stripe_secretkey: stripeSecretKey,
                        stripe_publickey: stripePublicKey,
                        user_join: userDetails.createdAt
                        }
                    });
        }
        catch (err) {
        	console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};

exports.forgotPassword = async function (req, res) {

    if (!req.body.email || !req.body.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {

            let userDetails = await User.findOne({ email: req.body.email });

            if (!userDetails)
                return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("User not registered") });

            if (userDetails.status === 0)
                return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });

            // reset user's password
            let newPassword = nanoid(12);
            userDetails.password = newPassword;
            await userDetails.save();

            let mailData = {};
            mailData.to = req.body.email;
            mailData.purpose = "forgotpwd";
            mailData.subject = res.__("Reset Password");
            mailData.title = res.__("Reset Password is Done !");
            mailData.message = res.__("We received a request to reset your password.");
            mailData.message_details = res.__("Your new password is") + " " + newPassword;
            mailerController.sendMail(mailData);

            return res.status(200).json({
                status: "true",
                message: res.__("New password sent successfully to your email")
            });
        }
        catch (err) {
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
}

exports.verifyMail = async function (req, res) {

    if (!req.body.email || !req.body.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {

            let userDetails = await User.findOne({ email: req.body.email });


            if (!userDetails)
                return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("User not registered") });

            		 let settingDetail = {};    
            		settingDetail = await Setting.findOne();
            
					let mailData = {};
                    mailData.to = req.body.email;
                    mailData.userid = userDetails._id;
                    mailData.purpose = "verify";
                    mailData.subject = res.__("Email Account Verification") + "-" + settingDetail.siteName;
                    mailData.title = res.__("Verify your Email Account");
                    mailData.message = res.__("Pleae verify your email account and Make your profile as verified User");
                    mailData.message_details = res.__("Please click on the button below to verify your email address!");
                    mailerController.sendMail(mailData); 

            return res.status(200).json({
                status: "true",
                message: res.__("Verification mail sent successfully to registered Mail ID")
            });
        }
        catch (err) {
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
}


exports.editProfile = async function (req, res) {
    if (!req.body.user_id || !req.body.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {

            let userDetails = await User.findOne({ _id: req.body.user_id })

            if (!userDetails)
                return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("User not registered") });

            if (userDetails.status === 0)
                return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });

            
            	if(userDetails) {
	        		/*await User.findByIdAndUpdate(userDetails._id, { image: req.body.user_image, name: req.body.full_name, 
	        			emailNotification: req.body.email_notification, 
	        			pushNotification: req.body.push_notification}, function (error, result) {
	                if (error) {
	                    // console.log(error);

	                    return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });

						}                	
	            	});*/

	            	if(req.body.user_image) {
	            		userDetails.image = req.body.user_image;
	            	}
	            	if(req.body.full_name) {
	            		userDetails.name = req.body.full_name;

	            	}
	            	if(req.body.email_notification) {
	            		userDetails.emailNotification = req.body.email_notification;

	            	}
	            	if(req.body.push_notification) {
	            		userDetails.pushNotification = req.body.push_notification;

	            	}
	            	if(req.body.stripe_secretkey) {
	            		userDetails.stripeSecretKey = req.body.stripe_secretkey;

	            	}
	            	if(req.body.stripe_publickey) {
	            		userDetails.stripePublicKey = req.body.stripe_publickey;

	            	}
	            	
            		await userDetails.save();

	            	return res.status(200).json({ status: "true", message: res.__("Profile updated successfully") });
	            
	            } else {

	            	return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });

	            }

        }
        catch (err) {
        	console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};


exports.getProfile = async function (req, res) {
    if (!req.query.user_id || !req.query.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {

            let userDetails = await User.findOne({ _id: req.query.user_id })

            if (!userDetails)
                return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("User not registered") });

            if (userDetails.status === 0)
                return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });


            let profileImage = (userDetails.image) ? process.env.BASE_URL + process.env.USER_THUMB100_URL + userDetails.image : "";
            let fb_id = (userDetails.facebookId) ? userDetails.facebookId : "";
            let google_id = (userDetails.googleId) ? userDetails.googleId : "";
			let stripeSecretKey = (userDetails.stripeSecretKey) ? userDetails.stripeSecretKey : "";
		    let stripePublicKey = (userDetails.stripePublicKey) ? userDetails.stripePublicKey : "";
 
            if(userDetails.emailVerification == '1'){
            	email_verification = "true";
            } else {
            	email_verification = "false";
            }
            
            if(userDetails.fbVerification == '1'){
            	fb_verification = "true";
            } else {
            	fb_verification = "false";
            }
            
            return res.status(200).json({
                        status: "true",
                        result:{
                        user_id: userDetails._id,
                        full_name: userDetails.name,
                        user_join: userDetails.createdAt,
                        email: userDetails.email,
                        user_image: profileImage,
                        fb_id: fb_id,
                        google_id:google_id,
                        fb_verification:fb_verification,
                        mail_verification:email_verification,
                        email_notification: userDetails.emailNotification,
                        push_notification: userDetails.pushNotification,
                        ratings: userDetails.rating,
                        reviews: userDetails.reviews,
                        stripe_secretkey: stripeSecretKey,
                        stripe_publickey: stripePublicKey,
                        phone: ""
                        }
                    });

        }
        catch (err) {
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};

exports.changePassword = async function (req, res) {
    if (!req.body.user_id || !req.body.old_password || !req.body.new_password || !req.body.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {

        try {

            let userDetails = await User.findOne({ _id: req.body.user_id })

            if (!userDetails)
                return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("User not registered") });

            if (userDetails.status === 0)
                return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });


            const isValid = await User.isValidPassword(req.body.old_password, userDetails.password);

            const samePassword = await User.isValidPassword(req.body.new_password, userDetails.password);

            if (!isValid)
            	return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Old Password is incorrect") });

            if (samePassword)
            	return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("New password cannot be same as your old password") });

            // reset user's password
            userDetails.password = req.body.new_password;
            await userDetails.save();

             return res.status(200).json({ status: "true", message: res.__("Password changed successfully") });


        }
        catch (err) {
        	//console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};


exports.signOut = async function (req, res) {
    if (!req.body.user_id) {
        return res.status(200).json({ status_code: 400, message: res.__("Invalid Params") });
    }
    else {

        try {

            let userDetails = await User.findOne({ userId: req.body.user_id, role: "user" })

            if (!userDetails)
                return res.status(200).json({ status_code: 400, message: res.__("Invalid User ID") });

            // user's signed out
            userDetails.deviceActive = 0;
            await userDetails.save();

            return res.status(200).json({
                status_code: 200,
                message: res.__("Logged Out Successfully")
            });
        }
        catch (err) {
            return res.status(200).json({ status_code: 500, message: res.__("Something went wrong") });
        }
    }
};


exports.deactivateAccount = async function (req, res) {
    if (!req.body.user_id) {
        return res.status(200).json({ status_code: 400, message: res.__("Invalid Params") });
    }
    else {

        try {

            let userDetails = await User.findOne({ userId: req.body.user_id, role: "user" });

            if (!userDetails)
                return res.status(200).json({ status_code: 400, message: res.__("Invalid User ID") });

            if (userDetails.status === 0)
                return res.status(200).json({ status_code: 400, message: res.__("Account is already disabled") });

            // user's account deactivated
            userDetails.status = 0;
            await userDetails.save();

            return res.status(200).json({
                status_code: 200,
                message: res.__("Account is deactivated successfully")
            });
        }
        catch (err) {
            return res.status(200).json({ status_code: 500, message: res.__("Something went wrong") });
        }
    }
};

