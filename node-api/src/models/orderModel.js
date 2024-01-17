const mongoose = require("mongoose");
const Schema = mongoose.Schema;

let orderSchema = new Schema({
    userId: { type: Schema.Types.ObjectId, ref: 'Users', required: true },
    sellerId: { type: Schema.Types.ObjectId, ref: 'Users', required: false },
    itemId: { type: Schema.Types.ObjectId, ref: 'Products', required: false },
    addressId: { type: Schema.Types.ObjectId, ref: 'Address', required: false },
    otp: { type: String, minlength: 4, required: true },
    price: { type: Number, minlength: 1, required: true },
    shippingprice: { type: Number, minlength: 1, required: false },
    totalprice: { type: String, minlength: 1, required: false },
    commissionprice: { type: String, required: false },
    currency: { type: String, required: true },
    currencyCode: { type: String, required: true },
    pay_token: { type: String, required: true },
    status: { type: String, required: true, enum: ['incomplete', 'delivered', 'paid', 'cancelled', 'settled', 'refunded'] },
    orderDate: { type: Date, required: false, default: Date.now() },
    deliveredDate: { type: Date, required: false, default: Date.now() },
}, { timestamps: true });

// exports model
module.exports = mongoose.model("Orders", orderSchema);


