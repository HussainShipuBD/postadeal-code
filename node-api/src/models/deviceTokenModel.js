const mongoose = require("mongoose");
const Schema = mongoose.Schema;

let devicetokenSchema = new Schema({
	userId: { type: String, required: true },
    deviceId: { type: String, trim: true, required: true },
    deviceToken: { type: String, trim: true, required: true },
    buildType: { type: String, required: true, enum: ['debug', 'release'] },
    platform: { type: String, required: true, enum: ['android', 'ios'] },
    langCode: { type: String, required: true },
    deviceOS: { type: String, trim: true, required: true },
    deviceModel: { type: String, trim: true, required: true },
    deviceName: { type: String, trim: true, required: true },
    lastActive: { type: Date, required: false, default: Date.now() },
}, { timestamps: true });


// exports model
module.exports = mongoose.model("devicetokens", devicetokenSchema);