const mongoose = require("mongoose");
const Schema = mongoose.Schema;

let messageSchema = new Schema({
    chatId: { type: String, ref: 'Chats', required: true },
    type: { type: String, required: true },
    userId: { type: String, ref: 'Users', required: true },
    message: { type: String, required: false },
    attachment: { type: String, required: false },
    initial_message: { type: String, required: true, default: "false" },
    msgDate: { type: Date, required: false, default: Date.now() },
}, { timestamps: true });

// exports model
module.exports = mongoose.model("Messages", messageSchema);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     