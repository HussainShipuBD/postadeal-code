<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Product;
use App\Models\Currency;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Supercategory;
use App\Models\Location;
use App\Models\Productcondition;
use App\Models\Review;
use App\Models\Setting;
use App\Models\Promotion;
use App\Models\Userpromotion;
use App\Classes\MyClass;
use Carbon\Carbon;
use File;
use Image;

class ProductController extends Controller
{


     public function startfileupload(Request $request)
      {

          /*$request->validate([
              'images' => 'required'
          ]);*/
          $files = [];
          $images = '';
          $tot_cnt = count($request->images);
          $cnt = 0;

          if (!empty($request->images)) {
              foreach($request->images as $key=>$file)
              {
                $filename = Str::random(6);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                $path = $file->storeAs('public/products/tmp',$fileNameToStore);
                $files[] = $fileNameToStore;  

                $images.= '<div class="upld_imgdiv" id="new-uploadimage">
                                                            <img src="'.url("/storage/app/public/products/tmp").'/'.$fileNameToStore.'" />
                                                        </div>';
              }

          $files = json_encode($files);
          // Store $document document in DATABASE from HERE 

         $result['uploadedfiles'] = $files;
         $result['viewimage'] = $images;             
         $result['countimage'] = $tot_cnt;             


          } else 
          {
         $result['uploadedfiles'] = "";
         $result['viewimage'] = "";             
         $result['countimage'] = $tot_cnt;             
          }
            return $result;

         
      }


    
   public function sell()
    {
              if(!Auth::user())
             {
                return redirect()->route('main.index');
             }  

        $categories = Category::orderBy('created_at', 'asc')->get()->toArray();

        $currencydetail = Currency::orderBy('created_at', 'asc')->get()->toArray();

        $productconditiondetail = Productcondition::orderBy('created_at', 'asc')->get()->toArray();

         return view('product.sell', [ 'get_maincategory' => $categories, 'currencydetails' => $currencydetail, 'productconditiondetails' => $productconditiondetail ]);
        //
    }



      public function selectcategory(Request $request)
    {
        $myClass = new MyClass();
        $catid = $request['catid'];

        $sub_category = $myClass->get_subcategory($catid);

        $catlist = '';
        if(!empty($sub_category))
        {    
        foreach($sub_category as $key => $subcategory)
         {
            $catlist.='<option id="subcatvalue" value="'.$subcategory['_id'].'">'.$subcategory['name'].'</option>'; 
        }
         } else {
            $catlist ='0';
         }                                       
         return $catlist;
     }   



      public function selectsupercategory(Request $request)
    {
        $myClass = new MyClass();
        $maincat = $request['maincat'];
        $subcat = $request['subcat'];

        $super_category = $myClass->get_supercategory($maincat, $subcat);

        $superlist = '';
        if(!empty($super_category))
        {    
        foreach($super_category as $key => $supercategory)
         {
            $superlist.='<option id="supercatvalue" value="'.$supercategory['_id'].'">'.$supercategory['name'].'</option>'; 
        }
         } else {
            $superlist ='0';
         }                                       
         return $superlist;
     }   


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $loginuser = Auth::user();
        $userId = Auth::id();

        $this->validate(
                $request,
                [
                    'uploadedfiles' => 'required',
                    'products_name' => 'required',
                    'products_maincat' => 'required',
                    'products_description' => 'required',
                    'products_price' => 'required',
                    'products_currency' => 'required',
                    'products_condition' => 'required',
                   'products_location' => 'required'
                ],
                [
                    'uploadedfiles.required' => __('messages.Product Image has been required.'),
                    'products_name.required' => __('messages.Please enter the product name.'),
                    'products_maincat.required' => __('messages.Please select the product main category.'),
                    'products_description.required' => __('messages.Please enter the product description.'),
                    'products_price.required' => __('messages.Please enter the product price.'),
                    'products_currency.required' => __('messages.Please select the product Currency.'),
                    'products_condition.required' => __('messages.Please select the product condition.'),
                    'products_location.required' => __('messages.Please select the product location.')
                ]
            );


        $uploadedFiles =  $request['uploadedfiles'];
        $images = json_decode($uploadedFiles, TRUE);   
        foreach($images as $key => $image)
        {
        $realpath = storage_path()."/app/public/products/tmp/".$image;
        $newpath = storage_path()."/app/public/products/original/".$image;

 
       $thumbnailFilePath = storage_path()."/app/public/products/thumb300/".$image;

        $img = Image::make($realpath);

        $img->resize(300, 300, function ($const) {
            $const->aspectRatio();
        })->save($thumbnailFilePath);

         if (!file_exists($thumbnailFilePath)) {
            mkdir($thumbnailFilePath, 777, true);
        }

        if (File::move($realpath, $newpath)) {
         if (!file_exists($newpath)) {
            mkdir($newpath, 777, true);
        }
     }
        }    

