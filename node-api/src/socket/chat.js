const fs = require("fs");
const express = require("express");
const moment = require("moment");
const app = express();

// models
const User = require('../models/userModel');
const Chat = require('../models/chatModel');

const Setting = require('../models/settingModel');

// fcm service
//const fcmService = require('../controllers/fcmController');

// notification controller
//const logController = require("../controllers/logController");

// create express server
let server = require("http").createServer(app);

if (process.env.SSL === "1") {

    // load ssl certificates
    let privateKey = fs.readFileSync("/etc/letsencrypt/live/postadeal.com/privkey.pem");
    let certificate = fs.readFileSync("/etc/letsencrypt/live/postadeal.com/fullchain.pem");
    let ca = fs.readFileSync("/etc/letsencrypt/live/postadeal.com/fullchain.pem");
    let sslOptions = {
        key: privateKey,
        cert: certificate,
        ca: ca
    };
    server = require("https").createServer(sslOptions, app);
}

const io = require("socket.io").listen(server);

server.listen(process.env.CHAT_PORT, function () { console.log("Socket.io is running on: " + process.env.CHAT_PORT); });

io.sockets.on("connection", function (socket) {

     console.log("a client connected");

    // user is online
    socket.on("liveMe", function (data) {
        console.log('liveMe',data);
        User.findOneAndUpdate({ userId: data.user_id }, { onlineStatus: 1, lastActive: moment().toISOString() }, function (error, userDetails) {
            if (!error) {
                socket.user_id = data.user_id;
            }
        });
    });

    // user joined the chat
    socket.on("join", function (data) {
        console.log('join',data);
        socket.join(data);
    });
    
    socket.on("online", function (data) {
    	console.log('User online' + data.receiver_id + ":" + data.sender_id + ":" + data.chat_id);
        User.findOne({ _id: data.receiver_id }, function (error, userDetails) {
                if (!error) { 
                    let statusObject = {};
                    statusObject.user_id = data.receiver_id;
                    var a = moment(Date.now()); //todays date
		     var b = moment(userDetails.lastActive); // another date
		     var duration = a.diff(b, 'minutes');
			if(parseInt(duration) > 2) {
			    //console.log("yes");
			    statusObject.status = 'offline';
			} else {
                    	    statusObject.status = userDetails.online_status;			
			}

                        statusObject.last_seen = userDetails.lastActive;
                   // console.log("working");
                    io.in(data.chat_id).emit('online', statusObject);
                } else {
                	console.log(error);
                }
            });
    });
    
    socket.on("message", function (data) {
        console.log('message',data);
		console.log('Message received' + data.sender_id + ":" + data.receiver_id + ":" + data.message + ":" + data.message_time + ":" + data.attachment + ":" + data.chat_id);
		io.in(data.chat_id).emit('message', {
			receiver_id: data.receiver_id,
			sender_id: data.sender_id,
			chat_id: data.chat_id,
			message: data.message,
			message_time: data.message_time,
			attachment: data.attachment,
		}); 
	});
	
	socket.on("typing", function (data) {
        console.log('typing',data);
		console.log('Message typing' + data.sender_id + ":" + data.receiver_id + ":" + data.typing + ":" + data.chat_id);
		io.in(data.chat_id).emit('typing', {
			receiver_id: data.receiver_id,
			sender_id: data.sender_id,
			chat_id: data.chat_id,
			typing: data.typing,
		}); 
	});

    // user is messaging on chat
    socket.on("sendMessage", function (data) {
        console.log('sendMessage',data);
        if (data.type === "onlineStatus") {
            User.findOne({ userId: data.receiver_id }, function (error, userDetails) {
                if (!error) {
                    let statusObject = {};
                    statusObject.type = data.type;
                    statusObject.user_id = data.receiver_id;
                    statusObject.status = userDetails.onlineStatus;
                    if (!userDetails.onlineStatus) {
                        statusObject.last_seen = userDetails.lastActive;
                    }
                    io.in(data.user_id).emit('receiveMessage', statusObject);
                }
            });
        }

        if (data.type === "bookingchat") {

            Message.countDocuments({ chatId: data.chat_id, createdAt: { $gte: new Date(moment().startOf('day').toISOString()), $lte: new Date(moment().endOf('day').toISOString()) } }, function (error, todayMessages) {
                if (todayMessages === 0) {

                    let newMessage = new Message({
                        chatId: data.chat_id,
                        chatData: {
                            "message_type": "date",
                            "date": moment().toISOString(),
                        }
                    });

                    newMessage.save(function (error, dateDetails) {
                        if (!error) {
                            let newMessage = new Message({
                                chatId: data.chat_id,
                                chatData: data
                            });

                            newMessage.save(function (error, messageDetails) {
                                if (!error) {
                                    Chat.findByIdAndUpdate(data.chat_id, { lastMessage: messageDetails._id, lastMessageOn: moment().toISOString() }, function (error, result) {
                                        if (!error) {
                                            unreadNotification(data.chat_id, data.receiver_id);
                                            fcmNotification(data.receiver_id, data);
                                            socket.broadcast.to(data.chat_id).emit("receiveMessage", data);
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
                else {
                    let newMessage = new Message({
                        chatId: data.chat_id,
                        chatData: data
                    });

                    newMessage.save(function (error, messageDetails) {
                        if (!error) {
                            Chat.findByIdAndUpdate(data.chat_id, { lastMessage: messageDetails._id, lastMessageOn: moment().toISOString() }, function (error, result) {
                                if (!error) {
                                    unreadNotification(data.chat_id, data.receiver_id);
                                    fcmNotification(data.receiver_id, data);
                                    socket.broadcast.to(data.chat_id).emit("receiveMessage", data);
                                }
                            });
                        }
                    });
                }
            });
        }

        if (data.type === "updateChat") {
            Message.findOneAndUpdate({ "chatData.message_id": data.message_id }, { chatData: data }, function (error, result) {
                if (error) {
                    // console.log(error);
                }
            });
        }

        if (data.type === "bookingStatus") {
            let bookingQuery = Booking.findById(data.booking_id).populate('taskerId');
            bookingQuery.exec(function (error, bookingDetails) {
                if (!error) {
                    let bookingServiceQuery = BookingDetail.findOne({ bookingId: data.booking_id }).populate('serviceId');
                    bookingServiceQuery.exec(function (err, bookingServices) {
                        if (!err) {
                            let bookingObject = {};
                            bookingObject.type = "bookingStatus";
                            bookingObject.user_id = data.user_id;
                            bookingObject.booking_id = data.booking_id;
                            bookingObject.status = bookingDetails.status;
                            bookingObject.description = bookingDetails.bookedFor;
                            bookingObject.service_id = bookingServices.serviceId._id;
                            bookingObject.service_name = bookingServices.serviceId.name;
                            bookingObject.service_price = bookingDetails.total;
                            bookingObject.assigned_to = (bookingDetails.taskerId) ? bookingDetails.taskerId.userId : "";
                            bookingObject.service_image = process.env.BASE_URL + process.env.SERVICE_MEDIA_URL + bookingServices.serviceId.image;
                            io.in(data.user_id).emit('receiveMessage', bookingObject);
                        }
                    });
                }
            });
        }

        if (data.type === "blockChat") {
            if (data.blocked === "true") {
                blockChat(data.chat_id, data.user_id);
            } else {
                unblockChat(data.chat_id, data.user_id);
            }
            io.in(data.user_id).emit('blockChat', data);
            socket.broadcast.to(data.chat_id).emit("blockChat", data);
        }

        if (data.type === "reportUser") {
            User.findOneAndUpdate({ "userId": data.receiver_id }, { $inc: { reports: 1 } }, function (error, result) {
                if (error) {
                    // console.log(error);
                }
            });
        }

        if (data.type === "resetUnread") {
            resetUnread(data.chat_id, data.user_id);
        }

        if (data.type === "quoteConfirmed") {
            quoteAccepted(data.booking_id, data.price);
        }

        if (data.type === "acceptNeed") {
            User.findOne({ "userId": data.tasker_id, "role": "tasker" }, function (error, userDetails) {
                if (!error) {
                    quoteAccepted(data.booking_id, data.price, userDetails._id);
                }
            });
        }

    });

    // user left the chat
    // socket.on("disconnect", function () {
    //     console.log('disconnect');
    //     if (socket.user_id) {
    //         User.findOneAndUpdate({ userId: socket.user_id }, { onlineStatus: 0, lastActive: moment().toISOString() }, function (error, userDetails) {
    //             if (error) {
    //                 // console.log(error);
    //             }
    //         });
    //     }
    // });

    // user have unread notifications
    let unreadNotification = function (chatId, receiverId) {
        User.findOne({ "userId": receiverId }, function (error, userDetails) {
            if (!error) {

                let updateString = { $inc: { userUnread: 1 } };

                if (userDetails.role === "tasker") {
                    updateString = { $inc: { taskerUnread: 1 } };
                }

                Chat.findByIdAndUpdate(chatId, updateString, function (error, result) {
                    if (error) {
                        // console.log(error);
                    }
                });
            }
        });
    };

    // user block the chat
    let blockChat = function (chatId, userId) {
        User.findOne({ "userId": userId }, function (error, userDetails) {
            if (!error) {

                let updateString = { $push: { blockedBy: "user" } };

                if (userDetails.role === "tasker") {
                    updateString = { $push: { blockedBy: "tasker" } };
                }

                Chat.findByIdAndUpdate(chatId, updateString, function (error, result) {
                    if (error) {
                        // console.log(error);
                    }
                });
            }
        });
    };

    // user unblock the chat
    let unblockChat = function (chatId, userId) {
        User.findOne({ "userId": userId }, function (error, userDetails) {
            if (!error) {

                let updateString = { $pull: { blockedBy: "user" } };

                if (userDetails.role === "tasker") {
                    updateString = { $pull: { blockedBy: "tasker" } };
                }

                Chat.findByIdAndUpdate(chatId, updateString, function (error, result) {
                    if (error) {
                        // console.log(error);
                    }
                });
            }
        });
    };

    // user read all notifications
    let resetUnread = function (chatId, userId) {
        User.findOne({ "userId": userId }, function (error, userDetails) {
            if (!error) {

                let updateString = { userUnread: 0 };

                if (userDetails.role === "tasker") {
                    updateString = { taskerUnread: 0 };
                }

                Chat.findByIdAndUpdate(chatId, updateString, function (error, result) {
                    if (error) {
                        // console.log(error);
                    }
                });
            }
        });
    };

    // user's need is accepeted by tasker
    let quoteAccepted = function (bookingId, confirmedPrice, taskerId) {

        let updateString = {};
        let taxPer = 0;
        let commissionPer = 0;

        Setting.findOne(function (error, appSettings) {
            if (!error) {

                if (appSettings.tax)
                    taxPer = appSettings.tax / 100;

                if (appSettings.commission)
                    commissionPer = appSettings.commission / 100;

                let quoteConfirmedFor = parseFloat(confirmedPrice);
                let bookingCommission = parseFloat(quoteConfirmedFor) * parseFloat(commissionPer);
                let bookingTax = parseFloat(quoteConfirmedFor) * parseFloat(taxPer);
                let totalAmount = parseFloat(quoteConfirmedFor) + parseFloat(bookingCommission) + parseFloat(bookingTax);

                updateString.commission = bookingCommission.toFixed(2);
                updateString.tax = bookingTax.toFixed(2);
                updateString.total = totalAmount.toFixed(2);
                updateString.price = quoteConfirmedFor.toFixed(2);
                updateString.status = "accepted";

                if (taskerId) {
                    updateString.taskerId = taskerId;
                }

                Booking.findByIdAndUpdate(bookingId, updateString, function (error, bookingDetails) {
                    if (!error) {
                        // console.log(error);
                        /* let logMessage = res.__("Your service has been") + " " + res.__("accepted");
                        logController.createLog(bookingDetails.taskerId, bookingDetails.userId, bookingDetails._id, logMessage); */
                    }
                });
            }
        });
    };

    // push notification for user
    let fcmNotification = function (userId, MsgData) {
        User.findOne({ "userId": userId, chatNotification: "true", deviceActive: 1 }, function (error, userDetails) {
            if (!error && userDetails) {
                fcmService.notifyUser(userDetails.deviceToken, { "title": MsgData.user_name, "scope": "chat", "message": JSON.stringify(MsgData) });
            }
        });
    };

});
