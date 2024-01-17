const mongoose = require("mongoose");
const Schema = mongoose.Schema;

let logSchema = new Schema({
    senderId: { type: Schema.Types.ObjectId, ref: 'Users', required: false },
    receiverId: { type: Schema.Types.ObjectId, ref: 'Users', required: false },
    messageTxt: { type: String, required: true },
    messageType: { type: String, required: true, default: "admin" },
    sourceId: { type: Schema.Types.ObjectId, ref: 'Products', required: false, },
    isAdmin: { type: Number, required: false, enum: [0, 1], default: 0 },
    chatId: { type: String, required: false, default: "0" },
}, { timestamps: true });

// exports model
module.exports = mongoose.model("Logs", logSchema);