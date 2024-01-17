<?php
namespace App\Classes;

use App\Models\Setting;
use App\Models\Help;
use App\Models\Product;
use App\Models\Currency;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Supercategory;
use App\Models\Productcondition;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Str;

use Config;
use Session;
use Illuminate\Support\Facades\Mail;
class MyClass
{


    public static function site_settings()
    {
        $siteSettings = Setting::first();
        return $siteSettings;
    }

    public static function get_maincategory()
    {
       $categories = Category::orderBy('created_at', 'asc')->get()->toArray();
        return $categories;
    }

    public static function get_subcategory($id)
    {
       $subcategories = Subcategory::where('parentCategory', new \MongoDB\BSON\ObjectID($id))->orderBy('created_at', 'asc')->get()->toArray();
        return $subcategories;
    }
    public static function get_supercategory($id, $subid)
    {
       $supercategories = Supercategory::where('parentCategory', new \MongoDB\BSON\ObjectID($id))->where('subCategory', new \MongoDB\BSON\ObjectID($subid))->orderBy('created_at', 'asc')->get()->toArray();
        return $supercategories;
    }

    public static function get_maincategory_item($id)
    {
       $categories = Category::where('_id', new \MongoDB\BSON\ObjectID($id))->orderBy('created_at', 'asc')->get()->toArray();
        return $categories;
    }


    public static function get_prodcutcondition_item($id)
    {

       $productconditiondetail = Productcondition::where('_id', new \MongoDB\BSON\ObjectID($id))->orderBy('created_at', 'asc')->get()->toArray();
        return $productconditiondetail;
    }

    public static function get_prodcutcondition_search()
    {

       $productconditiondetail = Productcondition::orderBy('created_at', 'asc')->get()->toArray();
        return $productconditiondetail;
    }


    public static function get_supercategory_check($id, $subid)
    {
       $supercategories = Supercategory::where('parentCategory', new \MongoDB\BSON\ObjectID($id))->where('subCategory', new \MongoDB\BSON\ObjectID($subid))->get()->toArray();

       if(!empty($supercategories))
       {
            return '1';
       } else 
       {
        return '0';
       } 
    }


    public static function get_userdetails($userid)
    {
       $userdetails = User::where('_id', new \MongoDB\BSON\ObjectID($userid))->get()->toArray();
        return $userdetails;
    }


    public static function get_reviewdetails($userid, $sellerid)
    {
       $reviewdetails = Review::where('userId', new \MongoDB\BSON\ObjectID($userid))->where('sellerId', new \MongoDB\BSON\ObjectID($sellerid))->get()->toArray();
        return $reviewdetails;
    }


      public static function get_parent_categoryid($categoryId, $type)
    {
        if($type == 'subid')
        {    
        $catdetails = Subcategory::find($categoryId);
        } else {
        $catdetails = Supercategory::find($categoryId);
        }
        return $catdetails['parentCategory'];
    }


    public static function helps()
    {
        $helpdetails = Help::get();
        return $helpdetails;
    }

    public static function get_items($itemdetails){
    $myClass = new MyClass();
         
    $item = array();    
    foreach($itemdetails as $key => $itemdetail)
     {
      $item[$key]['itemid'] =  $itemdetail['_id'];
      $item[$key]['itemtitle'] =  $itemdetail['itemTitle'];
      $item[$key]['itemprice'] =  (isset($itemdetail['price']) && $itemdetail['price'] != "0") ? $itemdetail['price'] : 'Free Shipping';
      $item[$key]['itemcurrency'] =  (isset($itemdetail['price']) && $itemdetail['price'] != "0") ? $myClass->get_itemcurrency($itemdetail['CurrencyID']) : '';
      $item[$key]['itemdate'] =  $myClass->get_itemdate((isset($itemdetail['createdAt']) && $itemdetail['createdAt'] != "") ? $itemdetail['createdAt'] : '0');
      $item[$key]['itemimage'] =  $myClass->get_itemimage($itemdetail['images']); 
      $item[$key]['itemfeatured'] =  $itemdetail['featured']; 
      $item[$key]['itemfeaturedexpire'] =  $itemdetail['featured']; 
      $item[$key]['itemlocation'] =  (isset($itemdetail['locationName']) && $itemdetail['locationName'] != "") ?          $itemdetail['locationName'] : 'No location'; 
//      $item[$key]['itemuserid'] =  $itemdetail['userId']; 
     }

     return $item;   

    }

    public static function get_address($latitude, $longitude)
    {
            $ch = curl_init("https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDrjtoIPgvVT7oQ8IQ_ZLLbjKEatmCFyBI&latlng=" . $latitude . "," . $longitude);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
            $content = curl_exec($ch);
            curl_close($ch);
            $decryptData = json_decode($content);
            $formatted_address = $decryptData->results[5]->formatted_address;

            Session::put('locationname', $formatted_address);
            Session::put('locationlat', $latitude);
            Session::put('locationlon', $longitude);
//            session()->put('locationname', $formatted_address);
            return true;
    }    

    public static function get_itemcurrency($currencyId)
    {
        $currencydetails = Currency::find($currencyId);
        return $currencydetails['currencysymbol'];
    }

    public static function get_itemdate($date){


        $seconds  = strtotime(date('Y-m-d H:i:s')) - strtotime($date);

        $months = floor($seconds / (3600*24*30));
        $day = floor($seconds / (3600*24));
        $hours = floor($seconds / 3600);
        $mins = floor(($seconds - ($hours*3600)) / 60);
        $secs = floor($seconds % 60);

        if($seconds < 60)
            $time = $secs." Seconds ago";
        else if($seconds < 60*60 )
            $time = $mins." Min ago";
        else if($seconds < 24*60*60)
            $time = $hours." Hours ago";
        else if($seconds < 24*60*60*30)
            $time = $day." Day ago";
        else
            $time = $months." Month ago";

        return $time;



     }

    public static function get_itemimage($image)
    {
        $images = json_decode($image, TRUE); 
        return $images[0];
    }
    
    
}
?>
