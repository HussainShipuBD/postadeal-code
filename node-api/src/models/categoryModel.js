const mongoose = require("mongoose");
const Schema = mongoose.Schema;

let categorySchema = new Schema({
    name: { type: String, minlength: 3, maxlength: 30, required: true, unique: true },
    image: { type: String, maxlength: 30, required: false, default: "category.png" },
    title: { type: String, required: false },
    description: { type: String, required: false },
}, { timestamps: true });

// exports model
module.exports = mongoose.model("Categories", categorySchema);
