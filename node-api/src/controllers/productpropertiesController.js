const Currency = require('../models/currencyModel');
const Productcondition = require('../models/productConditionModel');
const Location = require('../models/locationModel');


exports.productProperties = async function (req, res) {
    if (!req.query.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {
            let currencyDetail = await Currency.find();

            let currencyList = [];
            currencyDetail.filter(function (currency_details) {
                currencyList.push({
                    id: currency_details._id,
                    currency_name: currency_details.currencyname,
                    currency_sym: currency_details.currencysymbol,
                    currency_code: currency_details.currencycode
                });
            });
            
            let productconditions = await Productcondition.find();

            let conditionlist = [];
            productconditions.filter(function (condition) {
                conditionlist.push({
                    id: condition._id,
                    name: condition.name
                });
            });
            
            return res.status(200).json({ status: "true", currency: currencyList, item_condition: conditionlist });
            
        }
        catch (err) {
        
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};

exports.getLocation = async function (req, res) {
    if (!req.query.lang_code) {
        return res.status(200).json({ status: "false", short_code: "invalid", message: res.__("Invalid Params") });
    }
    else {
        try {

            //limit = parseInt(req.query.limit);
            //offset = parseInt(req.query.offset);

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

            let allLocations = await Location.find(searchString).limit(limit).skip(offset);

                if (!allLocations)
                return res.status(200).json({ status: "true", result: [] });

                let locationList = [];
                allLocations.filter(function (locations) {
                    locationList.push({
                        location_id: locations._id,
                        location: locations.name,
                    });
                });
               

                return res.status(200).json({ status: "true", result: locationList });


            
        }
        catch (err) {
            return res.status(200).json({ status: "false", short_code: "error", message: res.__("Something went wrong") });
        }
    }
};





