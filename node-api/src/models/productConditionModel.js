const mongoose = require("mongoose");
const Schema = mongoose.Schema;

let productconditionSchema = new Schema({
    name: { type: String, minLength: 3, maxlength: 30, required: true },

}, { timestamps: true });

// exports model
module.exports = mongoose.model("Productconditions", productconditionSchema);
