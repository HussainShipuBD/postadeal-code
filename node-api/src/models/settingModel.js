const mongoose = require("mongoose");
const Schema = mongoose.Schema;

let settingSchema = new Schema({
	siteName: { type: String, minLength: 3, maxlength: 30, required: true },
	siteIcon: { type: String, minLength: 3, maxlength: 30, required: false },
	siteLogo: { type: String, minLength: 3, maxlength: 30, required: false },
	contactEmail: { type: String, minLength: 3, maxlength: 30, required: true },
	copyrightText: { type: String, minLength: 3, maxlength: 300, required: true },
	guideLine: { type: String, minLength: 3, maxlength: 5000, required: true },
	guideLineAr: { type: String, minLength: 3, maxlength: 5000, required: true },
	guideLineFr: { type: String, minLength: 3, maxlength: 5000, required: true },
	timezone: { type: String, required: false, default: "Asia/Calcutta" },
	currencyCode: { type: String, minLength: 1, maxlength: 5, required: true, default: "USD" },
	currencySymbol: { type: String, minLength: 1, maxlength: 5, required: true, default: "$" },
	privatekey: { type: String, required: false, },
	publickey: { type: String, required: false, },
	notificationkey: { type: String, required: false, },
	host: { type: String, required: false, },
	email: { type: String, required: false, },
	password: { type: String, required: false, },
	port: { type: String, required: false, },
	smtpStatus: { type: Number, required: false, },
	paymentType: { type: String, required: false, },
	facebookURL: { type: String, required: false, },
	linkedinURL: { type: String, required: false, },
	twitterURL: { type: String, required: false, },
	inviteLink: { type: String, required: false, },
	playstoreLink: { type: String, required: false, },
	appstoreLink: { type: String, required: false, },
	stripeChange:{type: String, required: false},
	promotioncurrencycode: { type: String, required: false },
	promotioncurrencysymbol: { type: String, required: false },
	promotioncurrencyname: { type: String, required: false },
}, { timestamps: true });

// exports model
module.exports = mongoose.model("Settings", settingSchema);