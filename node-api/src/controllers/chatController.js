const mongoose = require("mongoose");
const moment = require("moment");
const User = require('../models/userModel');
const Chat = require('../models/chatModel');
const Message = require('../models/messageModel');
const Product = require('../models/productModel');
//const AdminChats = require('../models/adminChatModel');
const Currency = require('../models/currencyModel');

const logController = require("../controllers/logController");
let fcmController = require("../controllers/fcmController");


exports.chatMessages = async function (req, res) {
    if (!req.params.chatId || !req.params.limit || !req.params.offset) {
        return res.status(200).json({ status_code: 400, message: res.__("Invalid Params") });
    }
    else {
        try {

            let searchObject = { chatId: req.params.chatId };

            let limit = parseInt(req.params.limit);

            let offset = parseInt(req.params.offset);

            let userMessages = await Message.find(searchObject).sort({ "msgDate": -1 }).limit(limit).skip(offset);

            if (userMessages.length === 0)
                return res.status(200).json({ status_code: 400, message: res.__("No messages found") });

            let chatMessages = [];

            userMessages.filter(function (eachMessage) {
                chatMessages.push(eachMessage.chatData);
            });

            return res.status(200).json({ status_code: 200, messages: chatMessages });

        }
        catch (err) {
            return res.status(200).json({ status_code: 500, message: res.__("Something went wrong") });
        }
    }
};




