const mongoose = require("mongoose");
const Schema = mongoose.Schema;

let locationSchema = new Schema({
    name: { type: String, required: true },

}, { timestamps: true });

// exports model
module.exports = mongoose.model("Locations", locationSchema);
