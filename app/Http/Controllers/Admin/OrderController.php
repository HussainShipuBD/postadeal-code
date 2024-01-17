<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Product;
use App\Models\Currency;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Supercategory;
use App\Models\Location;
use App\Models\Order;
use App\Models\Address;

use Illuminate\Support\Str;

class OrderController extends Controller
{
	/*public function __construct()
	{
		$this->middleware('auth');
	} */

		public function neworders(Request $request)
		{
			$page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
			$perPage = 10;
			$sortby = $request->input('sort');
			$sortorder = $request->input('direction');
			$search_for = "itemTitle";
			$search = "";
			$paginate = Order::where('status', 'paid')->paginate($perPage);
			if ($sortby && $sortorder) {
				$neworders = Order::where("status", 'paid')->get()->sortByDesc($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				if ($sortorder == 'asc') {
					$neworders = Order::where("status", 'paid')->get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				}
			} else {
				$neworders = Order::where("status", 'paid')->orderBy('orderDate', 'desc')->get()->toArray();
			}
			//echo "<pre>"; print_r($approveditems); die;
			$newordersrecords = array_slice($neworders, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder,'search_for' => $search_for));
			$users = User::all();
						//echo "<pre>"; print_r($newordersrecords); die;

			return view('admin.orders.neworders', ['newordersrecords' => $newordersrecords, 'pagination' => $pagination,'search_for' => $search_for,'search' => $search,'users' => $users]);
		}


		public function deliveredorders(Request $request)
		{ 
  			$page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
			$perPage = 10;
			$sortby = $request->input('sort');
			$sortorder = $request->input('direction');
			$search_for = "itemTitle";
			$search = "";
			$paginate = Order::where('status', 'delivered')->paginate($perPage);
			if ($sortby && $sortorder) {
				$neworders = Order::where("status", 'delivered')->get()->sortByDesc($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				if ($sortorder == 'asc') {
					$neworders = Order::where("status", 'delivered')->get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				}
			} else {
				$neworders = Order::where("status", 'delivered')->orderBy('orderDate', 'desc')->get()->toArray();
			}
			//echo "<pre>"; print_r($approveditems); die;
			$newordersrecords = array_slice($neworders, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder,'search_for' => $search_for));
			$users = User::all();
			return view('admin.orders.deliveredorders', ['newordersrecords' => $newordersrecords, 'pagination' => $pagination,'search_for' => $search_for,'search' => $search,'users' => $users]);
		}

		public function settledorders(Request $request)
		{
			$page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
			$perPage = 10;
			$sortby = $request->input('sort');
			$sortorder = $request->input('direction');
			$search_for = "itemTitle";
			$search = "";
			$paginate = Order::where('status', 'settled')->paginate($perPage);
			if ($sortby && $sortorder) {
				$neworders = Order::where("status", 'settled')->get()->sortByDesc($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				if ($sortorder == 'asc') {
					$neworders = Order::where("status", 'settled')->get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				}
			} else {
				$neworders = Order::where("status", 'settled')->orderBy('orderDate', 'desc')->get()->toArray();
			}
			//echo "<pre>"; print_r($approveditems); die;
			$newordersrecords = array_slice($neworders, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder,'search_for' => $search_for));
			$users = User::all();
			return view('admin.orders.settledorders', ['newordersrecords' => $newordersrecords, 'pagination' => $pagination,'search_for' => $search_for,'search' => $search,'users' => $users]);
		}

		public function cancelledorders(Request $request)
		{
			$page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
			$perPage = 10;
			$sortby = $request->input('sort');
			$sortorder = $request->input('direction');
			$search_for = "itemTitle";
			$search = "";
			$paginate = Order::where('status', 'cancelled')->paginate($perPage);
			if ($sortby && $sortorder) {
				$neworders = Order::where("status", 'cancelled')->get()->sortByDesc($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				if ($sortorder == 'asc') {
					$neworders = Order::where("status", 'cancelled')->get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				}
			} else {
				$neworders = Order::where("status", 'cancelled')->orderBy('orderDate', 'desc')->get()->toArray();
			}
			//echo "<pre>"; print_r($approveditems); die;
			$newordersrecords = array_slice($neworders, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder,'search_for' => $search_for));
			$users = User::all();
			return view('admin.orders.cancelledorders', ['newordersrecords' => $newordersrecords, 'pagination' => $pagination,'search_for' => $search_for,'search' => $search,'users' => $users]);
		}


