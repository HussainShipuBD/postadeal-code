const nodemailer = require("nodemailer");
const handlebars = require('handlebars');
const fs = require('fs');

// models
const Setting = require('../models/settingModel');

// send mail to recipients
sendMail = async function (mailData) {
//console.log("Test");
    try {

        let appSettings = await Setting.findOne({});

        //if (appSettings.smtpHost) {

            // create reusable transporter object using the default SMTP transport
            let transporter = nodemailer.createTransport({
                host: appSettings.host,
                port: appSettings.port,
                secure: "true", //(appSettings.smtpStatus === 1) ? true : false, // true for 465, false for other ports
                auth: {
                    user: appSettings.email,
                    pass: appSettings.password,
                },
            });

            if(mailData.purpose == "verify") {

                readHTMLFile(__dirname + '/mail-templates/verify.html', function (err, html) {

                    let template = handlebars.compile(html);

                    let replacements = {
                        site_title: appSettings.siteName,
                        site_logo: process.env.BASE_URL + "storage/app/public/admin_assets/dark.png",
                        media_url: process.env.BASE_URL + "storage/app/public/admin_assets/",
                        verify_url: process.env.BASE_URL + "user/verify/" + mailData.userid,
                        email_header: mailData.title,
                        email_message: mailData.message,
                        email_details: mailData.message_details,
                        email_footer: appSettings.copyrightText,
                        facebook_link: appSettings.facebookURL,
                        twitter_link: appSettings.twitterURL,
                        linkedin_link: appSettings.linkedinURL,
                    };

                    let htmlToSend = template(replacements);

                    let mailOptions = {
                        from: appSettings.contactEmail,
                        to: mailData.to,
                        subject: mailData.subject,
                        html: htmlToSend,
                    };

                    transporter.sendMail(mailOptions, function (error, info) {
                        if (error) {
                            //console.log("Hai");
                             console.log("SMTP ERROR:" + error);
                        }
                    });

                });


            } else {
                readHTMLFile(__dirname + '/mail-templates/email.html', function (err, html) {

                    let template = handlebars.compile(html);

                    let replacements = {
                        site_title: appSettings.siteName,
                        site_logo: process.env.BASE_URL + "storage/app/public/admin_assets/dark.png",
                        media_url: process.env.BASE_URL + "storage/app/public/admin_assets/",
                        email_header: mailData.title,
                        email_message: mailData.message,
                        email_details: mailData.message_details,
                        email_footer: appSettings.copyrightText,
                        facebook_link: appSettings.facebookURL,
                        twitter_link: appSettings.twitterURL,
                        linkedin_link: appSettings.linkedinURL,
                    };

                    let htmlToSend = template(replacements);

                    let mailOptions = {
                        from: appSettings.contactEmail,
                        to: mailData.to,
                        subject: mailData.subject,
                        html: htmlToSend,
                    };

                    transporter.sendMail(mailOptions, function (error, info) {
                        if (error) {
                        	//console.log("Hai");
                             //console.log("SMTP ERROR:" + error);
                        }
                    });

                });
            }

            if(mailData.purpose == "buyerorder") {

                readHTMLFile(__dirname + '/mail-templates/buyerorder.html', function (err, html) {

                    let template = handlebars.compile(html);

                    let replacements = {
                        site_title: appSettings.siteName,
                        site_logo: process.env.BASE_URL + "storage/app/public/admin_assets/dark.png",
                        media_url: process.env.BASE_URL + "storage/app/public/admin_assets/",
                        email_header: mailData.title,
                        orderid: mailData.orderid,
                        orderdate: mailData.orderdate,
                        sellername: mailData.sellername,
                        productname: mailData.productname,
                        productprice: mailData.productprice,
                        shippingprice: mailData.shippingprice,
                        totalprice: mailData.totalprice,
                        email_footer: appSettings.copyrightText,
                        facebook_link: appSettings.facebookURL,
                        twitter_link: appSettings.twitterURL,
                        linkedin_link: appSettings.linkedinURL,
                    };

                    let htmlToSend = template(replacements);

                    let mailOptions = {
                        from: appSettings.contactEmail,
                        to: mailData.to,
                        subject: mailData.subject,
                        html: htmlToSend,
                    };

                    transporter.sendMail(mailOptions, function (error, info) {
                        if (error) {
                            //console.log("Hai");
                             console.log("SMTP ERROR:" + error);
                        }
                    });

                });

            }

            if(mailData.purpose == "buyerdelivered") {

                readHTMLFile(__dirname + '/mail-templates/buyerorder.html', function (err, html) {

                    let template = handlebars.compile(html);

                    let replacements = {
                        site_title: appSettings.siteName,
                        site_logo: process.env.BASE_URL + "storage/app/public/admin_assets/dark.png",
                        media_url: process.env.BASE_URL + "storage/app/public/admin_assets/",
                        email_header: mailData.title,
                        orderid: mailData.orderid,
                        orderdate: mailData.orderdate,
                        sellername: mailData.sellername,
                        productname: mailData.productname,
                        productprice: mailData.productprice,
                        shippingprice: mailData.shippingprice,
                        totalprice: mailData.totalprice,
                        email_footer: appSettings.copyrightText,
                        facebook_link: appSettings.facebookURL,
                        twitter_link: appSettings.twitterURL,
                        linkedin_link: appSettings.linkedinURL,
                    };

                    let htmlToSend = template(replacements);

                    let mailOptions = {
                        from: appSettings.contactEmail,
                        to: mailData.to,
                        subject: mailData.subject,
                        html: htmlToSend,
                    };

                    transporter.sendMail(mailOptions, function (error, info) {
                        if (error) {
                            //console.log("Hai");
                             //console.log("SMTP ERROR:" + error);
                        }
                    });

                });

            }

            if(mailData.purpose == "sellerorder") {

                readHTMLFile(__dirname + '/mail-templates/sellerorder.html', function (err, html) {

                    let template = handlebars.compile(html);

                    let replacements = {
                        site_title: appSettings.siteName,
                        site_logo: process.env.BASE_URL + "storage/app/public/admin_assets/dark.png",
                        media_url: process.env.BASE_URL + "storage/app/public/admin_assets/",
                        email_header: mailData.title,
                        orderid: mailData.orderid,
                        orderdate: mailData.orderdate,
                        buyername: mailData.buyername,
                        productname: mailData.productname,
                        productprice: mailData.productprice,
                        shippingprice: mailData.shippingprice,
                        totalprice: mailData.totalprice,
                        email_footer: appSettings.copyrightText,
                        facebook_link: appSettings.facebookURL,
                        twitter_link: appSettings.twitterURL,
                        linkedin_link: appSettings.linkedinURL,
                    };

                    let htmlToSend = template(replacements);

                    let mailOptions = {
                        from: appSettings.contactEmail,
                        to: mailData.to,
                        subject: mailData.subject,
                        html: htmlToSend,
                    };

                    transporter.sendMail(mailOptions, function (error, info) {
                        if (error) {
                            //console.log("Hai");
                             //console.log("SMTP ERROR:" + error);
                        }
                    });

                });

            }

            if(mailData.purpose == "sellerdelivered") {

                readHTMLFile(__dirname + '/mail-templates/sellerorder.html', function (err, html) {

                    let template = handlebars.compile(html);

                    let replacements = {
                        site_title: appSettings.siteName,
                        site_logo: process.env.BASE_URL + "storage/app/public/admin_assets/dark.png",
                        media_url: process.env.BASE_URL + "storage/app/public/admin_assets/",
                        email_header: mailData.title,
                        orderid: mailData.orderid,
                        orderdate: mailData.orderdate,
                        buyername: mailData.buyername,
                        productname: mailData.productname,
                        productprice: mailData.productprice,
                        shippingprice: mailData.shippingprice,
                        totalprice: mailData.totalprice,
                        email_footer: appSettings.copyrightText,
                        facebook_link: appSettings.facebookURL,
                        twitter_link: appSettings.twitterURL,
                        linkedin_link: appSettings.linkedinURL,
                    };

                    let htmlToSend = template(replacements);

                    let mailOptions = {
                        from: appSettings.contactEmail,
                        to: mailData.to,
                        subject: mailData.subject,
                        html: htmlToSend,
                    };

                    transporter.sendMail(mailOptions, function (error, info) {
                        if (error) {
                            //console.log("Hai");
                             //console.log("SMTP ERROR:" + error);
                        }
                    });

                });

            }

            if(mailData.purpose == "promotion") {

                readHTMLFile(__dirname + '/mail-templates/promotion.html', function (err, html) {

                    let template = handlebars.compile(html);

                    let replacements = {
                        site_title: appSettings.siteName,
                        site_logo: process.env.BASE_URL + "storage/app/public/admin_assets/dark.png",
                        media_url: process.env.BASE_URL + "storage/app/public/admin_assets/",
                        email_header: mailData.title,
                        username: mailData.username,
                        productname: mailData.productname,
                        promotionduration: mailData.promotionduration,
                        promotionprice: mailData.promotionprice,
                        email_footer: appSettings.copyrightText,
                        facebook_link: appSettings.facebookURL,
                        twitter_link: appSettings.twitterURL,
                        linkedin_link: appSettings.linkedinURL,
                    };

                    let htmlToSend = template(replacements);

                    let mailOptions = {
                        from: appSettings.contactEmail,
                        to: mailData.to,
                        subject: mailData.subject,
                        html: htmlToSend,
                    };

                    transporter.sendMail(mailOptions, function (error, info) {
                        if (error) {
                            //console.log("Hai");
                             console.log("SMTP ERROR:" + error);
                        }
                    });

                });

            }

       // }

    } catch (err) {
    	//console.log("Yes");
         console.log(err);
    }
};


let readHTMLFile = function (path, callback) {
    fs.readFile(path, { encoding: 'utf-8' }, function (err, html) {
        if (err) {
            throw err;
            callback(err);
        }
        else {
            callback(null, html);
        }
    });
};

module.exports = {
    sendMail: sendMail,
};


