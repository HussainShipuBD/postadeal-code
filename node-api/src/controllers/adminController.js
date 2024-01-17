// models
const Help = require('../models/helpModel');
const User = require('../models/userModel');
const Setting = require('../models/settingModel');


// email service
const mailerController = require('./mailController');

/*exports.appDefaults = async function (req, res) {
    try {

        let appSettings = await Setting.findOne({});

        let userTerms = await Help.findOne({ "type": "user", "name": "Terms And Conditions" }).select({ "_id": 0 });

        let taskerTerms = await Help.findOne({ "type": "tasker", "name": "Terms And Conditions" }).select({ "_id": 0 });

        let businessCities = await City.find().select({ "_id": 0, "city": 1, "state": 1 });

        let availableCities = [];

        if (businessCities.length > 0) {
            businessCities.filter(function (eachCity) {
                if (availableCities.indexOf(eachCity.city) === -1) {
                    availableCities.push(eachCity.city);
                }
            });
        }

        return res.status(200).json({
            status_code: 200,
            currency_code: appSettings.currencyCode,
            currency_symbol: appSettings.currencySymbol,
            site_commission: appSettings.commission,
            site_tax: appSettings.tax,
            stripe_public_key: appSettings.stripePublicKey,
            android_force_update: appSettings.androidForceUpdate.toString(),
            ios_force_update: appSettings.iosForceUpdate.toString(),
            user_terms: (userTerms) ? userTerms : {},
            tasker_terms: (taskerTerms) ? taskerTerms : {},
            tasker_verification_guide: appSettings.guideLine,
            minimum_payment_price: parseFloat(appSettings.minimumAmount),
            tasker_documents_limit: appSettings.docsLimit.toString(),
            tasker_portfolio_limit: appSettings.portfolioLimit.toString(),
            cities: availableCities.filter(e => e),
        });
    }
    catch (err) {
        return res.status(200).json({ status_code: 500, message: res.__("Something went wrong") });
    }
};*/

exports.appHelps = async function (req, res) {
    if (!req.query.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }    

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

            let searchString = {};

            if(req.query.search_query) {

                searchString.name = { $regex: req.query.search_query, $options: "i" };

            }

            let allHelps = await Help.find(searchString).limit(limit).skip(offset);

            if (!allHelps)
            return res.status(200).json({ status: "true", result: [] });

                let helpList = [];
                allHelps.filter(function (helps) {
                    helpList.push({
                        id: helps._id,
                        title: helps.name,
                        description: helps.description
                    });
                });

                return res.status(200).json({ status: "true", result: helpList });

    }
    catch (err) {
        return res.status(200).json({ status_code: 500, message: res.__("Something went wrong") });
    }
};

exports.termsandconditions = async function (req, res) {
    if (!req.query.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }    

    try {

            let termsandconditions = await Help.findOne({"name": "Terms And Conditions"});

            return res.status(200).json({ status: "true", title: termsandconditions.name, description: termsandconditions.description});

    }
    catch (err) {
        return res.status(200).json({ status_code: 500, message: res.__("Something went wrong") });
    }
};

exports.privacypolicy = async function (req, res) {
    if (!req.query.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }    

    try {

            let privacypolicy = await Help.findOne({"name": "Privacy Policy"});

            return res.status(200).json({ status: "true", title: privacypolicy.name, description: privacypolicy.description});

    }
    catch (err) {
        return res.status(200).json({ status_code: 500, message: res.__("Something went wrong") });
    }
};

exports.contactAdmin = async function (req, res) {
    if (!req.body.name || !req.body.email || !req.body.subject || !req.body.message || !req.body.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {

            let settings = await Setting.findOne();


            let mailData = {};
            mailData.to = settings.contactEmail;
            mailData.subject = res.__("Contact Mail");
            mailData.title = req.body.subject + " - " + req.body.name;
            mailData.message = res.__("Leave you message:") + " " + req.body.message;
            mailData.message_details = res.__("Contact him back with this mailid") + " " + req.body.email;;
            mailerController.sendMail(mailData);
            

            return res.status(200).json({ status: "true", message: res.__("Email sent to Admin, you will get a reply soon. Check your inbox for further communication") });

        }
        catch (err) {
            return res.status(200).json({ status_code: 500, message: res.__("Something went wrong") });
        }
    }
}

exports.adminNotifications = async function (req, res) {
    try {

        let limit = parseInt(req.params.limit);
        let offset = parseInt(req.params.offset);

        let adminNotifications = await AdminChats.find({ "msg_to": { $in: [req.params.role, "all"] }, "msg_platform": req.params.platform }).sort({ "created_at": -1 }).limit(limit).skip(offset);

        if (adminNotifications.length === 0)
            return res.status(200).json({ status_code: 400, message: res.__("No notifications found") });

        let allNotifications = [];


        let appSettings = await Setting.findOne({});

        adminNotifications.filter(function (eachNotification) {
            allNotifications.push({
                "receiver_id": "",
                "user_id": "",
                "message_id": eachNotification._id,
                "message": {
                    "message": eachNotification.msg_data,
                    "type": "text",
                },
                "chat_id": "",
                "message_type": "text",
                "user_name": appSettings.siteName + " Team",
                "user_image": "",
                "date": eachNotification.created_at,
            });
        });

        return res.status(200).json({ status_code: 200, messages: allNotifications });

    }
    catch (err) {
        return res.status(200).json({ status_code: 500, message: res.__("Something went wrong") });
    }
};