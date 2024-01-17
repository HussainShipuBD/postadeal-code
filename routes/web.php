<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Admin\DashboardController;



Route::get('/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::get('/admin', [App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'login'])->name('admin.authentication');

Route::post('adminlogout', function () {
    Auth::guard('admin')->logout();
    return redirect('admin')->with('success','Logged out successfully');
})->name('adminlogout');


Route::post('/api/imageupload', [App\Http\Controllers\Api\MediaController::class, 'imageupload']);


Route::group(['middleware' => ['auth:admin']], function () {
	Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('index');

	//Route::get('/admin/maincategory','Admin\CategoryController@index')->name('index');
	Route::get('/admin/maincategory', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('category.index');
	Route::get('/admin/categorysearch', [App\Http\Controllers\Admin\CategoryController::class, 'search'])->name('category.search');
	Route::get('/admin/addcategory', [App\Http\Controllers\Admin\CategoryController::class, 'addcategory'])->name('category.create');
	Route::post('/admin/storecategory', [App\Http\Controllers\Admin\CategoryController::class, 'storecategory'])->name('category.store');
	Route::get('/admin/editcategory/{categoryId}', [App\Http\Controllers\Admin\CategoryController::class, 'editcategory'])->name('category.edit');
	Route::post('/admin/updatecategory/{categoryId}', [App\Http\Controllers\Admin\CategoryController::class, 'updatecategory'])->name('category.update');
	Route::get('/admin/deletecategory/{categoryId}', [App\Http\Controllers\Admin\CategoryController::class, 'deletecategory'])->name('category.delete');



	Route::get('/admin/subcategory', [App\Http\Controllers\Admin\SubCategoryController::class, 'subcategories'])->name('subcategories.index');
	Route::get('/admin/subcategorysearch', [App\Http\Controllers\Admin\SubCategoryController::class, 'search'])->name('subcategories.search');
	Route::get('/admin/addsubcategory', [App\Http\Controllers\Admin\SubCategoryController::class, 'addsubcategory'])->name('subcategories.create');
	Route::post('/admin/storesubcategory', [App\Http\Controllers\Admin\SubCategoryController::class, 'storesubcategory'])->name('subcategories.store');
	Route::get('/admin/editsubcategory/{categoryId}', [App\Http\Controllers\Admin\SubCategoryController::class, 'editsubcategory'])->name('subcategories.edit');
	Route::post('/admin/updatesubcategory/{categoryId}', [App\Http\Controllers\Admin\SubCategoryController::class, 'updatesubcategory'])->name('subcategories.update');
	Route::get('/admin/deletesubcategory/{categoryId}', [App\Http\Controllers\Admin\SubCategoryController::class, 'deletesubcategory'])->name('subcategories.delete');




	Route::get('/admin/supercategory', [App\Http\Controllers\Admin\SuperCategoryController::class, 'supercategories'])->name('supercategories.index');
	Route::get('/admin/supercategorysearch', [App\Http\Controllers\Admin\SuperCategoryController::class, 'search'])->name('supercategories.search');
	Route::get('/admin/addsupercategory', [App\Http\Controllers\Admin\SuperCategoryController::class, 'addsupercategory'])->name('supercategories.create');
	Route::post('/admin/storesupercategory', [App\Http\Controllers\Admin\SuperCategoryController::class, 'storesupercategory'])->name('supercategories.store');
	Route::post('/admin/ajaxsubcategories', [App\Http\Controllers\Admin\SuperCategoryController::class, 'ajaxsubcategories'])->name('supercategories.ajaxsubcategories');
	Route::get('/admin/editsupercategory/{categoryId}', [App\Http\Controllers\Admin\SuperCategoryController::class, 'editsupercategory'])->name('supercategories.edit');
	Route::post('/admin/updatesupercategory/{categoryId}', [App\Http\Controllers\Admin\SuperCategoryController::class, 'updatesupercategory'])->name('supercategories.update');
	Route::get('/admin/deletesupercategory/{categoryId}', [App\Http\Controllers\Admin\SuperCategoryController::class, 'deletesupercategory'])->name('supercategories.delete');




	Route::get('/admin/productcondition', [App\Http\Controllers\Admin\ProductConditionController::class, 'index'])->name('productconditions.index');
	Route::get('/admin/searchcondition', [App\Http\Controllers\Admin\ProductConditionController::class, 'search'])->name('productconditions.search');
	Route::get('/admin/addcondition', [App\Http\Controllers\Admin\ProductConditionController::class, 'addcondition'])->name('productconditions.create');
	Route::post('/admin/storecondition', [App\Http\Controllers\Admin\ProductConditionController::class, 'storecondition'])->name('productconditions.store');
	Route::get('/admin/editproductcondition/{conditionId}', [App\Http\Controllers\Admin\ProductConditionController::class, 'editproductcondition'])->name('productconditions.edit');
	Route::post('/admin/updateproductcondition/{conditionId}', [App\Http\Controllers\Admin\ProductConditionController::class, 'updateproductcondition'])->name('productconditions.update');
	Route::get('/admin/deleteproductcondition/{conditionId}', [App\Http\Controllers\Admin\ProductConditionController::class, 'deleteproductcondition'])->name('productconditions.delete');




	Route::get('/admin/location', [App\Http\Controllers\Admin\LocationController::class, 'index'])->name('locations.index');
	Route::get('/admin/searchlocation', [App\Http\Controllers\Admin\LocationController::class, 'search'])->name('locations.search');
	Route::get('/admin/addlocation', [App\Http\Controllers\Admin\LocationController::class, 'addlocation'])->name('locations.create');
	Route::post('/admin/storelocation', [App\Http\Controllers\Admin\LocationController::class, 'storelocation'])->name('locations.store');
	Route::get('/admin/editlocation/{locationId}', [App\Http\Controllers\Admin\LocationController::class, 'editlocation'])->name('locations.edit');
	Route::post('/admin/updatelocation/{locationId}', [App\Http\Controllers\Admin\LocationController::class, 'updatelocation'])->name('locations.update');
	Route::get('/admin/deletelocation/{locationId}', [App\Http\Controllers\Admin\LocationController::class, 'deletelocation'])->name('locations.delete');



	Route::get('/admin/currency', [App\Http\Controllers\Admin\CurrencyController::class, 'index'])->name('currency.index');
	Route::get('/admin/searchcurrency', [App\Http\Controllers\Admin\CurrencyController::class, 'search'])->name('currency.search');
	Route::get('/admin/addcurrency', [App\Http\Controllers\Admin\CurrencyController::class, 'addcurrency'])->name('currency.create');
	Route::post('/admin/storecurrency', [App\Http\Controllers\Admin\CurrencyController::class, 'storecurrency'])->name('currency.store');
	Route::get('/admin/editcurrency/{currencyId}', [App\Http\Controllers\Admin\CurrencyController::class, 'editcurrency'])->name('currency.edit');
	Route::post('/admin/updatecurrency/{currencyId}', [App\Http\Controllers\Admin\CurrencyController::class, 'updatecurrency'])->name('currency.update');
	Route::get('/admin/deletecurrency/{currencyId}', [App\Http\Controllers\Admin\CurrencyController::class, 'deletecurrency'])->name('currency.delete');




	Route::get('/admin/banner', [App\Http\Controllers\Admin\BannerController::class, 'index'])->name('banner.index');
	Route::get('/admin/bannersearch', [App\Http\Controllers\Admin\BannerController::class, 'search'])->name('banner.search');
	Route::get('/admin/addbanner', [App\Http\Controllers\Admin\BannerController::class, 'addbanner'])->name('banner.create');
	Route::post('/admin/storebanner', [App\Http\Controllers\Admin\BannerController::class, 'storebanner'])->name('banner.store');
	Route::get('/admin/editbanner/{bannerId}', [App\Http\Controllers\Admin\BannerController::class, 'editbanner'])->name('banners.edit');
	Route::post('/admin/updatebanner/{bannerId}', [App\Http\Controllers\Admin\BannerController::class, 'updatebanner'])->name('banners.update');
	Route::get('/admin/deletebanner/{bannerId}', [App\Http\Controllers\Admin\BannerController::class, 'deletebanner'])->name('banners.delete');


	Route::get('/admin/approvedusers', [App\Http\Controllers\Admin\UserController::class, 'approvedusers'])->name('users.approved');
	Route::get('/admin/pendingusers', [App\Http\Controllers\Admin\UserController::class, 'pendingusers'])->name('users.pending');
	Route::get('/admin/approvedusersearch', [App\Http\Controllers\Admin\UserController::class, 'approvedusersearch'])->name('users.approvedusersearch');
	Route::get('/admin/pendingusersearch', [App\Http\Controllers\Admin\UserController::class, 'pendingusersearch'])->name('users.pendingusersearch');
	Route::get('/admin/edituser/{userId}', [App\Http\Controllers\Admin\UserController::class, 'edituser'])->name('users.edit');
	Route::post('/admin/updateuser/{userId}', [App\Http\Controllers\Admin\UserController::class, 'updateuser'])->name('users.update');
	Route::get('/admin/changestatus/{userId}', [App\Http\Controllers\Admin\UserController::class, 'changestatus'])->name('users.changestatus');


	Route::get('/admin/approveditems', [App\Http\Controllers\Admin\ProductController::class, 'approveditems'])->name('products.approved');
	Route::get('/admin/pendingitems', [App\Http\Controllers\Admin\ProductController::class, 'pendingitems'])->name('products.pending');
	Route::get('/admin/approveditemsearch', [App\Http\Controllers\Admin\ProductController::class, 'approveditemsearch'])->name('products.approveditemsearch');
	Route::get('/admin/pendingitemsearch', [App\Http\Controllers\Admin\ProductController::class, 'pendingitemsearch'])->name('products.pendingitemsearch');
	Route::get('/admin/viewitem/{itemId}', [App\Http\Controllers\Admin\ProductController::class, 'viewitem'])->name('products.view');
	Route::post('/admin/updateitem/{itemId}', [App\Http\Controllers\Admin\ProductController::class, 'updateitem'])->name('products.update');
	Route::get('/admin/changeitemstatus/{itemId}', [App\Http\Controllers\Admin\ProductController::class, 'changestatus'])->name('products.changestatus');
	Route::get('/admin/deleteitem/{itemId}', [App\Http\Controllers\Admin\ProductController::class, 'deleteitem'])->name('products.delete');
	Route::get('/admin/reportitems', [App\Http\Controllers\Admin\ProductController::class, 'reportitems'])->name('products.reports');
	Route::get('/admin/reportitemsearch', [App\Http\Controllers\Admin\ProductController::class, 'reportitemsearch'])->name('products.reportitemsearch');

	Route::get('/admin/help', [App\Http\Controllers\Admin\HelpController::class, 'index'])->name('helps.index');
	Route::get('/admin/addhelp', [App\Http\Controllers\Admin\HelpController::class, 'addhelp'])->name('helps.create');
	Route::post('/admin/storehelp', [App\Http\Controllers\Admin\HelpController::class, 'storehelp'])->name('helps.store');
	Route::get('/admin/edithelp/{helpId}', [App\Http\Controllers\Admin\HelpController::class, 'edithelp'])->name('helps.edit');
	Route::post('/admin/updatehelp/{helpId}', [App\Http\Controllers\Admin\HelpController::class, 'updatehelp'])->name('helps.update');
	Route::get('/admin/deletehelp/{helpId}', [App\Http\Controllers\Admin\HelpController::class, 'deletehelp'])->name('helps.delete');

	Route::get('/admin/logosettings', [App\Http\Controllers\Admin\SettingController::class, 'logosettings'])->name('settings.logo');
	Route::post('/admin/logoupdate', [App\Http\Controllers\Admin\SettingController::class, 'logoupdate'])->name('settings.logoupdate');
	Route::get('/admin/defaultsettings', [App\Http\Controllers\Admin\SettingController::class, 'defaultsetting'])->name('settings.default');
	Route::post('/admin/defaultsettingsupdate', [App\Http\Controllers\Admin\SettingController::class, 'defaultsettingsupdate'])->name('settings.defaultsettingsupdate');
	Route::get('/admin/smtpsettings', [App\Http\Controllers\Admin\SettingController::class, 'smtpsetting'])->name('settings.smtp');
	Route::post('/admin/smtpsettingsupdate', [App\Http\Controllers\Admin\SettingController::class, 'smtpsettingsupdate'])->name('settings.smtpsettingsupdate');
	Route::get('/admin/stripesettings', [App\Http\Controllers\Admin\SettingController::class, 'stripesetting'])->name('settings.stripe');
	Route::post('/admin/stripesettingsupdate', [App\Http\Controllers\Admin\SettingController::class, 'stripesettingsupdate'])->name('settings.stripesettingsupdate');
	Route::get('/admin/notificationsettings', [App\Http\Controllers\Admin\SettingController::class, 'notificationsetting'])->name('settings.notification');
	Route::post('/admin/notificationsettingsupdate', [App\Http\Controllers\Admin\SettingController::class, 'notificationsettingsupdate'])->name('settings.notificationsettingsupdate');

	Route::post('/admin/sendalert', [App\Http\Controllers\Admin\DashboardController::class, 'sendalert'])->name('settings.sendalert');


	Route::get('/admin/editadminsettings', [App\Http\Controllers\Admin\SettingController::class, 'editadminsettings'])->name('settings.editadmin');
	Route::post('/admin/adminsettingsupdate', [App\Http\Controllers\Admin\SettingController::class, 'adminsettingsupdate'])->name('settings.adminsettingsupdate');

	Route::get('/admin/editadminpassword', [App\Http\Controllers\Admin\SettingController::class, 'editadminpassword'])->name('settings.editpassword');
	Route::post('/admin/adminpasswordupdate', [App\Http\Controllers\Admin\SettingController::class, 'adminpasswordupdate'])->name('settings.adminpasswordupdate');


	Route::get('/admin/neworders', [App\Http\Controllers\Admin\OrderController::class, 'neworders'])->name('orders.neworders');
	Route::get('/admin/deliveredorders', [App\Http\Controllers\Admin\OrderController::class, 'deliveredorders'])->name('orders.delivered');
	Route::get('/admin/settledorders', [App\Http\Controllers\Admin\OrderController::class, 'settledorders'])->name('orders.settled');
	Route::get('/admin/cancelledorders', [App\Http\Controllers\Admin\OrderController::class, 'cancelledorders'])->name('orders.cancelled');
	Route::get('/admin/vieworder/{orderId}', [App\Http\Controllers\Admin\OrderController::class, 'vieworder'])->name('orders.view');
	Route::get('/admin/orders/approve/{orderid}/{transactionid}', [App\Http\Controllers\Admin\OrderController::class, 'approve'])->name('orders.approve');
	Route::post('/admin/stripesessioncreation/{orderId}', [App\Http\Controllers\Admin\OrderController::class, 'stripesessioncreation'])->name('orders.stripesessioncreation');
	Route::get('/admin/refundorder/{orderId}', [App\Http\Controllers\Admin\OrderController::class, 'refundorder'])->name('orders.refundorder');
	Route::get('/admin/refundedorders', [App\Http\Controllers\Admin\OrderController::class, 'refundedorders'])->name('orders.refundedorders');


	Route::get('/admin/promotion', [App\Http\Controllers\Admin\PromotionController::class, 'index'])->name('promotions.index');
	Route::get('/admin/addpromotion', [App\Http\Controllers\Admin\PromotionController::class, 'addpromotion'])->name('promotions.create');
	Route::post('/admin/storepromotion', [App\Http\Controllers\Admin\PromotionController::class, 'storepromotion'])->name('promotions.store');
	Route::get('/admin/editpromotion/{promotionId}', [App\Http\Controllers\Admin\PromotionController::class, 'editpromotion'])->name('promotions.edit');
	Route::post('/admin/updatepromotion/{promotionId}', [App\Http\Controllers\Admin\PromotionController::class, 'updatepromotion'])->name('promotions.update');
	Route::get('/admin/deletepromotion/{promotionId}', [App\Http\Controllers\Admin\PromotionController::class, 'deletepromotion'])->name('promotions.delete');
	Route::get('/admin/promotioncurrency', [App\Http\Controllers\Admin\PromotionController::class, 'promotioncurrency'])->name('promotions.currency');
	Route::post('/admin/updatepromotioncurrency', [App\Http\Controllers\Admin\PromotionController::class, 'updatepromotioncurrency'])->name('promotions.updatepromotioncurrency');
	
	Route::get('/admin/commission', [App\Http\Controllers\Admin\CommissionController::class, 'index'])->name('commissions.index');
	Route::get('/admin/addcommission', [App\Http\Controllers\Admin\CommissionController::class, 'addcommission'])->name('commissions.create');
	Route::post('/admin/storecommission', [App\Http\Controllers\Admin\CommissionController::class, 'storecommission'])->name('commissions.store');
	Route::get('/admin/editcommission/{commissionId}', [App\Http\Controllers\Admin\CommissionController::class, 'editcommission'])->name('commissions.edit');
	Route::post('/admin/updatecommission/{commissionId}', [App\Http\Controllers\Admin\CommissionController::class, 'updatecommission'])->name('commissions.update');
	Route::get('/admin/deletecommission/{commissionId}', [App\Http\Controllers\Admin\CommissionController::class, 'deletecommission'])->name('commissions.delete');
	
	});


//Front Web

Route::get('/switchlang/{locale}', 'App\Http\Controllers\LanguageController@switchlang')->name('language.switchlang');
	Route::group(['middleware'=>'setlocale'],function ()
	{
Route::get('/', [App\Http\Controllers\Site\MainController::class, 'index'])->name('main.index');
Route::get('/auth/login', [App\Http\Controllers\Auth\AuthController::class, 'index'])->name('auth.login');
Route::post('postlogin', [App\Http\Controllers\Auth\AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('/auth/register', [App\Http\Controllers\Auth\AuthController::class, 'registration'])->name('auth.register');
Route::post('registration', [App\Http\Controllers\Auth\AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('/auth/reset', [App\Http\Controllers\Auth\AuthController::class, 'reset'])->name('auth.reset');
Route::post('resetpassword', [App\Http\Controllers\Auth\AuthController::class, 'postReset'])->name('reset.post'); 
Route::get('/auth/verify/{userId}', [App\Http\Controllers\Auth\AuthController::class, 'verify'])->name('auth.verify');
Route::get('logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');

Route::get('/loadmoreitem', [App\Http\Controllers\Site\MainController::class, 'loadMoreitem']);
Route::get('/search/{catId}', [App\Http\Controllers\Site\MainController::class, 'search'])->name('search');
Route::post('/searchloadmoreitem', [App\Http\Controllers\Site\MainController::class, 'searchloadMoreitem']);
Route::post('/setcurrentlocation', [App\Http\Controllers\Site\MainController::class, 'setcurrentlocation']);

Route::get('/product/show/{itemId}', [App\Http\Controllers\Site\ProductController::class, 'show'])->name('product.show');
Route::get('/loadmorereview', [App\Http\Controllers\Site\ProductController::class, 'loadMoreReview']);
Route::get('/sell', [App\Http\Controllers\Site\ProductController::class, 'sell'])->name('product.sell');
Route::post('/startfileupload', [App\Http\Controllers\Site\ProductController::class, 'startfileupload']);
Route::post('/createproduct', [App\Http\Controllers\Site\ProductController::class, 'store'])->name('product.create'); 
Route::get('/editsell/{itemId}', [App\Http\Controllers\Site\ProductController::class, 'editsell'])->name('product.editsell');
Route::post('/editproduct', [App\Http\Controllers\Site\ProductController::class, 'editproduct'])->name('product.editproduct'); 
Route::post('/selectcategory', [App\Http\Controllers\Site\ProductController::class, 'selectcategory']);
Route::post('/selectsupercategory', [App\Http\Controllers\Site\ProductController::class, 'selectsupercategory']);
Route::post('/changeproductstatus', [App\Http\Controllers\Site\ProductController::class, 'changeproductstatus']);
Route::post('/deleteproduct', [App\Http\Controllers\Site\ProductController::class, 'deleteproduct']);
Route::post('/reviewrating', [App\Http\Controllers\Site\ProductController::class, 'reviewrating'])->name('product.reviewrating'); 



/*Route::get('/mylisting', [App\Http\Controllers\Site\UserController::class, 'mylisting'])->name('user.mylisting');
Route::get('/loadmoreitemlisting', [App\Http\Controllers\Site\UserController::class, 'loadMoreitemlisting']);
Route::get('/editprofile', [App\Http\Controllers\Site\UserController::class, 'editprofile'])->name('user.editprofile');
Route::post('/editdetail', [App\Http\Controllers\Site\UserController::class, 'editdetail'])->name('user.editdetail');
Route::post('/editdetailpassword', [App\Http\Controllers\Site\UserController::class, 'editdetailpassword'])->name('user.editdetailpassword');*/


Route::get('auth/social', [App\Http\Controllers\Auth\LoginController::class, 'show'])->name('social.login');
Route::get('oauth/{driver}', [App\Http\Controllers\Auth\LoginController::class, 'redirectToProvider'])->name('social.oauth');
Route::get('oauth/{driver}/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleProviderCallback'])->name('social.callback');

Route::get('chat/view/{chat_id?}', [App\Http\Controllers\Site\ChatController::class, 'show'])->name('site.chat.view');
Route::post('chat/createchat',[App\Http\Controllers\Site\ChatController::class, 'createchat'])->name('site.chat.createchat');
Route::post('chat/postmessage', [App\Http\Controllers\Site\ChatController::class, 'postmessage'])->name('site.chat.post');
Route::post('chat/userchat', [App\Http\Controllers\Site\ChatController::class, 'userchat'])->name('site.chat.userchat');
Route::post('chat/searchchatuser', [App\Http\Controllers\Site\ChatController::class, 'searchchatuser'])->name('site.chat.searchchatuser');

Route::get('profile/mylistings/{userId}', [App\Http\Controllers\Site\ProfileController::class, 'mylistings'])->name('site.profile.mylistings');
Route::get('profile/activepromotions', [App\Http\Controllers\Site\ProfileController::class, 'activepromotions'])->name('site.profile.activepromotions');
Route::get('profile/expirepromotions', [App\Http\Controllers\Site\ProfileController::class, 'expirepromotions'])->name('site.profile.expirepromotions');
Route::get('/profile/editprofile', [App\Http\Controllers\Site\ProfileController::class, 'editprofile'])->name('site.profile.editprofile');
Route::post('/profile/editdetail', [App\Http\Controllers\Site\ProfileController::class, 'editdetail'])->name('site.profile.editdetail');
Route::post('/profile/editdetailpassword', [App\Http\Controllers\Site\ProfileController::class, 'editdetailpassword'])->name('site.profile.editdetailpassword');
Route::get('profile/promotiondetails/{userId}/{itemId}/{page}', [App\Http\Controllers\Site\ProfileController::class, 'promotiondetails'])->name('site.profile.promotiondetails');
Route::get('profile/favourites', [App\Http\Controllers\Site\ProfileController::class, 'favourites'])->name('site.profile.favourites');
Route::get('profile/promotionreturn', [App\Http\Controllers\Site\ProfileController::class, 'promotionreturn'])->name('site.profile.promotionreturn');
Route::get('profile/myaddress', [App\Http\Controllers\Site\ProfileController::class, 'myaddress'])->name('site.profile.myaddress');
Route::post('profile/saveaddress', [App\Http\Controllers\Site\ProfileController::class, 'saveaddress'])->name('site.profile.saveaddress');
Route::get('profile/deleteaddress/{addressId}', [App\Http\Controllers\Site\ProfileController::class, 'deleteaddress'])->name('site.profile.deleteaddress');



Route::get('order/myorders', [App\Http\Controllers\Site\OrderController::class, 'myorders'])->name('site.order.myorders');
Route::get('order/mysales', [App\Http\Controllers\Site\OrderController::class, 'mysales'])->name('site.order.mysales');
Route::get('order/orderconfirm/{itemId}', [App\Http\Controllers\Site\OrderController::class, 'orderconfirm'])->name('site.order.orderconfirm');
Route::post('/order/orderpaycreation', [App\Http\Controllers\Site\OrderController::class, 'orderpaycreation'])->name('order.orderpaycreation');
Route::get('/order/orderpayment/{addressId}/{itemId}/{userId}/{transactionid}', [App\Http\Controllers\Site\OrderController::class, 'orderpayment'])->name('order.orderpayment');


Route::post('/promotion/stripepaycreation', [App\Http\Controllers\Site\ProductController::class, 'stripepaycreation'])->name('promotion.stripepaycreation');
Route::get('/promotion/promotionpayment/{promotionId}/{itemId}/{userId}/{transactionid}', [App\Http\Controllers\Site\ProductController::class, 'promotionpayment'])->name('promotion.promotionpayment');



});

Route::get('reset', [App\Http\Controllers\Auth\AuthController::class, 'reset'])->name('reset');
Route::get('/help/{helpId}', [App\Http\Controllers\HelpController::class, 'index'])->name('helps.front');
Route::get('/user/verify/{userId}', [App\Http\Controllers\HomeController::class, 'verifyemail'])->name('users.verify');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
