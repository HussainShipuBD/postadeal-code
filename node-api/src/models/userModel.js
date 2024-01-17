const mongoose = require("mongoose");
const Schema = mongoose.Schema;
const bcrypt = require('bcrypt');

let userSchema = new Schema({
    userId: { type: String, required: false, unique: true },
    name: { type: String, minlength: 3, maxlength: 40, required: true },
    email: { type: String, lowercase: true, trim: true, unique: true, required: true },
    password: { type: String, minlength: 6, maxlength: 255, trim: true, required: false },
   // lang_code: { type: String, required: false },
    mobile: { type: String, minlength: 6, maxlength: 15, trim: true, required: false },
    location: { type: String, trim: true, required: false },
    image: { type: String, required: false, },
    status: { type: Number, required: false, default: 1 },
    emailVerification: { type: Number, required: false, default: 0 },
    fbVerification: { type: Number, required: false, default: 0 }, 
    rating: { type: String, required: false, default: "0" }, 
    reviews: { type: String, required: false, default: "0" }, 
    chatNotification: { type: String, required: false, enum: ['true', 'false'], default: "true" },
    facebookId: { type: String, required: false },
    googleId: { type: String, required: false },
    emailNotification: { type: String, required: false, enum: ['true', 'false'], default: "true" },
    pushNotification: { type: String, required: false, enum: ['true', 'false'], default: "true" },
    chatCount: { type: Number, required: false, default: 0 },
    notificationCount: { type: Number, required: false, default: 0 },
    online_status: { type: String, required: false },
    lastActive: { type: Date, required: false, default: Date.now() },
    stripeSecretKey: { type: String, required: false, },
    stripePublicKey: { type: String, required: false, },
    rating: { type: String, required: false, default: "0" },
    reviews: { type: String, required: false, default: "0" },
    //lang_code: { type: String, required: false },
    //lastActive: { type: Date, required: false, default: Date.now() },
   // createdAt: { type: Date, required: false, default: Date.now() },
}, { timestamps: true });

// password hash
userSchema.pre('save', async function (next) {
   if(this.password) {
    try {
        if (this.isModified("password") || this.isNew) {
            const salt = await bcrypt.genSalt(10);
            const hashedPassword = await bcrypt.hash(this.password, salt);
            this.password = hashedPassword;
        }
        next()
    } catch (error) {
        next(error)
    }
    }
});


// exports model
module.exports = mongoose.model("Users", userSchema);

// password validation
module.exports.isValidPassword = async function (currentPassword, dbPassword) {
    try {
        return await bcrypt.compare(currentPassword, dbPassword);
    } catch (error) {
        throw error
    }
};

// password validation
module.exports.SamePassword = async function (oldPassword, newPassword) {
    try {
        return await bcrypt.compare(currentPassword, dbPassword);
    } catch (error) {
        throw error
    }
};

