<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Product;
use App\Models\Currency;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Supercategory;
use App\Models\Location;
use App\Models\Productcondition;
use App\Models\Review;
use App\Models\Like;
use App\Models\Promotion;
use App\Models\Userpromotion;
use App\Models\Address;
use App\Classes\MyClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Session;
use Image;
use Hash;

class ProfileController extends Controller
{
    
    public function mylistings($userId , $page = 1)
    {

        $myClass = new MyClass();

        $loginuser = Auth::user();
        $loginuserId = Auth::id();


        if(isset($_GET['page'])) {
            $page = $_GET['page'];
        }

        if($page == 1) {
            $offset = 0;
            $limit = 5;
            $page = 1;
        } else {
            $pageVal = $page - 1;
            $offset = $pageVal * 5;
            $limit = 5;
        }

        $pageLeft = $page - 1;
        $pageRight = $page + 1;

        $userdetail = User::find($userId);

        $reviewdetail = Review::where('sellerId', new \MongoDB\BSON\ObjectID($userId))->orderBy('created_at', 'asc')->get()->toArray();

        $reviewratingtotal = 0;
        $reviewrating = 0;
        $reviewdetailcount = 0;
        if(!empty($reviewdetail)) {
            $reviewdetailcount = count($reviewdetail);    
           
            foreach($reviewdetail as $reviewdetailtotal) {
                $reviewrating += $reviewdetailtotal['rating']; 
            }
                
            $reviewratingtotal = $reviewrating / $reviewdetailcount;                
        }


        $userItems = Product::where("userId",$userId)->orderBy('postingDate', 'asc')->limit($limit)->offset($offset)->get()->toArray();

        $useritems = $myClass->get_items($userItems);

        $itemscount = Product::where("userId",$userId)->orderBy('postingDate', 'asc')->count();

        $promotiondetails = Promotion::get()->toArray();

        //echo "<pre>"; print_r($promotiondetails); die;
        
        return view('site.profile.mylistings' , ['useritems' => $useritems , 'itemscount' => $itemscount , 'userId' => $userId , 'page' => $page , 'pageLeft' => $pageLeft , 'pageRight' => $pageRight , 'userdetail' => $userdetail , 'view' => 'mylisting' , 'reviewdetailcount' => $reviewdetailcount , 'reviewratingtotal' => $reviewratingtotal , 'promotiondetails' => $promotiondetails , 'loginuserId' => $loginuserId]);

    }

    public function promotionreturn()
    {

        $myClass = new MyClass();

        $loginuser = Auth::user();
        $userId = Auth::id();

        $notification = array(
                    'message' => __('messages.Product added successfully'),
                    'alert-type' => 'success',
                );
           
        session()->put('notification', $notification);

        return redirect()->route('site.profile.mylistings' , $userId);

    }


    public function favourites($page = 1)
    {

        $myClass = new MyClass();

        $loginuser = Auth::user();
        $userId = Auth::id();


        if(isset($_GET['page'])) {
            $page = $_GET['page'];
        }

        if($page == 1) {
            $offset = 0;
            $limit = 5;
            $page = 1;
        } else {
            $pageVal = $page - 1;
            $offset = $pageVal * 5;
            $limit = 5;
        }

        $pageLeft = $page - 1;
        $pageRight = $page + 1;

        $userdetail = User::find($userId);

        $reviewdetail = Review::where('sellerId', new \MongoDB\BSON\ObjectID($userId))->orderBy('created_at', 'asc')->get()->toArray();

        $reviewratingtotal = 0;
        $reviewrating = 0;
        $reviewdetailcount = 0;
        if(!empty($reviewdetail)) {
            $reviewdetailcount = count($reviewdetail);    
           
            foreach($reviewdetail as $reviewdetailtotal) {
                $reviewrating += $reviewdetailtotal['rating']; 
            }
                
            $reviewratingtotal = $reviewrating / $reviewdetailcount;                
        }


        $likeItems = Like::where("userId",$userId)->orderBy('created_at', 'asc')->limit($limit)->offset($offset)->get()->toArray();

        $useritems = array();    
        foreach($likeItems as $key => $likeItems) {

            $productId = $likeItems['itemId'];

            $itemdetail = Product::where("_id",$productId)->orderBy('postingDate', 'asc')->first()->toArray();

              $useritems[$key]['itemid'] =  $itemdetail['_id'];
              $useritems[$key]['itemtitle'] =  $itemdetail['itemTitle'];
              $useritems[$key]['itemprice'] =  $itemdetail['price']; 
              $useritems[$key]['itemcurrency'] =  $myClass->get_itemcurrency($itemdetail['CurrencyID']);
              $useritems[$key]['itemdate'] =  $myClass->get_itemdate($itemdetail['createdAt']);
              $useritems[$key]['itemimage'] =  $myClass->get_itemimage($itemdetail['images']); 

        }

        $itemscount = Like::where("userId",$userId)->orderBy('created_at', 'asc')->count();

        //echo "<pre>"; print_r($promotiondetails); die;
        
        return view('site.profile.favourites' , ['useritems' => $useritems , 'itemscount' => $itemscount , 'userId' => $userId , 'page' => $page , 'pageLeft' => $pageLeft , 'pageRight' => $pageRight , 'userdetail' => $userdetail , 'view' => 'favourites' , 'reviewdetailcount' => $reviewdetailcount , 'reviewratingtotal' => $reviewratingtotal]);

    }


