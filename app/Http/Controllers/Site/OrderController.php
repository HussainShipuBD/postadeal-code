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
use App\Models\Order;
use App\Models\Commission;
use App\Models\Userpromotion;
use App\Models\Address;
use App\Models\Setting;
use App\Classes\MyClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Session;
use Image;
use Hash;

class OrderController extends Controller
{
    

    public function myorders($page = 1)
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


        $orderdetails = Order::where("userId",$userId)->orderBy('orderDate', 'asc')->limit($limit)->offset($offset)->get()->toArray();

        $ordercollections = array();    
        foreach($orderdetails as $key => $orderdetails) {

            $productId = $orderdetails['itemId'];

            $itemdetail = Product::where("_id",$productId)->orderBy('postingDate', 'asc')->first()->toArray();

              $ordercollections[$key]['orderid'] =  $orderdetails['_id'];
              $ordercollections[$key]['itemtitle'] =  $itemdetail['itemTitle'];
              $ordercollections[$key]['itemprice'] =  $orderdetails['price']; 
              $ordercollections[$key]['shippingprice'] =  $orderdetails['shippingprice']; 
              $ordercollections[$key]['totalprice'] =  $orderdetails['totalprice']; 
              $ordercollections[$key]['currency'] =  $orderdetails['currency'];
              $ordercollections[$key]['orderdate'] =  $orderdetails['orderDate'];
              $ordercollections[$key]['itemimage'] =  $myClass->get_itemimage($itemdetail['images']); 
              $ordercollections[$key]['status'] =  $orderdetails['status'];

              $sellerdetail = User::find($orderdetails['sellerId']);

              $ordercollections[$key]['sellername'] =  $sellerdetail['name'];



        }

        $orderscount = Order::where("userId",$userId)->orderBy('orderDate', 'asc')->count();

        //echo "<pre>"; print_r($promotiondetails); die;
        
