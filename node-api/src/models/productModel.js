const mongoose = require("mongoose");
const Schema = mongoose.Schema;

let productSchema = new Schema({
    itemTitle: { type: String, minlength: 1, maxlength: 60, required: true },
    itemDesc: { type: String, minlength: 1, maxlength: 2000, required: true },
    itemType: { type: String, minlength: 1, maxlength: 30, required: false },
    userId: { type: String, ref: 'Users', required: true },
    images: { type: String, required: true },
    price: { type: Number, minlength: 1, required: true },
    shippingprice: { type: Number, minlength: 1, required: false },
    moreprice: { type: Number, minlength: 1, required: false },
    mainCategory: { type: String, ref: 'Categories', required: true },
    subCategory: { type: String, ref: 'Subcategories', required: false },
    superCategory: { type: String, ref: 'Supercategories', required: false },
    CurrencyID: { type: String, ref: 'Currencies', required: true },
    locationID: { type: String, ref: 'Locations', required: false },
    productCondition: { type: String, ref: 'Productconditions', required: true },
    status: { type: Number, required: true, default: 1 },
    featured: { type: Number, required: false, default: 0 },
    featureDuration: { type: Number, required: false, default: 0 },
    reportCount: { type: Number, required: false, default: 0 },
    productAvailability: { type: String, required: true, default:"available" },
    sharelink: { type: String, required: false },
    latitude: { type: String, required: false },
    longitude: { type: String, required: false },
    locationName: { type: String, required: false },
    loc: { type: Array, default: [] },
    buynow: { type: String, required: true, default:"false" },
    featureactiveOn: { type: Date, required: true, default: Date.now() },
    featureexpireOn: { type: Date, required: true, default: Date.now() },
    postingDate: { type: Date, required: false, default: Date.now() },
    reportDate: { type: Date, required: false, default: Date.now() },
    location: {
       type: { type: String },
       coordinates: []
    }
}, { timestamps: true });

productSchema.index({ location: "2dsphere" });
// exports model
module.exports = mongoose.model("Products", productSchema);


