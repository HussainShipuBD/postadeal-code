const DeviceToken = require('../models/deviceTokenModel');

// models

exports.registerDevice = async function (req, res) {
    if (!req.body.device_id || !req.body.user_id || !req.body.device_token || !req.body.build_type || !req.body.platform) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    try {

        let userdeviceDetails = await DeviceToken.findOne({ deviceId: req.body.device_id });

        if(userdeviceDetails) {

        userdeviceDetails = await DeviceToken.findOneAndUpdate({ deviceId: req.body.device_id }, 
        { userId: req.body.user_id, deviceToken: req.body.device_token, buildType: req.body.build_type, platform: req.body.platform, langCode: req.body.lang_code, deviceOS: req.body.device_os, deviceModel: req.body.device_model, deviceName: req.body.device_name, })
            
        return res.status(200).json({ status: "true", message: res.__("Device updated successfully") });

        } else {

            let deviceData = {};
            deviceData.userId = req.body.user_id;
            deviceData.deviceId = req.body.device_id;
            deviceData.deviceToken = req.body.device_token;
            deviceData.buildType = req.body.build_type;
            deviceData.platform = req.body.platform;
            deviceData.langCode = req.body.lang_code;
            deviceData.deviceOS = req.body.device_os;
            deviceData.deviceModel = req.body.device_model;
            deviceData.deviceName = req.body.device_name;

            let devicetoken = new DeviceToken(deviceData);
            await devicetoken.save(function (error, deviceDetails) {
                if (!error) {
                    return res.status(200).json({
                        status: "true",
                        message: res.__("Device registered successfully")
                    });  
                } else {
                    console.log(error);
                    return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Device not registered") });
                }       
            });

        }
    }
    catch (err) {
    console.log(err);
        return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong. Please try again later.") });
    }
};


exports.removedevice = async function (req, res) {
    if (!req.body.user_id || !req.body.device_id || !req.body.lang_code || !req.body.device_token) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {


            let userdeviceDetails = await DeviceToken.findOne({ deviceId: req.body.device_id , deviceToken: req.body.device_token });

            if(userdeviceDetails) {

                DeviceToken.deleteOne({ deviceId: req.body.device_id , deviceToken: req.body.device_token }).exec();
                
                return res.status(200).json({ status: "true", message: res.__("Device removed successfully") });

            } else {

                return res.status(200).json({ status: "false", message: res.__("No devices found") });

            }

        }
        catch (err) {
            console.log(err);
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
          
    }
};