		public function refundedorders(Request $request)
		{
			$page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
			$perPage = 10;
			$sortby = $request->input('sort');
			$sortorder = $request->input('direction');
			$search_for = "itemTitle";
			$search = "";
			$paginate = Order::where('status', 'refunded')->paginate($perPage);
			if ($sortby && $sortorder) {
				$neworders = Order::where("status", 'refunded')->get()->sortByDesc($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				if ($sortorder == 'asc') {
					$neworders = Order::where("status", 'refunded')->get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				}
			} else {
				$neworders = Order::where("status", 'refunded')->orderBy('orderDate', 'desc')->get()->toArray();
			}
			//echo "<pre>"; print_r($approveditems); die;
			$newordersrecords = array_slice($neworders, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder,'search_for' => $search_for));
			$users = User::all();
			return view('admin.orders.refundedorders', ['newordersrecords' => $newordersrecords, 'pagination' => $pagination,'search_for' => $search_for,'search' => $search,'users' => $users]);
		}

		
		
		public function vieworder($orderId)
		{	
			$orderdetail = Order::find($orderId);
			$userId = $orderdetail['userId'];
			$sellerId = $orderdetail['sellerId'];
			$itemId = $orderdetail['itemId'];

			$userdetail = User::find($userId);
			$sellerdetail = User::find($sellerId);
			$itemdetails = Product::find($itemId);

			$addressdetails = Address::find($orderdetail->addressId);

			//echo "<pre>"; print_r($addressdetails); die;
	        return view('admin.orders.view', ['orderdetail' => $orderdetail, 'userdetail' => $userdetail, 'sellerdetail' => $sellerdetail, 'itemdetails' => $itemdetails,  'addressdetails' => $addressdetails, 'page' => $_GET['page']]);
		}


	public function stripesessioncreation($orderId)
    	{     
        $amount = $_POST['amt'] * 100;
        $currency = $_POST['currency'];
        $response_url =  "https://postadeal.com/admin/orders/approve/".$orderId;
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
                    'name' => 'Seller Settlement',
                ],
                ],
                'quantity' => 1,
            ]],
            'metadata'=>[
                "orderId" => $orderId,
            ],
        );

	$orderdetail = Order::find($orderId);
			
        $userdetail = User::find($orderdetail->sellerId);
        $secretkey = $userdetail->stripeSecretKey;

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
			return redirect()->route('orders.delivered');

        }
        if(isset($output['error']) && count($output['error'] > 0))
        {
			return redirect()->route('orders.delivered');

        }
        else
        {
            return '{"status":"true","session_id":"'.$output['id'].'"}';
        }
    }
    
    
    public function approve($orderid,$transactionid) 
    {   
    
        $orderdetail = Order::find($orderid);
			
        $userdetail = User::find($orderdetail->sellerId);
        $secretkey = $userdetail->stripeSecretKey;

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
        
        		$order = Order::findOrFail($orderid);

			$order->status = "settled";


			// ends here
			if ($order->save()) {
				$notification = array(
					'message' => trans('Seller Amount is Successfully Settled'),
					'alert-type' => 'success',
				);
			} else {
				$notification = array(
					'message' => trans('Something went wrong'),
					'alert-type' => 'error',
				);
			}

			session()->put('notification', $notification);
            	return redirect()->route('orders.settled');
        }
        else
        {
            
		return redirect()->route('orders.delivered');
        }
    }


    public function refundorder($orderId) 
    {   
    
        $orderdetail = Order::find($orderId);
        
	$userdetail = User::find($orderdetail->sellerId);
        $secretkey = $userdetail->stripeSecretKey;
        
        $transactionId = $orderdetail['pay_token'];

        $url = 'https://api.stripe.com/v1/refunds';
        $data = array('payment_intent' => $transactionId);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $secretkey,'Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($result,true);

        // echo "<pre>"; print_r($output); die;
        if ($output['status'] == 'succeeded')
        {  
        
        		$order = Order::findOrFail($orderId);

			$order->status = "refunded";


			// ends here
			if ($order->save()) {
				$notification = array(
					'message' => trans('Buyer Amount is Refunded'),
					'alert-type' => 'success',
				);
			} else {
				$notification = array(
					'message' => trans('Something went wrong'),
					'alert-type' => 'error',
				);
			}

			session()->put('notification', $notification);
            	return redirect()->route('orders.refundedorders');
        }
        else
        {
            
		return redirect()->route('orders.cancelled');
        }
    }


	
	//............ Ends here................
}
