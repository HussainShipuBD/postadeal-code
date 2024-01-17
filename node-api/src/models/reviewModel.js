const mongoose = require("mongoose");
const Schema = mongoose.Schema;

let reviewSchema = new Schema({
    userId: { type: Schema.Types.ObjectId, ref: 'Users', required: true },
    sellerId: { type: Schema.Types.ObjectId, ref: 'Users', required: true },
    itemId: { type: Schema.Types.ObjectId, ref: 'Products', required: true },
    orderId: { type: Schema.Types.ObjectId, ref: 'Orders', required: true },
    rating: { type: Number, required: true },
    message: { type: String, required: false },
    reviewDate: { type: Date, required: false, default: Date.now() },
}, { timestamps: true });

// exports model
module.exports = mongoose.model("Reviews", reviewSchema);