exports.createChat = async function (req, res) {
    if (!req.body.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {
            console.log(req.body);
            if(req.body.type == "user") {
                userId = req.body.user_id;
                sellerId = req.body.seller_id;
            } else {
                userId = req.body.buyer_id;
                sellerId = req.body.user_id;
            }

            let chatExists = await Chat.countDocuments({$or: [{ userId: userId, sellerId: sellerId, itemId: req.body.item_id } , { _id: req.body.chat_id}] });

            let itemDetails = await Product.findById(req.body.item_id);

            if (chatExists === 0) {

                if(req.body.type == "user") {

                    let userDetails = await User.findOne({ _id: userId });

                    if (!userDetails)
                        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("User not registered") });

                    if (userDetails.status === 0)
                        return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });


                        chatDate = Date.now();

                        let newChat = new Chat({
                            itemId: itemDetails._id,
                            sellerId: itemDetails.userId,
                            userId: userDetails._id,
                            chatDate: chatDate
                        });

                        newChat.save(async function (error, chatDetails) {

                            let eachChat = await Chat.findById(chatDetails._id).populate("userId").populate("itemId").populate("sellerId");


                            let sellerImage = (eachChat.sellerId.image) ? process.env.BASE_URL + process.env.USER_THUMB100_URL + eachChat.sellerId.image : "";
                            let userImage = (eachChat.userId.image) ? process.env.BASE_URL + process.env.USER_THUMB100_URL + eachChat.userId.image : "";

                            if(eachChat.itemId) {

                                itemId = eachChat.itemId._id;
                                itemTitle  = eachChat.itemId.itemTitle;
                                itemPrice = eachChat.itemId.price;
                                let productImg = JSON.parse(eachChat.itemId.images);
                                itemImage = process.env.BASE_URL + process.env.PRODUCT_THUMB300_MEDIA_URL + productImg[0];

                                let currencyData = await Currency.findOne({ _id: eachChat.itemId.CurrencyID }); 

                                currency = currencyData.currencysymbol;

                            } else {

                                itemId = "";
                                itemTitle  = "";
                                itemPrice = "";
                                itemImage = "";
                                currency = "";
                            }

                            //let productImg = JSON.parse(eachChat.itemId.images);

                            

                            let logMessage = res.__("I'm interested in this product");
                            logController.createLog(userDetails._id, itemDetails.userId, itemDetails._id, eachChat._id, "chat", logMessage);

                            await User.findByIdAndUpdate(itemDetails.userId, {$inc : {'notificationCount' : 1}} );

                            return res.status(200).json({
                                status: "true",
                                result:{
                                new_chat: "true",
                                chat_id: eachChat._id,
                                seller_id: eachChat.sellerId._id,
                                seller_name: eachChat.sellerId.name,
                                seller_image: sellerImage,
                                buyer_id: eachChat.userId._id,
                                buyer_name: eachChat.userId.name,
                                buyer_image: userImage,
                                online: eachChat.sellerId.online_status,
                                last_seen: eachChat.sellerId.lastActive,
                                chat_block:eachChat.chatBlockBySeller,
                                blocked_by_me:eachChat.chatBlockByUser,
                                item_id: itemId,
                                item_name: itemTitle,
                                item_image: itemImage,
                                item_price: itemPrice,
                                currency: currency,
                                }
                            });

                        });

                    } else {

                        let userDetails = await User.findOne({ _id: sellerId });

                        if (!userDetails)
                            return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("User not registered") });

                        if (userDetails.status === 0)
                            return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });


                        chatDate = Date.now();

                        let newChat = new Chat({
                            itemId: itemDetails._id,
                            sellerId: sellerId,
                            userId: userId,
                            chatDate: chatDate
                        });

                        newChat.save(async function (error, chatDetails) {

                            let eachChat = await Chat.findById(chatDetails._id).populate("userId").populate("itemId").populate("sellerId");


                            let sellerImage = (eachChat.sellerId.image) ? process.env.BASE_URL + process.env.USER_THUMB100_URL + eachChat.sellerId.image : "";
                            let userImage = (eachChat.userId.image) ? process.env.BASE_URL + process.env.USER_THUMB100_URL + eachChat.userId.image : "";

                            if(eachChat.itemId) {

                                itemId = eachChat.itemId._id;
                                itemTitle  = eachChat.itemId.itemTitle;
                                itemPrice = eachChat.itemId.price;
                                let productImg = JSON.parse(eachChat.itemId.images);
                                itemImage = process.env.BASE_URL + process.env.PRODUCT_THUMB300_MEDIA_URL + productImg[0];

                                let currencyData = await Currency.findOne({ _id: eachChat.itemId.CurrencyID }); 

                                currency = currencyData.currencysymbol;

                            } else {

                                itemId = "";
                                itemTitle  = "";
                                itemPrice = "";
                                itemImage = "";
                                currency = "";
                            }

                            return res.status(200).json({
                                status: "true",
                                result:{
                                new_chat: "true",
                                chat_id: eachChat._id,
                                seller_id: eachChat.sellerId._id,
                                seller_name: eachChat.sellerId.name,
                                seller_image: sellerImage,
                                buyer_id: eachChat.userId._id,
                                buyer_name: eachChat.userId.name,
                                buyer_image: userImage,
                                online: eachChat.sellerId.online_status,
                                last_seen: eachChat.sellerId.lastActive,
                                chat_block:eachChat.chatBlockBySeller,
                                blocked_by_me:eachChat.chatBlockByUser,
                                item_id: itemId,
                                item_name: itemTitle,
                                item_image: itemImage,
                                item_price: itemPrice,
                                currency: currency,
                                }
                            });

                        });



                    }

            } else {

                let userDetails = await User.findOne({ _id: userId });
                
                let userChats = await Chat.findOne({$or: [{ userId: userDetails._id, itemId: req.body.item_id } , { _id: req.body.chat_id}]}).populate("userId").populate("itemId").populate("sellerId");


                let sellerImage = (userChats.sellerId.image) ? process.env.BASE_URL + process.env.USER_THUMB100_URL + userChats.sellerId.image : "";
                let userImage = (userChats.userId.image) ? process.env.BASE_URL + process.env.USER_THUMB100_URL + userChats.userId.image : "";


                            if(userChats.itemId) {

                                itemId = userChats.itemId._id;
                                itemTitle  = userChats.itemId.itemTitle;
                                itemPrice = userChats.itemId.price;
                                let productImg = JSON.parse(userChats.itemId.images);
                                itemImage = process.env.BASE_URL + process.env.PRODUCT_THUMB300_MEDIA_URL + productImg[0];

                                let currencyData = await Currency.findOne({ _id: userChats.itemId.CurrencyID }); 

                                currency = currencyData.currencysymbol;

                            } else {

                                itemId = "";
                                itemTitle  = "";
                                itemPrice = "";
                                itemImage = "";
                                currency = "";
                            }


                return res.status(200).json({
                        status: "true",
                        result:{
                        new_chat: "false",
                        chat_id: userChats._id,
                        seller_id: userChats.sellerId._id,
                        seller_name: userChats.sellerId.name,
                        seller_image: sellerImage,
                        buyer_id: userChats.userId._id,
                        buyer_name: userChats.userId.name,
                        buyer_image: userImage,
                        online: userChats.sellerId.online_status,
                        last_seen: userChats.sellerId.lastActive,
                        chat_block:userChats.chatBlockBySeller,
                        blocked_by_me:userChats.chatBlockByUser,
                        item_id: itemId,
                        item_name: itemTitle,
                        item_image: itemImage,
                        item_price: itemPrice,
                        currency: currency,
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


exports.postMessage = async function (req, res) {
    if (!req.body.user_id || !req.body.chat_id || !req.body.lang_code || !req.body.initial_message) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {
            let userDetails = await User.findOne({ _id: req.body.user_id })

            if (!userDetails)
                return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("User not registered") });

            if (userDetails.status === 0)
                return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });

            let userChats = await Chat.findOne({ _id: req.body.chat_id });

            if (userChats) {

                if(req.body.message) {
                    type = "text";
                    lastmessage = req.body.message;
                    pushmessage = "Send a Message '" + lastmessage + "'";
                }
                if(req.body.attachment) {
                    type = "attachment";
                    lastmessage = "image";
                    pushmessage = "Send an Image";
                }

                lastmessageDate = Date.now();


                let newMessage = new Message({
                    chatId: userChats._id,
                    userId: userDetails._id,
                    type: type,
                    message: req.body.message,
                    attachment: req.body.attachment,
                    initial_message: req.body.initial_message,
                    msgDate: lastmessageDate
                });

                if(req.body.user_id == userChats.sellerId) {
                    receiverId = userChats.userId;
                    chatUpdatedSeller = 0;
                    chatUpdatedUser = userChats.chatClearUpdatedUser;

                } else {
                    receiverId = userChats.sellerId;
                    chatUpdatedUser = 0;
                    chatUpdatedSeller = userChats.chatClearUpdatedSeller;

                }

                newMessage.save(async function (error, msgDetails) {

                    let eachMessage = await Message.findById(msgDetails._id);

                    await Chat.findByIdAndUpdate(userChats._id, { chatClearUpdatedUser: chatUpdatedUser, chatClearUpdatedSeller: chatUpdatedSeller,  lastMessage: lastmessage, lastMessageOn: lastmessageDate, lastMessageUser: userDetails._id, unread: "true", chatDate: lastmessageDate } );


                    let attachment = (eachMessage.attachment) ? process.env.BASE_URL + process.env.CHAT_ORIGINAL_URL + eachMessage.attachment : "";


                    let messageData = {};
                    let itemData = {};
                    let message = [];
                    itemData.type = "chat";
                    itemData.id = userChats._id;
                    messageData.body = pushmessage;
                    messageData.title = userDetails.name;
                    message.push(receiverId);
                    console.log('messageData: ',messageData);
                    fcmController.sendNotification(message, messageData, itemData);

                    return res.status(200).json({
                        status: "true",
                        result:{
                        message_id: eachMessage.chatId,
                        type: type,
                        user_id: eachMessage.userId,
                        message: eachMessage.message,
                        attachment: attachment,
                        message_time: eachMessage.createdAt
                        }
                    });

                });

            } else {

                return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });

            }
        }
        catch (err) {
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};


