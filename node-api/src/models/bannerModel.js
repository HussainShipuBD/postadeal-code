const mongoose = require("mongoose");
const Schema = mongoose.Schema;

let bannerSchema = new Schema({
    name: { type: String, required: true },
    url: { type: String, required: true },
    image: { type: String, required: true },
    status: { type: Number, required: false, default: 1 },
}, { timestamps: true });

// exports model
module.exports = mongoose.model("banners", bannerSchema); 