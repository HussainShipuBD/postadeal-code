<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dashboard;
use App\Models\User;
use App\Models\Devicetoken;
use App\Models\Product;
use App\Models\Log;
use App\Models\Order;
use App\Classes\MyClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use Redirect;
use Session;
use Validator;
use Config;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     

     
    public function index()
    {
        //

        $totalusers = User::count();
        $totalapprovedusers = User::where('status', 1)->count();
        $totalpendingusers = User::where('status', 0)->count();
        $totalproducts = Product::count();
        $totalapprovedproducts = Product::where('status', 1)->count();
        $totalpendingproducts = Product::where('status', 0)->count();
        $todayusers = User::where('createdAt', '>=' , Carbon::today())->count();

        $neworders = Order::where('status', 'paid')->count();
        $deliveredorders = Order::where('status', 'delivered')->count();
        $cancelledorders = Order::where('status', 'cancelled')->count();
        $settledorders = Order::where('status', 'settled')->count();

        $totalfeatureproducts = Product::where('featured', 1)->count();
        $totalreportproducts = Product::where('reportCount', '>', 0)->count();

        //$adminrevenue = Order::where('status', 'paid')->orWhere('status','delivered')->orWhere('status','settled')->get();

        $todayorders = Order::where('createdAt', '>=' , Carbon::today())->count();


        $dateNow = Carbon::now(); 
        $startOfYear = $dateNow->startOfYear();  
        $dateNow = Carbon::now(); 
        $endOfYear = $dateNow->endOfYear(); 
        $usercount = [0,0,0,0,0,0,0,0,0,0,0,0];  
        $users = User::raw()->aggregate([
            [ '$match' => [
                'createdAt' => [ '$gte' => new \MongoDB\BSON\UTCDateTime($startOfYear) ,'$lte' => new \MongoDB\BSON\UTCDateTime($endOfYear) ],
              ]],
            
              [ '$group' => [
                '_id' => [ '$dateToString' => [ 'format' => '%m', 'date' => '$createdAt' ] ],
                'count' => [ '$sum' => 1 ]
              ]]
        ]);
        foreach ($users as $value) {
            if($value){
               $monthIndex = intval($value->_id);
               $usercount[$monthIndex - 1] = $value->count;
            }
        }
//echo "<pre>"; print_r($usercount); die;

        return view('admin.index', ['totalusers' => $totalusers, 'totalapprovedusers' => $totalapprovedusers, 'totalpendingusers' => $totalpendingusers, 'totalproducts' => $totalproducts, 'totalapprovedproducts' => $totalapprovedproducts, 'totalpendingproducts' => $totalpendingproducts, 'todayusers' => $todayusers, 'usercount' => $usercount, 'neworders' => $neworders, 'deliveredorders' => $deliveredorders, 'cancelledorders' => $cancelledorders, 'settledorders' => $settledorders, 'totalfeatureproducts' => $totalfeatureproducts, 'totalreportproducts' => $totalreportproducts, 'todayorders' => $todayorders]);
    }

    
    public function sendalert()
    {

        $msg = $_POST['message'];

        $myClass = new MyClass();
        

        $devices = Devicetoken::all();
        
        $devicetoken = array();
        foreach ($devices as $device) {
            array_push($devicetoken, $device->deviceToken);
        }

        if (!empty($devicetoken)) 
        {
                try {
                    $usernotification = $myClass->push_notification($devicetoken, $msg, 'all');
                } catch (\Throwable $th) {
                      throw $th;
                }
        }

            $today = Carbon::now()->format('Y-m-d H:i:s.z');

            $message = new Log();
            $message->messageType = 'admin';
            $message->messageTxt = $msg;
            $message->isAdmin = 1;
            $message->createdAt = $today;
            $message->save();
        

        echo "success"; die;
    }


}
