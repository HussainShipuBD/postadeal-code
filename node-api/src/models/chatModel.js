const mongoose = require("mongoose");
const Schema = mongoose.Schema;

let chatSchema = new Schema({
    userId: { type: String, ref: 'Users', required: true },
    itemId: { type: String, ref: 'Products', required: true },
    sellerId: { type: String, ref: 'Users', required: true },
    chatBlockByUser: { type: String, required: false, enum: ['true', 'false'], default: "false" },
    chatBlockBySeller: { type: String, required: false, enum: ['true', 'false'], default: "false" },
    unread: { type: String, required: false, enum: ['true', 'false'], default: "false" },
    lastMessage: { type: String, ref: 'Messages', required: false },
    lastMessageUser: { type: String, ref: 'Users', required: false },
    lastMessageOn: { type: Date, default: Date.now() },
    chatClearByUser: {type: Date, required: false},
    chatClearBySeller: {type: Date, required: false},
    chatClearUpdatedUser: {type: Number, default: 0},
    chatClearUpdatedSeller: {type: Number, default: 0},
    chatDate: { type: Date, required: false, default: Date.now() },
}, { timestamps: true });

// exports model
module.exports = mongoose.model("Chats", chatSchema);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  