const mongoose = require("mongoose");
const Schema = mongoose.Schema;

let commissionSchema = new Schema({
    percentage: { type: Number, required: true },
    minrange: { type: Number, required: true },
    maxrange: { type: Number, required: true },


}, { timestamps: true });

// exports model
module.exports = mongoose.model("Commissions", commissionSchema);