exports.getMessages = async function (req, res) {
    if (!req.body.chat_id || !req.body.user_id || !req.body.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {
            let userDetails = await User.findOne({ _id: req.body.user_id })

            if (!userDetails)
                return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("User not registered") });

            if (userDetails.status === 0)
                return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });


            let userChats = await Chat.findOne({ _id: req.body.chat_id });

            let getQuery = {};


            if(userChats.userId == req.body.user_id) {

                if(userChats.chatClearByUser) {

                    getQuery.createdAt = { $gte: userChats.chatClearByUser };

                }

            } else {

                if(userChats.chatClearBySeller) {

                    getQuery.createdAt = { $gte: userChats.chatClearBySeller };

                }

            }

            getQuery.chatId = req.body.chat_id;


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

            let userMessages = await Message.find(getQuery).limit(limit).skip(offset).sort({ msgDate: -1 });

            let msgList = [];

            for (var i = 0; i < userMessages.length; i++) {

                let attachment = (userMessages[i].attachment) ? process.env.BASE_URL + process.env.CHAT_ORIGINAL_URL + userMessages[i].attachment : "";
                let message = (userMessages[i].message) ? userMessages[i].message : "";


                msgList.push({
                    message_id: userMessages[i].chatId,
                    type: userMessages[i].type,
                    user_id: userMessages[i].userId,
                    message: message,
                    attachment: attachment,
                    initial_message: userMessages[i].initial_message,
                    message_time: userMessages[i].createdAt

                });


            }


            return res.status(200).json({ status: "true", result:  msgList });

        }
        catch (err) {
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};


