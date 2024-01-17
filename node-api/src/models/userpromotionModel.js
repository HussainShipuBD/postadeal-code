const mongoose = require("mongoose");
const Schema = mongoose.Schema;

let userpromotionSchema = new Schema({
    userId: { type: Schema.Types.ObjectId, ref: 'Users', required: true },
    itemId: { type: Schema.Types.ObjectId, ref: 'Products', required: true },
    promotionId: { type: Schema.Types.ObjectId, ref: 'Promotions', required: true },
    currencySymbol: { type: String, required: true },
    currencyCode: { type: String, required: true },
    activeOn: { type: Date, required: true, default: Date.now() },
    expireOn: { type: Date, required: true, default: Date.now() },

}, { timestamps: true });

// exports model
module.exports = mongoose.model("Userpromotions", userpromotionSchema);
