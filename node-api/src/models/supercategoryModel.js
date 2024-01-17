const mongoose = require("mongoose");
const Schema = mongoose.Schema;

let supercategorySchema = new Schema({
    name: { type: String, minLength: 3, maxlength: 30, required: true },
    parentCategory: { type: Schema.Types.ObjectId, ref: 'Categories', required: true },
    subCategory: { type: Schema.Types.ObjectId, ref: 'Subcategories', required: true },
}, { timestamps: true });

// exports model
module.exports = mongoose.model("Supercategories", supercategorySchema);
