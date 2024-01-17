const mongoose = require("mongoose");
const Schema = mongoose.Schema;

let promotionSchema = new Schema({
    name: { type: String, minLength: 3, maxlength: 30, required: true },
    duration: { type: String, required: true },
    price: { type: Number, required: true },

}, { timestamps: true });

// exports model
module.exports = mongoose.model("Promotions", promotionSchema);
