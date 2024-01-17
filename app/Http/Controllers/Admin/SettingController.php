<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;
use App\Models\Admin;
use Illuminate\Support\Str;
use File;
use Hash;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{

	public function logosettings(Request $request) 
	{
		return view('admin.settings.logosetting');


	}
	
	
	public function logoupdate(Request $request)
	{	
		$this->validate(
			$request,
			[
				'site_logo' => 'image|mimes:jpeg,png,jpg',
				'site_dark' => 'image|mimes:jpeg,png,jpg',
				'site_icon' => 'image|mimes:png,ico',
				
			],
			[
				'site_logo.required' => __('The Site Logo field is required'),
				'site_logo.image' => __('The uploaded Site Logo is not an image'),
				'site_logo.mimes' => __('The Site Logo should be in jpeg, png or jpg format'),
				'site_dark.required' => __('The Site Dark Logo field is required'),
				'site_dark.image' => __('The uploaded Site Dark Logo is not an image'),
				'site_dark.mimes' => __('The Site Dark Logo should be in jpeg, png or jpg format'),
				'site_icon.required' => __('The Site Icon field is required'),
				'site_icon.image' => __('The uploaded Site Icon is not an image'),
				'site_icon.mimes' => __('The Site Icon should be in png or ico format'),
			]
		);
		
		
		if ($request->file('site_logo')) {
			$file_path = storage_path()."/app/public/admin_assets/logo.png";
			$this->unlink($file_path); 
			$fileNameToStore = 'logo.png';
			$path = $request->file('site_logo')->storeAs('/public/admin_assets/',$fileNameToStore);
		}
		if ($request->file('site_dark')) {
			$file_path = storage_path()."/app/public/admin_assets/dark.png";
			$this->unlink($file_path); 
			$fileNameToStore = 'dark.png';
			$path = $request->file('site_dark')->storeAs('/public/admin_assets/',$fileNameToStore);
		}
		if ($request->file('site_icon')) {
			$file_path = storage_path()."/app/public/admin_assets/fav-icon";
			$this->unlink($file_path); 
			$fileNameToStore = 'fav-icon';
			$path = $request->file('site_icon')->storeAs('/public/admin_assets/',$fileNameToStore);
		}
		
			$notification = array(
				'message' => trans('Logo Settings has been saved successfully'),
				'alert-type' => 'success',
			);
		
		session()->put('notification', $notification);
		return redirect()->route('settings.logo');
	}

	public function defaultsetting(Request $request) 
	{
		$settings = Setting::first();

		return view('admin.settings.defaultsetting', ['settings' => $settings]);


	}


	public function defaultsettingsupdate(Request $request)
	{	
		$regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

		$this->validate(
			$request,
			[
				'site_name' => 'required|regex:/^[\pL\s\-]+$/u|min:3|max:30',
				'site_desc' => 'required',
				'contact_email' => 'required|email',
				'copyright' => 'required',
				'playstore' => 'required',
				'appstore' => 'required',
				'facebook' => 'required|regex:'.$regex,
				'twitter' => 'required|regex:'.$regex,
				'linkedin' => 'required|regex:'.$regex,

			],
			[
				'site_name.required' => __('The site name field is required.'),
				'site_name.regex' => __('The site name may only contain letters, hyphens and spaces.'),
				'site_name.min' => __('The site name must be at least 3 characters.'),
				'site_name.max' => __('The site name may not be greater than 30 characters.'),
				'contact_email.required' => __('The contact mail field is required.'),
				'contact_email.email' => __('The contact email must be a valid email address.'),
				'copyright_text.required' => __('The copyright text field is required.'),
				'site_desc.required' => __('The Description field is required.'),
				'playstore.required' => __('The Playstore Link field is required'),
				'appstore.required' => __('The Appstore Link field is required'),
				'facebook.required' => __('The Facebook Link field is required'),
				'facebook.regex' => __('Enter the valid url for Facebook Link'),
				'twitter.required' => __('The Twitter Link field is required'),
				'twitter.regex' => __('Enter the valid url for Twitter Link'),
				'linkedin.required' => __('The Linkedin Link field is required'),
				'linkedin.regex' => __('Enter the valid url for Linkedin Link'),
			]
		);
		
		$settings = Setting::orderBy('_id', 'desc')->first();
		//            $settings = new Setting();

		$settings->siteName = $request->site_name;
		$settings->siteDesc = $request->site_desc;
		$settings->contactEmail = $request->contact_email;
		$settings->copyrightText = $request->copyright;
		$settings->playstoreLink = $request->playstore;
		$settings->appstoreLink = $request->appstore;
		$settings->facebookURL = $request->facebook;
		$settings->twitterURL = $request->twitter;
		$settings->linkedinURL = $request->linkedin;
		
		if ($settings->save()) {
			$notification = array(
				'message' => trans('Settings has been saved successfully'),
				'alert-type' => 'success',
			);
		} else {
			$notification = array(
				'message' => trans('Something went wrong'),
				'alert-type' => 'error',
			);
		}
		session()->put('notification', $notification);
		return redirect()->route('settings.default');
	}

	public function smtpsetting(Request $request) 
	{
		$settings = Setting::first();

		return view('admin.settings.smtpsetting', ['settings' => $settings]);


	}

	public function smtpsettingsupdate(Request $request)
	{	
		$this->validate(
			$request,
			[
				'port' => 'required',
				'host' => 'required',
				'email' => 'required|email',
				'password' => 'required',
			],
			[
				'port.required' => __('Port is required.'),
				'host.required' => __('Host is required.'),
				'email.required' => __('Please enter user E-mail.'),
				'email.email' => __('Please enter valid email address.'),
				'password.required' => __('Password is required.'),
			]
		);
		
		$settings = Setting::orderBy('_id', 'desc')->first();
		//            $settings = new Setting();

		$settings->port = $request->port;
		$settings->host = $request->host;
		$settings->email = $request->email;
		$settings->password = $request->password;
		
		
		
		if ($settings->save()) {
			$notification = array(
				'message' => trans('Settings has been saved successfully'),
				'alert-type' => 'success',
			);
		} else {
			$notification = array(
				'message' => trans('Something went wrong'),
				'alert-type' => 'error',
			);
		}
		session()->put('notification', $notification);
		return redirect()->route('settings.smtp');
	}

	public function stripesetting(Request $request) 
	{
		$settings = Setting::first();

		return view('admin.settings.stripesetting', ['settings' => $settings]);

	}


	public function stripesettingsupdate(Request $request)
	{	
		$this->validate(
			$request,
			[
				'publickey' => 'required',
				'privatekey' => 'required',
			],
			[
				'publickey.required' => __('Public Key is required.'),
				'privatekey.required' => __('Private Key is required.'),
			]
		);
		
		$settings = Setting::orderBy('_id', 'desc')->first();
		//            $settings = new Setting();

		$settings->stripeType = $request->stripetype;
		$settings->publickey = $request->publickey;
		$settings->privatekey = $request->privatekey;		
		
		
		if ($settings->save()) {
			$notification = array(
				'message' => trans('Stripe Settings has been saved successfully'),
				'alert-type' => 'success',
			);
		} else {
			$notification = array(
				'message' => trans('Something went wrong'),
				'alert-type' => 'error',
			);
		}
		session()->put('notification', $notification);
		return redirect()->route('settings.stripe');
	}


	public function notificationsetting(Request $request) 
	{
		$settings = Setting::first();

		return view('admin.settings.notificationsetting', ['settings' => $settings]);

	}


	public function notificationsettingsupdate(Request $request)
	{	
		$this->validate(
			$request,
			[
				'notificationkey' => 'required'
			],
			[
				'notificationkey.required' => __('Public Key is required.')
			]
		);
		
		$settings = Setting::orderBy('_id', 'desc')->first();
		//            $settings = new Setting();

		$settings->notificationkey = $request->notificationkey;
		
		if ($settings->save()) {
			$notification = array(
				'message' => trans('Push Notification Settings has been saved successfully'),
				'alert-type' => 'success',
			);
		} else {
			$notification = array(
				'message' => trans('Something went wrong'),
				'alert-type' => 'error',
			);
		}
		session()->put('notification', $notification);
		return redirect()->route('settings.notification');
	}


	public function editadminsettings(Request $request) 
	{
		$settings = Admin::first();

		return view('admin.settings.editadminsettings', ['settings' => $settings]);


	}


	public function adminsettingsupdate(Request $request)
	{	
		$this->validate(
			$request,
			[
				'name' => 'required',
				'email' => 'required|email',
			],
			[
				'name.required' => __('The Name field is required.'),
				'email.required' => __('The Email field is required.'),
				'email.email' => __('The email address must be a valid email address.'),
			]
		);
		
		$settings = Admin::orderBy('_id', 'desc')->first();
		//            $settings = new Setting();

		$settings->name = $request->name;
		$settings->email = $request->email;
		//$settings->password = Hash::make($request->get('password'));
		
		if ($settings->save()) {
			$notification = array(
				'message' => trans('Settings has been saved successfully'),
				'alert-type' => 'success',
			);
		} else {
			$notification = array(
				'message' => trans('Something went wrong'),
				'alert-type' => 'error',
			);
		}
		session()->put('notification', $notification);
		return redirect()->route('settings.editadmin');
	}


	public function editadminpassword(Request $request) 
	{

		return view('admin.settings.editadminpassword');


	}

	public function adminpasswordupdate(Request $request)
	{	
		$this->validate($request, [
			'admin_old_password' => 'required',
			'admin_new_password' => 'required|min:6|max:255|different:admin_old_password',
			'admin_confirm_password' => 'required|same:admin_new_password',
		],
		[
			'admin_old_password.required' => trans('Enter your old password'),
			'admin_new_password.required' => trans('Enter your new password'),
			'admin_new_password.min' => trans('Password length should be min 6 character'),
			'admin_new_password.different' => trans('Your new password should not be same as old password'),
			'admin_confirm_password.required' => trans('Re-enter your confirm password'),
			'admin_confirm_password.same' => trans('Confirm password is wrong'),
		]);
		
		$adminrecords = Admin::orderBy('_id', 'desc')->first();
		//            $settings = new Setting();
//echo $adminrecords->password; echo '-'; echo Hash::check($request->get('admin_old_password')); die;
		if (!Hash::check($request->get('admin_old_password'), $adminrecords->password)) {
			$notification = array(
				'message' => trans('Old password is incorrect'),
				'alert-type' => 'error',
			);
			session()->put('notification', $notification);
			return redirect()->back();
		}

		$adminrecords->password = Hash::make($request->get('admin_new_password'));
		$adminrecords->save();
		$notification = array(
			'message' => trans('Password saved successfully'),
			'alert-type' => 'success',
		);
		session()->put('notification', $notification);
		return redirect()->route('settings.editpassword');
	}

	public function unlink($file_path)
	{	
		if(file_exists($file_path)){
			unlink($file_path);
		}
	}
}
