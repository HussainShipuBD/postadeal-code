const mongoose = require("mongoose");

const User = require('../models/userModel');
const Address = require('../models/addressModel');

// fcm service
const fcmService = require('../controllers/fcmController');

const logController = require("../controllers/logController");

exports.addaddress = async function (req, res) {
    if (!req.body.lang_code || !req.body.user_id || !req.body.name || !req.body.phone || !req.body.address_line1 | !req.body.address_line2 || !req.body.country || !req.body.pincode) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {

            let userDetails = await User.findOne({ _id: req.body.user_id });

            if (userDetails.status === 0)
            return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });

            if (req.body.address_id) {

                let addressdetails = await Address.findById(req.body.address_id);

                if (!addressdetails)
                  return res.status(200).json({ status: "true", result:  "Address doesn't Exists" });

                addressdetails.name = req.body.name;
                addressdetails.phone = req.body.phone;
                addressdetails.addressOne = req.body.address_line1;
                addressdetails.addressTwo = req.body.address_line2;
                addressdetails.country = req.body.country;
                addressdetails.pincode = req.body.pincode;

                addressdetails.save();

                let addressdtls = await Address.findById(req.body.address_id);
                
                return res.status(200).json({ status: "true", message:  "Address edited successfully",
                address_id: addressdtls._id,
                name: addressdtls.name,
                phone: addressdtls.phone,
                address_line1: addressdtls.addressOne,
                address_line2: addressdtls.addressTwo,
                country: addressdtls.country,
                pincode: addressdtls.pincode
                 });
            }
            else {

                
                let addressData = {};

                addressData.userId = req.body.user_id;
                addressData.name = req.body.name;
                addressData.phone = req.body.phone;
                addressData.addressOne = req.body.address_line1;
                addressData.addressTwo = req.body.address_line2;
                addressData.country = req.body.country;
                addressData.pincode = req.body.pincode;
                addressData.addressDate = Date.now();

                let newAddress = new Address(addressData);
                await newAddress.save(function (error, addressDetails) {
                    if (!error) {
                        return res.status(200).json({ status: "true", message:  "Address added successfully", 
                        address_id: addressDetails._id,
                        name: addressDetails.name,
                        phone: addressDetails.phone,
                        address_line1: addressDetails.addressOne,
                        address_line2: addressDetails.addressTwo,
                        country: addressDetails.country,
                        pincode: addressDetails.pincode
 });
                    } else {
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


exports.deleteaddress = async function (req, res) {
    if (!req.body.lang_code || !req.body.user_id || !req.body.address_id) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {

            let userDetails = await User.findOne({ _id: req.body.user_id });

            if (userDetails.status === 0)
                return res.status(200).json({ status: "false", short_code: "block", message: res.__("Account blocked by Admin") });


            const addressExists = await Address.findOne({ userId: req.body.user_id , _id: req.body.address_id });


            if (!addressExists) {
                return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") }); 
            } else {

                    Address.deleteOne({ _id: req.body.address_id , userId: req.body.user_id }, function(err) {
                        if (!err) {
                            return res.status(200).json({ status: "true", message: res.__("Address deleted successfully") });
                        }
                        else {
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

exports.myaddress = async function (req, res) {
    if (!req.body.lang_code || !req.body.user_id) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {

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

            let userAddress = await Address.find({"userId": req.body.user_id}).sort({ "addressDate": -1 }).limit(limit).skip(offset);

            if (userAddress.length === 0)
                 return res.status(200).json({ status: "false", message:  "No Address Found" });

            let addressList = [];

            for (var i = 0; i < userAddress.length; i++) {

                addressList.push({
                        address_id: userAddress[i]._id,
                        name: userAddress[i].name,
                        phone: userAddress[i].phone,
                        address_line1: userAddress[i].addressOne,
                        address_line2: userAddress[i].addressTwo,
                        country: userAddress[i].country,
                        pincode: userAddress[i].pincode

                });

            }

                return res.status(200).json({ status: "true", result:  addressList });

        }
        catch (err) {
                return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};