exports.getChats = async function (req, res) {
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

            let userChats = await Chat.find({ $or: [{ userId: req.body.user_id }, { sellerId: req.body.user_id }] }).populate("userId").sort({chatDate: -1}).populate("sellerId").populate("itemId").limit(limit).skip(offset);

            let chatList = [];

            for (var i = 0; i < userChats.length; i++) {

                if(req.body.user_id == userChats[i].userId._id) {

                    user_id = userChats[i].sellerId._id;
                    user_name = userChats[i].sellerId.name;
                    user_image = (userChats[i].sellerId.image) ? process.env.BASE_URL + process.env.USER_THUMB100_URL + userChats[i].sellerId.image : "";
                    chat_block = userChats[i].chatBlockBySeller;
                    block_me = userChats[i].chatBlockByUser;
                    online_status = userChats[i].sellerId.online_status;


                } else {

                    user_id = userChats[i].userId._id;
                    user_name = userChats[i].userId.name;
                    user_image = (userChats[i].userId.image) ? process.env.BASE_URL + process.env.USER_THUMB100_URL + userChats[i].userId.image : "";
                    chat_block = userChats[i].chatBlockByUser;
                    block_me = userChats[i].chatBlockBySeller;
                    online_status = userChats[i].userId.online_status;

                }

               
                        if(userChats[i].lastMessageUser == userChats[i].userId._id && userChats[i].chatClearUpdatedUser == 1) {
                                          
                            last_message = "";
                            last_message_time = "";
                        } else if(userChats[i].lastMessageUser == userChats[i].sellerId._id && userChats[i].chatClearUpdatedSeller == 1) {
                            
                            last_message = "";
                            last_message_time = "";
                        } else {
                                              
                            last_message = userChats[i].lastMessage;
                            last_message_time = userChats[i].lastMessageOn;
                        }
                

                if(req.body.user_id != userChats[i].lastMessageUser) {
                    unread = userChats[i].unread;
                } else {
                    unread = "false";
                }


                if(userChats[i].itemId) {

                    itemId = userChats[i].itemId._id;
                    itemTitle  = userChats[i].itemId.itemTitle;

                    let productImg = JSON.parse(userChats[i].itemId.images);
                    itemImage = process.env.BASE_URL + process.env.PRODUCT_THUMB300_MEDIA_URL + productImg[0];

                } else {

                    itemId = "";
                    itemTitle  = "";
                    itemImage = "";

                }

                chatList.push({
                    chat_id: userChats[i]._id,
                    user_id: user_id,
                    user_name: user_name,
                    user_image: user_image,
                    item_id: itemId,
                    item_name: itemTitle,
                    item_image: itemImage,
                    online: online_status,
                    last_seen: "",
                    chat_block: chat_block,
                    blocked_by_me: block_me,
                    last_message: last_message,
                    last_message_time: last_message_time,
                    unread: unread

                });


            }


            return res.status(200).json({ status: "true", result:  chatList });

        }
        catch (err) {
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};


