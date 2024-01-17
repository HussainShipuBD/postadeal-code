const mongoose = require("mongoose");
const Schema = mongoose.Schema;

let helpSchema = new Schema({
    name: { type: String, minLength: 3, maxlength: 250, required: true },
    description: { type: String, required: true },
}, { timestamps: true });   

// exports model
module.exports = mongoose.model("Helps", helpSchema);