         $location[] = $request['products_lon'];
         $location[] = $request['products_lat'];

         $loc['type'] = "Point";
         $loc['coordinates'] = $location;
         $locationfull = json_encode($loc, JSON_NUMERIC_CHECK);

         $locationfull = json_decode($locationfull);


         $product = Product::create([
                'itemTitle' => $request['products_name'],
                'itemDesc' => $request['products_description'],
                'images' => $request['uploadedfiles'],
                'price' => $request['products_price'],
                'userId' => Auth::user()->_id,
                'CurrencyID' => $request['products_currency'],
                'productCondition' => $request['products_condition'],
                'mainCategory' => $request['products_maincat'],
                'subCategory' => $request['products_subcat'],
                'superCategory' => $request['products_supercat'],
                'latitude' => $request['products_lat'],
                'longitude' => $request['products_lon'],
                'locationName' => $request['products_location'],
                'itemType' => "Sale",
                'buynow' => "true",
                'productAvailability' => "available",
                'featureDuration' => 0,
                'featured' => 0,
                'status' => 1,
                'loc' => json_encode($location),
                'location' => $locationfull
            ]);

            $productId = $product->_id;

            $notification = array(
                    'productId' => $productId,
                    'product-type' => 'success',
                );
           
            session()->put('notification', $notification);

            return redirect()->route('site.profile.mylistings' , $userId);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($itemId)
    {
       // echo $id;die();
            $myClass = new MyClass();

            $loginuser = Auth::user();
            $loginuserId = Auth::id();

            $itemdetails = Product::find($itemId);
            $currencyId = $itemdetails['CurrencyID'];
            $locationId = $itemdetails['locationID'];
            $mainCategory = $itemdetails['mainCategory'];
            $subCategory = $itemdetails['subCategory'];
            $superCategory = $itemdetails['superCategory'];
            $productCondition = $itemdetails['productCondition'];
            $userId = $itemdetails['userId'];


            $reviewratingtotal = 0;
            $reviewrating = 0;
            $reviewdetailcount = 0;
            $currencydetail = Currency::find($currencyId);
            $locationdetail = Location::find($locationId);
            $userdetail = User::find($userId);
            $categorydetail = Category::find($mainCategory);
            $subcategorydetail = Subcategory::find($subCategory);
            $supercategorydetail = Supercategory::find($superCategory);
            $conditiondetail = Productcondition::find($productCondition);

            $reviewdetail = Review::where('sellerId', new \MongoDB\BSON\ObjectID($userId))->orderBy('created_at', 'asc')->get()->toArray();
           $reviewdetailview = Review::where('sellerId', new \MongoDB\BSON\ObjectID($userId))->orderBy('created_at', 'asc')->paginate(1);


                if(!empty($reviewdetail))
                {
                $reviewdetailcount = count($reviewdetail);    
                foreach($reviewdetail as $reviewdetailtotal)
                 {
                  $reviewrating += $reviewdetailtotal['rating']; 
                 }
                $reviewratingtotal = $reviewrating / $reviewdetailcount;        
                }

            $selleritem = Product::where("status", 1)->where('userId', $userId)->skip(0)->take(5)->orderBy('createdAt', 'desc')->get()->toArray();

//            print_r($selleritem);die;

            $selleritems = $myClass->get_items($selleritem);


            return view('product.view', ['itemdetails' => $itemdetails, 'currencydetail' => $currencydetail, 'locationdetail' => $locationdetail, 'userdetail' => $userdetail, 'categorydetail' => $categorydetail, 'subcategorydetail' => $subcategorydetail, 'supercategorydetail' => $supercategorydetail, 'conditiondetail' => $conditiondetail, 'reviewdetails' => $reviewdetailview, 'reviewratingtotal' => $reviewratingtotal, 'reviewdetailcount' => $reviewdetailcount, 'selleritemdetails' => $selleritems, 'sellerid' => $userId , 'loginuserId' => $loginuserId]);

    }

 