exports.chatBlock = async function (req, res) {
    if (!req.body.user_id || !req.body.chat_id || !req.body.type || !req.body.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {

            let userDetails = await User.findOne({ _id: req.body.user_id })

            if (!userDetails)
                return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("User not registered") });

            if (userDetails.status === 0)
                return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });

            let userChats = await Chat.findOne({ _id: req.body.chat_id });

            
            if(userChats) {

                if(req.body.type == "block") {
                    
                    if(userChats.userId == req.body.user_id) {
                        userChats.chatBlockByUser = "true";

                    } else {

                        userChats.chatBlockBySeller = "true";

                    }

                    await userChats.save();

                    return res.status(200).json({ status: "true", message: res.__("Chat blocked") });

                } else {

                    if(userChats.userId == req.body.user_id) {
                        userChats.chatBlockByUser = "false";

                    } else {

                        userChats.chatBlockBySeller = "false";

                    }

                    await userChats.save();

                    return res.status(200).json({ status: "true", message: res.__("Chat unblocked") });

                }

                    
                
            } else {

                    return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });

            }

        }
        catch (err) {
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};


exports.readMessage = async function (req, res) {
    if (!req.body.user_id || !req.body.chat_id || !req.body.message_id || !req.body.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {

            let userDetails = await User.findOne({ _id: req.body.user_id })

            if (!userDetails)
                return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("User not registered") });

            if (userDetails.status === 0)
                return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });

            let userChats = await Chat.findOne({ _id: req.body.chat_id });

            
            if(userChats) {

                    
                    if(userChats.lastMessageUser != req.body.user_id) {
                        userChats.unread = "false";

                    } else {
                        userChats.unread = "true";

                    }

                    await userChats.save();

                    return res.status(200).json({ status: "true", message: res.__("Message Readed") });
                    
                
            } else {

                    return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });

            }

        }
        catch (err) {
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};


exports.onlineUpdate = async function (req, res) {
    if (!req.body.user_id || !req.body.type || !req.body.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {

            let userDetails = await User.findOne({ _id: req.body.user_id })

            if (!userDetails)
                return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("User not registered") });

            if (userDetails.status === 0)
                return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });

            
            await User.findByIdAndUpdate(req.body.user_id, { online_status: req.body.type, lastActive: Date.now() } );


            return res.status(200).json({ status: "true", message: res.__("Status updated") });
                    
                

        }
        catch (err) {
            console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};


exports.chatclear = async function (req, res) {
    if (!req.body.user_id || !req.body.chat_id || !req.body.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {

            let userDetails = await User.findOne({ _id: req.body.user_id })

            if (!userDetails)
                return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("User not registered") });

            if (userDetails.status === 0)
                return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });

            let userChats = await Chat.findOne({ _id: req.body.chat_id });

            
            if(userChats) {

                    
                    if(userChats.userId == req.body.user_id) {
                        userChats.chatClearByUser = Date.now();
                        userChats.chatClearUpdatedUser = 1;

                    } else {
                        userChats.chatClearBySeller = Date.now();
                        userChats.chatClearUpdatedSeller = 1;
                    }


                    await userChats.save();

                    return res.status(200).json({ status: "true", message: res.__("Chat cleared successfully") });
                    
                
            } else {

                    return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });

            }

        }
        catch (err) {
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};