        return view('site.order.myorders' , ['ordercollections' => $ordercollections , 'orderscount' => $orderscount , 'userId' => $userId , 'page' => $page , 'pageLeft' => $pageLeft , 'pageRight' => $pageRight , 'userdetail' => $userdetail , 'view' => 'myorders' , 'reviewdetailcount' => $reviewdetailcount , 'reviewratingtotal' => $reviewratingtotal]);

    }


	public function mysales($page = 1)
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


        $orderdetails = Order::where("sellerId",$userId)->orderBy('orderDate', 'asc')->limit($limit)->offset($offset)->get()->toArray();

        $ordercollections = array();    
        foreach($orderdetails as $key => $orderdetails) {

            $productId = $orderdetails['itemId'];

            $itemdetail = Product::where("_id",$productId)->orderBy('postingDate', 'asc')->first()->toArray();

              $ordercollections[$key]['orderid'] =  $orderdetails['_id'];
              $ordercollections[$key]['itemtitle'] =  $itemdetail['itemTitle'];
              $ordercollections[$key]['itemprice'] =  $orderdetails['price']; 
              $ordercollections[$key]['shippingprice'] =  $orderdetails['shippingprice']; 
              $ordercollections[$key]['totalprice'] =  $orderdetails['totalprice']; 
              $ordercollections[$key]['currency'] =  $orderdetails['currency'];
              $ordercollections[$key]['orderdate'] =  $orderdetails['orderDate'];
              $ordercollections[$key]['itemimage'] =  $myClass->get_itemimage($itemdetail['images']); 
              $ordercollections[$key]['status'] =  $orderdetails['status'];

              $buyerdetail = User::find($orderdetails['userId']);

              $ordercollections[$key]['buyername'] =  $buyerdetail['name'];



        }

        $orderscount = Order::where("userId",$userId)->orderBy('orderDate', 'asc')->count();

        //echo "<pre>"; print_r($promotiondetails); die;
        
        return view('site.order.mysales' , ['ordercollections' => $ordercollections , 'orderscount' => $orderscount , 'userId' => $userId , 'page' => $page , 'pageLeft' => $pageLeft , 'pageRight' => $pageRight , 'userdetail' => $userdetail , 'view' => 'mysales' , 'reviewdetailcount' => $reviewdetailcount , 'reviewratingtotal' => $reviewratingtotal]);

    }


    public function orderconfirm($itemId)
    {

        if(!Auth::user()) {
            return redirect()->route('main.index');
        }  

        $myClass = new MyClass();

        $loginuser = Auth::user();
        $userId = Auth::id();

        $userdetail = User::find($userId);

        $itemdetail = Product::find($itemId);

        $currencydetail = Currency::find($itemdetail['CurrencyID']);

    
        $addressdetail = Address::where('userId', $userId)->orderBy('addressDate', 'desc')->get()->toArray();


        return view('site.order.orderconfirm' , ['userdetail' => $userdetail , 'itemdetail' => $itemdetail , 'addressdetail' => $addressdetail , 'currencydetail' => $currencydetail , 'userId' => $userId]);

    }

    public function orderpaycreation() {  

        $amount = $_POST['amount'] * 100;
        $currency = $_POST['currency'];
        $addressId = $_POST['addressId'];
        $itemId = $_POST['itemId'];
        $userId = $_POST['userId'];

        $response_url =  "https://devapp.mindleef.com/bigdil/order/orderpayment/".$addressId."/".$itemId.'/'.$userId;
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
                    'name' => 'Order Payment',
                ],
                ],
                'quantity' => 1,
            ]],
            'metadata'=>[
                "addressId" => $addressId,
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
                return redirect()->route('product.show' , $itemId);

        }
        if(isset($output['error']) && count($output['error'] > 0))
        {
                return redirect()->route('product.show' , $itemId);

        }
        else
        {
            return '{"status":"true","session_id":"'.$output['id'].'"}';
        }
    }


    public function orderpayment($addressId,$itemId,$userId,$transactionid) 
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

        //echo "<pre>"; print_r($output); die;

        $neworder = new Order();

        $neworder->userId = $userId;
        $neworder->itemId = $itemId;
        $neworder->addressId = $addressId;

        $itemdetail = Product::find($itemId);

        $neworder->sellerId = $itemdetail['userId'];
        $neworder->price = $itemdetail['price'];
        $neworder->shippingprice = $itemdetail['shippingprice'];

        if($itemdetail['shippingprice']) {
            $totalprice = intval($itemdetail['price']) + intval($itemdetail['shippingprice']);
        } else {
            $totalprice = intval($itemdetail['price']);
        }

        $neworder->totalprice = $totalprice;

        $commissions = Commission::orderBy('created_at', 'desc')->get()->toArray();

        foreach($commissions as $commissions) {
            $minrange = $commissions['minrange'];
            $maxrange =  $commissions['maxrange'];

            if ($totalprice >= $minrange && $totalprice <= $maxrange) {
                $amount = (floatval($totalprice) / 100) * ($commissions['percentage']);
                $neworder->commissionprice = $amount;
                
            }


        }

        $currencydetail = Currency::find($itemdetail['CurrencyID']);

        $neworder->currency = $currencydetail['currencysymbol'];
        $neworder->currencyCode = $currencydetail['currencycode'];

        $neworder->pay_token = $transactionid;

        $today = Carbon::now()->timestamp;
        $utc_todaytime = new \MongoDB\BSON\UTCDateTime($today);

        $neworder->orderDate = $utc_todaytime;
        $neworder->otp = mt_rand(1000,9999);


        if ($output['payment_status'] == 'paid')
        {  

            $neworder->status = "paid";
            $neworder->productAvailability = "sold";

            $neworder->save();

            
            $notification = array(
                    'message' => trans('Order successfully finished'),
                    'alert-type' => 'success',
                );

            session()->put('notification', $notification);
           
            return redirect()->route('site.order.myorders');
        }
        else
        {

            $neworder->status = "incomplete";

            $neworder->save();
            
            $notification = array(
                    'message' => trans('Order payment is incomplete'),
                    'alert-type' => 'success',
                );

            session()->put('notification', $notification);
           
            return redirect()->route('site.order.myorders');
        }
    }


    
}