        public function loadMoreReview(Request $request)
    {
        $myClass = new MyClass();
        $userId = $request['reviewsellerid'];

         $reviewdetails = Review::where('sellerId', new \MongoDB\BSON\ObjectID($userId))->orderBy('created_at', 'asc')->paginate(1);
         $review = '';
           if ($request->ajax()) {
             foreach ($reviewdetails as $reviewdetail) {

                    $reviewuserdetail = $myClass->get_userdetails($reviewdetail['userId']);
                   $review.='<div class="mbp_first media profile-img">';
                                    if(!empty($reviewuserdetail['image']) && isset(($reviewuserdetail['image']))) {
                                         $imageurl = url('/storage/app/public/users/thumb100/'.$reviewuserdetail['image']);
                                         $imagename = $reviewuserdetail['image']; 
                                    } else {
                                          $imageurl = url('/storage/app/public/users/thumb100/default.png');
                                         $imagename = 'default.png'; 
                                    }
                            $review.= '<img src="'.$imageurl.'" class="mr-3" alt="'.$imagename.'">
                                    <div class="media-body">
                                       <h4 class="sub_title mt-0">
                                          '.$reviewuserdetail[0]['name'].'
                                          <div class="sspd_review dif">
                                             <ul class="ml10">';
                                                      $averageRating = $reviewdetail['rating'];
                                                     for ($i = 1; $i <= 5; $i++) {
                                                         if ($i <= $averageRating) {
                                                            $review.= '<li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>';
                                                         } else {
                                                            $review.= '<li class="list-inline-item"><a href="#"><span><i class="fa fa-star"></i></span></a></li>';
                                                         }
                                                     }
                                             $review.= '</ul>
                                          </div>
                                       </h4>
                                       <a class="sspd_postdate fz14">'.$myClass->get_itemdate($reviewdetail['createdAt']->toDateTime()->format('Y-m-d H:i:s')).'</a>';
                                       $review.= '<p class="mt10">'.$reviewdetail['message'].'</p>
                                    </div>
                                 </div>
                                 <div class="custom_hr"></div>';
                             }

                            return $review;
           }
           return view('product.show');
    }   



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editsell(Request $request)
    {

        if(!Auth::user())
             {
                return redirect()->route('main.index');
             }  

        $itemId = $request['itemId'];    

        $itemdetail = Product::where("status", 1)->where("_id", new \MongoDB\BSON\ObjectID($itemId))->get()->toArray();

        $categories = Category::orderBy('created_at', 'asc')->get()->toArray();

        $currencydetail = Currency::orderBy('created_at', 'asc')->get()->toArray();

        $productconditiondetail = Productcondition::orderBy('created_at', 'asc')->get()->toArray();


//    print_r($itemdetail);die;

    return view('product.editsell', ['itemdetails' => $itemdetail, 'get_maincategory' => $categories, 'currencydetails' => $currencydetail, 'productconditiondetails' => $productconditiondetail ]);

    }

   
 /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function editproduct(Request $request)
    {
        $this->validate(
                $request,
                [
                    'uploadedfiles' => 'required',
                    'products_name' => 'required',
                    'products_maincat' => 'required',
                    'products_description' => 'required',
                    'products_price' => 'required',
                    'products_currency' => 'required',
                    'products_condition' => 'required',
                   'products_location' => 'required'
                ],
                [
                    'uploadedfiles.required' => __('messages.Product Image has been required.'),
                    'products_name.required' => __('messages.Please enter the product name.'),
                    'products_maincat.required' => __('messages.Please select the product main category.'),
                    'products_description.required' => __('messages.Please enter the product description.'),
                    'products_price.required' => __('messages.Please enter the product price.'),
                    'products_currency.required' => __('messages.Please select the product Currency.'),
                    'products_condition.required' => __('messages.Please select the product condition.'),
                    'products_location.required' => __('messages.Please select the product location.')
                ]
            );


        $productId = $request['itemId'];



        $uploadedFiles =  $request['uploadedfiles'];
        $images = json_decode($uploadedFiles, TRUE);


        foreach($images as $key => $image)
        {
        $realpath = storage_path()."/app/public/products/tmp/".$image;

        if(file_exists($realpath))
        {    

        $newpath = storage_path()."/app/public/products/original/".$image;

 
       $thumbnailFilePath = storage_path()."/app/public/products/thumb300/".$image;

        $img = Image::make($realpath);

        $img->resize(300, 300, function ($const) {
            $const->aspectRatio();
        })->save($thumbnailFilePath);

         if (!file_exists($thumbnailFilePath)) {
            mkdir($thumbnailFilePath, 777, true);
        }

        if (File::move($realpath, $newpath)) {
         if (!file_exists($newpath)) {
            mkdir($newpath, 777, true);
        }
        }
        }
        }    

         $location[] = $request['products_lon'];
         $location[] = $request['products_lat'];

         $loc['type'] = "Point";
         $loc['coordinates'] = $location;
         $locationfull = json_encode($loc, JSON_NUMERIC_CHECK);

         $locationfull = json_decode($locationfull);

         $productedit = Product::where('_id', new \MongoDB\BSON\ObjectID($productId))->first();

         $productedit->update([
                'itemTitle' => $request['products_name'],
                'itemDesc' => $request['products_description'],
                'images' => $request['uploadedfiles'],
                'price' => $request['products_price'],
                'userId' => Auth::user()->_id,
                'CurrencyID' => $request['products_currency'],
                'productCondition' => $request['products_condition'],
                'mainCategory' => $request['products_maincat'],
                'subCategory' => $request['products_subcat'],
                'superCategory' => $request['products_supercat'],
                'latitude' => $request['products_lat'],
                'longitude' => $request['products_lon'],
                'locationName' => $request['products_location'],
                'itemType' => "Sale",
                'buynow' => "true",
                'productAvailability' => "available",
                'featureDuration' => 0,
                'featured' => 0,
                'status' => 1,
                'loc' => json_encode($location),
                'location' => $locationfull
            ]);

        $notification = array(
                    'message' => __('messages.Product updated successfully'),
                    'alert-type' => 'success',
                );
           
            session()->put('notification', $notification);

            return redirect()->route('main.index');

    }
    
    
    public function stripepaycreation() {  

        $amount = $_POST['amount'] * 100;
        $currency = $_POST['currency'];
        $promotionId = $_POST['promotionId'];
        $itemId = $_POST['itemId'];
        $userId = $_POST['userId'];

        $response_url =  "https://devapp.mindleef.com/bigdil/promotion/promotionpayment/".$promotionId."/".$itemId.'/'.$userId;
        $url = 'https://api.stripe.com/v1/checkout/sessions';
        $data = array(
            'mode'=>"payment",
            'success_url' => $response_url."/{CHECKOUT_SESSION_ID}",
            'cancel_url' => $response_url."/{CHECKOUT_SESSION_ID}",
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                'currency' => trim($currency),
                'unit_amount' => $amount,
                'product_data' => [
                    'name' => 'Product Promotion',
                ],
                ],
                'quantity' => 1,
            ]],
            'metadata'=>[
                "promotionId" => $promotionId,
                "itemId" => $itemId,
                "userId" => $userId
            ],
        );

        $siteSettings = Setting::first();
            
        $secretkey = $siteSettings->privatekey;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $secretkey,
            'Content-Type: application/x-www-form-urlencoded'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($result, true);
        // echo "<pre>"; print_r($output); die;

        if(isset($output['error']) && $output['error']['type'] == "invalid_request_error")
        {
                return redirect()->route('site.profile.mylistings' , $userId);

        }
        if(isset($output['error']) && count($output['error'] > 0))
        {
                return redirect()->route('site.profile.mylistings' , $userId);

        }
        else
        {
            return '{"status":"true","session_id":"'.$output['id'].'"}';
        }
    }



    public function promotionpayment($promotionId,$itemId,$userId,$transactionid) 
    {   
    
        $siteSettings = Setting::first();
            
        $secretkey = $siteSettings->privatekey;

        $url = 'https://api.stripe.com/v1/checkout/sessions/'.$transactionid;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $secretkey,
        'Content-Type: application/x-www-form-urlencoded'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($result, true);

        // echo "<pre>"; print_r($output); die;
        if ($output['payment_status'] == 'paid')
        {  
        
            $today = Carbon::now()->timestamp;

            $productdetail = Product::findOrFail($itemId);

            $promotiondetail = Promotion::findOrFail($promotionId);

            //$expiredate = $today->addDays($promotiondetail->duration);

            $expiredate = Carbon::parse($today)->addDays($promotiondetail->duration)->timestamp;

            $utc_todaytime = new \MongoDB\BSON\UTCDateTime($today);


            $utc_expiretime = new \MongoDB\BSON\UTCDateTime($expiredate);

            $productdetail->featured = 1;
            $productdetail->featureDuration = $promotiondetail->duration;
            $productdetail->featureactiveOn = $utc_todaytime;
            $productdetail->featureexpireOn = $utc_expiretime;

            $productdetail->save();

            $userpromotion = new Userpromotion();

            $siteSettings = Setting::first();

            $userpromotion->userId = $userId;
            $userpromotion->itemId = $itemId;
            $userpromotion->promotionId = $promotionId;
            $userpromotion->currencySymbol = $siteSettings->promotioncurrencysymbol;
            $userpromotion->currencyCode = $siteSettings->promotioncurrencycode;
            $userpromotion->activeOn = $utc_todaytime;
            $userpromotion->expireOn = $utc_expiretime;

            $userpromotion->save();

            $notification = array(
                    'message' => trans('Your product promotion is successfully finished'),
                    'alert-type' => 'success',
                );

            session()->put('notification', $notification);
           
            return redirect()->route('site.profile.mylistings' , $userId);
        }
        else
        {
            
            return redirect()->route('site.profile.mylistings' , $userId);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
