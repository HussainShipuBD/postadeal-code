const mongoose = require("mongoose");
const Schema = mongoose.Schema;

let addressSchema = new Schema({
    userId: { type: Schema.Types.ObjectId, ref: 'Users', required: true },
    phone: { type: String, required: true },
    name: { type: String, required: true },
    addressOne: { type: String, required: true },
    addressTwo: { type: String, required: true },
    country: { type: String, required: true },
    pincode: { type: String, required: true },
    addressDate: { type: Date, required: false, default: Date.now() },
}, { timestamps: true });

// exports model
module.exports = mongoose.model("Address", addressSchema);