	public function editprofile() {

             if(!Auth::user())
             {
                return redirect()->route('main.index');
             }  

	    	$myClass = new MyClass();

		$loginuser = Auth::user();
		$userId = Auth::id();

        $userdetail = User::find($userId);


	    $reviewdetail = Review::where('sellerId', new \MongoDB\BSON\ObjectID($userId))->orderBy('created_at', 'asc')->get()->toArray();

        $reviewratingtotal = 0;
        $reviewrating = 0;
        $reviewdetailcount = 0;
        if(!empty($reviewdetail)) {
            $reviewdetailcount = count($reviewdetail);    
           
            foreach($reviewdetail as $reviewdetailtotal) {
                $reviewrating += $reviewdetailtotal['rating']; 
            }
                
            $reviewratingtotal = $reviewrating / $reviewdetailcount;                
        }

	//    print_r($userdetails);die;

	    return view('site.profile.editprofile', [ 'userdetail' => $userdetail, 'userId' => $userId, 'reviewratingtotal' => $reviewratingtotal, 'reviewdetailcount' => $reviewdetailcount, 'view' => 'editprofile']);

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editdetail(Request $request)
    {

            $this->validate(
                $request,
                [
                    'name' => 'required|min:3|max:30',
                    'email' => 'required|email',
                ],
                [
                    'name.required' => __('Please enter user name.'),
                    'name.min' => __('The name must be at least 3 characters.'),
                    'name.max' => __('The name may not be greater than 30 characters.'),
                    'email.required' => __('Please enter user E-mail.'),
                ]
            );

		$myClass = new MyClass();

		$loginuser = Auth::user();
		$userId = Auth::id();

            if($request->email != $request->hiddenemail) {
                $email = $request->email;
                $emailExist = User::where('email', $email)->first();
                if ($emailExist) {
                    $notification = array(
                        'message' => __('messages.Email Already exists'),
                        'alert-type' => 'error',
                    );
                    Session()->put('notification', $notification);
                    return redirect()->back();
                }

            }

            $userData = User::findOrFail($userId);
            $userData->name = $request->name;
            $userData->email = $request->email;


            if ($request->file('profilephoto')) {

                $image = $request->file('profilephoto');

                $filename = Str::random(6);
                $extension = $request->file('profilephoto')->getClientOriginalExtension();
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                $path = $request->file('profilephoto')->storeAs('public/users/original',$fileNameToStore);

               // $realpath = storage_path()."/app/public/users/original/".$fileNameToStore;
                $thumbnailFilePath = storage_path()."/app/public/users/thumb100/".$fileNameToStore;

                $img = Image::make($image->path());

                $img->resize(300, 300, function ($const) {
                    $const->aspectRatio();
                })->save($thumbnailFilePath);


                $userData->image = $fileNameToStore;
            }



            // ends here
            if ($userData->save()) {
                $notification = array(
                    'message' => __('messages.User Details has been updated successfully'),
                );
            } else {
                $notification = array(
                    'message' => __('messages.Something went wrong'),
                );
            }

            session()->put('notification', $notification);

            return redirect()->route('site.profile.editprofile');
    }

    public function editdetailpassword(Request $request)
    {

             $this->validate(
                $request,
                [
                    'password' => 'required|min:6|required_with:password_confirmation|same:password_confirmation',
                    'password_confirmation' => 'required|min:6'
                ],
                [
                    'password.required' => __('messages.Please enter the password.'),
                    'password.min' => __('messages.The name must be at least 6 characters.'),
                    'password_confirmation.required' => __('messages.Please enter the confirm password.')
                ]
            );

            $userId = Auth::user()->_id;


            $userData = User::findOrFail($userId);
            $userData->password = Hash::make($request->password);

            // ends here
            if ($userData->save()) {
                //Auth::logout();
                $notification = array(
                    'message' => __('messages.Password updated successfully. Please Login'),
                );

                session()->put('notification', $notification);

                 return redirect()->route('site.profile.editprofile');



            } else {
                $notification = array(
                    'message' => __('messages.Something went wrong'),
                );

                session()->put('notification', $notification);

                return redirect()->route('site.profile.editprofile');
            }
     }    
    

    public function activepromotions($page = 1)
    {

        if(!Auth::user()) {
            return redirect()->route('main.index');
        }  

        $myClass = new MyClass();

        $loginuser = Auth::user();
        $userId = Auth::id();


        if(isset($_GET['page'])) {
            $page = $_GET['page'];
        }

        if($page == 1) {
            $offset = 0;
            $limit = 5;
            $page = 1;
        } else {
            $pageVal = $page - 1;
            $offset = $pageVal * 5;
            $limit = 5;
        }

        $pageLeft = $page - 1;
        $pageRight = $page + 1;

        $userdetail = User::find($userId);

        $reviewdetail = Review::where('sellerId', new \MongoDB\BSON\ObjectID($userId))->orderBy('created_at', 'asc')->get()->toArray();

        $reviewratingtotal = 0;
        $reviewrating = 0;
        $reviewdetailcount = 0;
        if(!empty($reviewdetail)) {
            $reviewdetailcount = count($reviewdetail);    
           
            foreach($reviewdetail as $reviewdetailtotal) {
                $reviewrating += $reviewdetailtotal['rating']; 
            }
                
            $reviewratingtotal = $reviewrating / $reviewdetailcount;                
        }

        $today = Carbon::now()->timestamp;

        $utc_todaytime = new \MongoDB\BSON\UTCDateTime($today);

        $userItems = Product::where("userId",$userId)->where("featured",1)->where('featureexpireOn', '>=', $utc_todaytime)->orderBy('featureactiveOn', 'asc')->limit($limit)->offset($offset)->get()->toArray();

        //echo "<pre>"; print_r($userItems); die;

        $useritems = $myClass->get_items($userItems);

        $itemscount = Product::where("userId",$userId)->where("featured",1)->where('featureexpireOn', '>=', $utc_todaytime)->orderBy('featureactiveOn', 'asc')->count();

        //$promotiondetails = Promotion::get()->toArray();

        //echo "<pre>"; print_r($promotiondetails); die;
        
        return view('site.profile.activepromotions' , ['useritems' => $useritems , 'itemscount' => $itemscount , 'userId' => $userId , 'page' => $page , 'pageLeft' => $pageLeft , 'pageRight' => $pageRight , 'userdetail' => $userdetail , 'view' => 'activepromotion' , 'reviewdetailcount' => $reviewdetailcount , 'reviewratingtotal' => $reviewratingtotal]);

    }


    public function expirepromotions($page = 1)
    {
        if(!Auth::user()) {
            return redirect()->route('main.index');
        } 

        $myClass = new MyClass();

        $loginuser = Auth::user();
        $userId = Auth::id();


        if(isset($_GET['page'])) {
            $page = $_GET['page'];
        }

        if($page == 1) {
            $offset = 0;
            $limit = 5;
            $page = 1;
        } else {
            $pageVal = $page - 1;
            $offset = $pageVal * 5;
            $limit = 5;
        }

        $pageLeft = $page - 1;
        $pageRight = $page + 1;

        $userdetail = User::find($userId);

        $reviewdetail = Review::where('sellerId', new \MongoDB\BSON\ObjectID($userId))->orderBy('created_at', 'asc')->get()->toArray();

        $reviewratingtotal = 0;
        $reviewrating = 0;
        $reviewdetailcount = 0;
        if(!empty($reviewdetail)) {
            $reviewdetailcount = count($reviewdetail);    
           
            foreach($reviewdetail as $reviewdetailtotal) {
                $reviewrating += $reviewdetailtotal['rating']; 
            }
                
            $reviewratingtotal = $reviewrating / $reviewdetailcount;                
        }

        $today = Carbon::now()->timestamp;

        $utc_todaytime = new \MongoDB\BSON\UTCDateTime($today);

        $userItems = Product::where("userId",$userId)->where("featured",1)->where('featureexpireOn', '<', $utc_todaytime)->orderBy('featureactiveOn', 'asc')->limit($limit)->offset($offset)->get()->toArray();

        //echo "<pre>"; print_r($userItems); die;

        $useritems = $myClass->get_items($userItems);

        $itemscount = Product::where("userId",$userId)->where("featured",1)->where('featureexpireOn', '<', $utc_todaytime)->orderBy('featureactiveOn', 'asc')->count();

        //$promotiondetails = Promotion::get()->toArray();

        //echo "<pre>"; print_r($promotiondetails); die;
        
        return view('site.profile.expirepromotions' , ['useritems' => $useritems , 'itemscount' => $itemscount , 'userId' => $userId , 'page' => $page , 'pageLeft' => $pageLeft , 'pageRight' => $pageRight , 'userdetail' => $userdetail , 'view' => 'activepromotion' , 'reviewdetailcount' => $reviewdetailcount , 'reviewratingtotal' => $reviewratingtotal]);

    }


    public function promotiondetails($userId , $itemId , $page)
    {

        if(!Auth::user()) {
            return redirect()->route('main.index');
        }  

        $myClass = new MyClass();

        $loginuser = Auth::user();
        $userId = Auth::id();

        $userdetail = User::find($userId);

        $reviewdetail = Review::where('sellerId', new \MongoDB\BSON\ObjectID($userId))->orderBy('created_at', 'asc')->get()->toArray();

        $reviewratingtotal = 0;
        $reviewrating = 0;
        $reviewdetailcount = 0;
        if(!empty($reviewdetail)) {
            $reviewdetailcount = count($reviewdetail);    
           
            foreach($reviewdetail as $reviewdetailtotal) {
                $reviewrating += $reviewdetailtotal['rating']; 
            }
                
            $reviewratingtotal = $reviewrating / $reviewdetailcount;                
        }


        $userpromotion = Userpromotion::where("userId",$userId)->where("itemId",$itemId)->first()->toArray();

        $itemId = $userpromotion['itemId'];

        $productdetail = Product::find($itemId);

        $promotiondetail = Promotion::findOrFail($userpromotion['promotionId']);

        
        return view('site.profile.promotiondetails' , ['userpromotion' => $userpromotion , 'userId' => $userId , 'promotiondetail' => $promotiondetail , 'userdetail' => $userdetail , 'view' => 'promotiondetail' , 'reviewdetailcount' => $reviewdetailcount , 'reviewratingtotal' => $reviewratingtotal , 'productdetail' => $productdetail , 'page' => $page]);

    }


    public function myaddress()
    {
        if(!Auth::user()) {
            return redirect()->route('main.index');
        } 

        $myClass = new MyClass();

        $loginuser = Auth::user();
        $userId = Auth::id();

        $userdetail = User::find($userId);

        $reviewdetail = Review::where('sellerId', new \MongoDB\BSON\ObjectID($userId))->orderBy('created_at', 'asc')->get()->toArray();

        $reviewratingtotal = 0;
        $reviewrating = 0;
        $reviewdetailcount = 0;
        if(!empty($reviewdetail)) {
            $reviewdetailcount = count($reviewdetail);    
           
            foreach($reviewdetail as $reviewdetailtotal) {
                $reviewrating += $reviewdetailtotal['rating']; 
            }
                
            $reviewratingtotal = $reviewrating / $reviewdetailcount;                
        }


        $userAddress = Address::where("userId",$userId)->orderBy('addressDate', 'desc')->get()->toArray();

        //echo "<pre>"; print_r($userAddress); die;

        
        return view('site.profile.myaddress' , ['userAddress' => $userAddress , 'userId' => $userId , 'userdetail' => $userdetail , 'view' => 'myaddress' , 'reviewdetailcount' => $reviewdetailcount , 'reviewratingtotal' => $reviewratingtotal]);

    }

    public function saveaddress(Request $request)
    {
        if(!Auth::user()) {
            return redirect()->route('main.index');
        } 

        $myClass = new MyClass();

        $loginuser = Auth::user();
        $userId = Auth::id();

        $userdetail = User::find($userId);

        $today = Carbon::now()->timestamp;
        $utc_todaytime = new \MongoDB\BSON\UTCDateTime($today);

        if(isset($request['addressId']) && !empty($request['addressId'])) {

            $addressedit = Address::where('_id', new \MongoDB\BSON\ObjectID($request['addressId']))->first();

            $addressedit->update([
                    'name' => $request['name'],
                    'addressOne' => $request['address1'],
                    'addressTwo' => $request['address2'],
                    'country' => $request['country'],
                    'userId' => Auth::user()->_id,
                    'pincode' => $request['zipcode'],
                    'phone' => $request['phone']
                ]);



        } else {

            $address = Address::create([
                    'name' => $request['name'],
                    'addressOne' => $request['address1'],
                    'addressTwo' => $request['address2'],
                    'country' => $request['country'],
                    'userId' => Auth::user()->_id,
                    'pincode' => $request['zipcode'],
                    'phone' => $request['phone'],
                    'addressDate' => $utc_todaytime
                ]);

            

        }

        $notification = array(
                    'message' => trans('Address has been saved successfully'),
                    'alert-type' => 'success',
                );

        session()->put('notification', $notification);

        return redirect()->back();
            

    }

    public function deleteaddress($addressId) {

        $remove = Address::find($addressId);
        $remove->delete();

        $notification = array(
                    'message' => trans('Address has been deleted successfully'),
                    'alert-type' => 'success',
                );

        session()->put('notification', $notification);

        return redirect()->back();
    }
    
    

    
}
