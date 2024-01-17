const FCM = require("fcm-push");
const apn = require("apn");

let UserDevices = require('../models/deviceTokenModel');
let settingModel = require('../models/settingModel');


/* COMPOSE SINGLE PUSH NOTIFICATIONS */
sendNotification = function(member, data, itemData) {
  console.log("SEND NOTIFICATION CALLED"+data);
  UserDevices.findOne({
    userId: member
  }).exec(function(err, chatdevices) {
    if (chatdevices && !err) {
      //if (chatdevices.device_type == "1") {

        console.log("Android");
        notifyMsg(chatdevices.deviceToken, data, itemData, "1");

      /*} else {
        let mode = chatdevices.device_mode;
        let prod_tokens =[];
        prod_tokens.push(chatdevices.fcm_token);
        let wrap_message = {};
        wrap_message.notification_data = data;
        notifyiOS(prod_tokens, wrap_message, data);
      }*/

    }
    else{
      console.log("elsepart="+err);
    }
  });
};


notifyMsg = function(devicetokens, data, itemData, recipients) {
  let settingsQuery = settingModel.findOne({}).limit(1);
  settingsQuery.exec(function(err, settings) {
    if (!err) {
      let fcmkey = settings.notificationkey;
      let fcm = new FCM(fcmkey);
      let fcm_msg = {};
      fcm_msg.notification = data;
      fcm_msg.data = itemData;
      fcm_msg.priority = "high";
      // check recipients count
      //if (recipients == "1") {
        fcm_msg.to = devicetokens;
      /*} else {
        fcm_msg.registration_ids = devicetokens;
      }*/
      fcm
      .send(fcm_msg)
      .then(function(response) {
         console.log("Pushnotification success" + response); 
      })
      .catch(function(err) {
         console.log("Pushnotification Error:" + err); 
      });
    }
  });
};

module.exports = {
  sendNotification: sendNotification
};