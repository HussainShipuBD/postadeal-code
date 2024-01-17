const mongoose = require("mongoose");
const Schema = mongoose.Schema;

let currencySchema = new Schema({
	currencycode: { type: String, required: true },
	currencysymbol: { type: String, required: true },
	currencyname: { type: String, required: true },
}, { timestamps: true });

// exports model
module.exports = mongoose.model("Currencies", currencySchema);
