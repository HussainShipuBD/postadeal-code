// models
const Log = require('../models/logModel');
const User = require('../models/userModel');
const Product = require('../models/productModel');
const Chat = require('../models/chatModel');


let createLog = function (sender, receiver, reference, chatid, type, message) {

    let logData = {};

    logData.senderId = sender;
    logData.receiverId = receiver;
    logData.sourceId = reference;
    logData.chatId = chatid;
    logData.messageType = type;
    logData.messageTxt = message;

    if (!sender) {
        logData.isAdmin = 1;
    }

    let newLog = new Log(logData);
    newLog.save(function (error, logDetails) {
        if (error) {
             console.log(error);
        }
    });
};

let getNotification = async function (req, res) {
    if (!req.body.user_id || !req.body.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {
            let userDetails = await User.findOne({ _id: req.body.user_id });

            if (!userDetails)
                return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("User not registered") });

            if (userDetails.status === 0)
                return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });


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
            
            let userLogs = await Log.find({$or: [{ receiverId: req.body.user_id } , { isAdmin: 1, messageType: 'admin'}] }).sort({ "createdAt": -1 }).limit(limit).skip(offset);

            if (userLogs.length === 0)
                return res.status(200).json({ status: "false", short_code: "empty", message: res.__("No notification found") });

            let allLogs = [];

                

            for (var i = 0; i < userLogs.length; i++) {

                if(userLogs[i].sourceId && userLogs[i].messageType != 'admin') {

                        let itemData = await Product.findOne({ _id: userLogs[i].sourceId }); 
                    if(itemData) {
                         itemId = itemData._id;
                         itemName = itemData.itemTitle;
                         let productImg = JSON.parse(itemData.images);
                         itemImage = process.env.BASE_URL + process.env.PRODUCT_THUMB300_MEDIA_URL + productImg[0];
                    } else {
                        itemId = "";
                        itemName = "";
                        itemImage = "";
                    }
                } else {

                     itemId = "";
                     itemName = "";
                     itemImage = "";

                }

                if(userLogs[i].messageType != 'admin') {

                    let userDetails = await User.findOne({ _id: userLogs[i].senderId })

                    userId = userDetails._id;
                    userName = userDetails.name;
                    userImage = process.env.BASE_URL + process.env.USER_THUMB100_URL + userDetails.image;

                } else {
                    userId = "";
                    userName = "";
                    userImage = "";

                }

                if(userLogs[i].messageType != 'chat') {

                    if(userLogs[i].createdAt) {
                        date = userLogs[i].createdAt;
                    } else {
                        date = "";
                    }

                    allLogs.push({
                        id: userLogs[i]._id,
                        type: userLogs[i].messageType,
                        message: userLogs[i].messageTxt,
                        user_id: userId,
                        user_name: userName,
                        user_image: userImage,
                        item_id: itemId,
                        item_name: itemName,
                        item_image: itemImage,
                        date: date

                    });

                } else {

                    allLogs.push({
                        id: userLogs[i]._id,
                        type: userLogs[i].messageType,
                        message: userLogs[i].messageTxt,
                        chat_id: userLogs[i].chatId,
                        user_id: userId,
                        user_name: userName,
                        user_image: userImage,
                        item_id: itemId,
                        item_name: itemName,
                        item_image: itemImage,
                        date: userLogs[i].createdAt

                    });

                }
            }

            await User.findByIdAndUpdate(req.body.user_id, { notificationCount: 0 } );

            return res.status(200).json({ status: "true", result:  allLogs });


        }
        catch (err) {
            console.log(err);
		return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") }); 
        }
    }
};

let getUnreadcount = async function (req, res) {
    if (!req.body.user_id || !req.body.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {
            let userDetails = await User.findOne({ _id: req.body.user_id });

            let userChats = await Chat.countDocuments({ $or: [{ userId: req.body.user_id }, { sellerId: req.body.user_id }] , lastMessageUser: { $ne: req.body.user_id } , unread: "true" });

            
            return res.status(200).json({
                        status: "true",
                        result:{
                        notification_count: userDetails.notificationCount,
                        chat_count: userChats
                        
                        }
                    });

        }
        catch (err) {
            console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") }); 
        }
    }
};

module.exports = {
    createLog: createLog,
    getUnreadcount: getUnreadcount,
    getNotification: getNotification
};
