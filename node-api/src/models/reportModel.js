const mongoose = require("mongoose");
const Schema = mongoose.Schema;

let reportSchema = new Schema({
    userId: { type: String, ref: 'Users', required: true },
    itemId: { type: String, ref: 'Products', required: true },

}, { timestamps: true });

// exports model
module.exports = mongoose.model("Reports", reportSchema);


