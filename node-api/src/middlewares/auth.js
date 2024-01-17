const jwt = require("jsonwebtoken");
const fs = require('fs');

const PUB_KEY = fs.readFileSync(__dirname + '/public.pem', 'utf8');
const PRIV_KEY = fs.readFileSync(__dirname + '/key.pem', 'utf8');


exports.userJwt = async function (req, res, next) {
    //const token = req.headers.authorization;
     const token = req.header('auth_token');
    //console.log(token);
    if (!token) return res.status(200).json({ status: "false", message: res.__("Unauthorized access") });
    try {

        const decodedJWT = jwt.verify(token, PUB_KEY, { algorithms: ['RS256'] });
        
         //console.log(decodedJWT.userId);

        // const decodedJWT = jwt.verify(token, process.env.JWT_SECRET, {});
        if (decodedJWT.userId !== req.body.user_id) {
            return res.status(200).json({ status: "false", message: res.__("Invalid Token") });
        }
        return next();
    } catch (error) {
        //console.log(error);
        return res.status(200).json({ status: "false", message: res.__("Invalid Token") });
    }
};

exports.sellerJwt = async function (req, res, next) {
    //const token = req.headers.authorization;
     const token = req.header('auth_token');
    //console.log(token);
    if (!token) return res.status(200).json({ status: "false", message: res.__("Unauthorized access") });
    try {

        const decodedJWT = jwt.verify(token, PUB_KEY, { algorithms: ['RS256'] });
        
         //console.log(decodedJWT.userId);

        // const decodedJWT = jwt.verify(token, process.env.JWT_SECRET, {});
        if (decodedJWT.userId !== req.body.seller_id) {
            return res.status(200).json({ status: "false", message: res.__("Invalid Token") });
        }
        return next();
    } catch (error) {
        //console.log(error);
        return res.status(200).json({ status: "false", message: res.__("Invalid Token") });
    }
};

exports.taskerJwt = async function (req, res, next) {
    const token = req.headers.authorization;
    if (!token) return res.status(200).json({ status_code: 401, message: res.__("Unauthorized access") });
    try {
        const decodedJWT = jwt.verify(token, PUB_KEY, { algorithms: ['RS256'] });
        // const decodedJWT = jwt.verify(token, process.env.JWT_SECRET, {});
        if ((decodedJWT.userId !== req.body.user_id) || (decodedJWT.userRole !== "tasker")) {
            return res.status(200).json({ status_code: 401, message: res.__("Invalid Token") });
        }
        return next();
    } catch (error) {
        return res.status(200).json({ status_code: 401, message: res.__("Invalid Token") });
    }
};

exports.commonJwt = async function (req, res, next) {
    const token = req.headers.authorization;
    if (!token) return res.status(200).json({ status_code: 401, message: res.__("Unauthorized access") });
    try {
        const decodedJWT = jwt.verify(token, PUB_KEY, { algorithms: ['RS256'] });
        // const decodedJWT = jwt.verify(token, process.env.JWT_SECRET, {});
        return next();
    } catch (error) {
        return res.status(200).json({ status_code: 401, message: res.__("Invalid Token") });
    }
};

exports.createJwt = function (userInfo) {
    if (userInfo.name && userInfo.id) {
        // return jwt.sign({ "userName": userInfo.name, "userId": userInfo.userId, "userRole": userInfo.role }, process.env.JWT_SECRET, {});
        return jwt.sign({ "userName": userInfo.name, "userId": userInfo._id}, PRIV_KEY, { algorithm: 'RS256' });
    }
};
