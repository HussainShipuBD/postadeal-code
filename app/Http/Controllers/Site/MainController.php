<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Currency;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Supercategory;
use App\Models\Location;
use App\Models\Productcondition;
use App\Models\Banner;
use App\Classes\MyClass;
use Session;


class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    $myClass = new MyClass();

    $itemdetails = Product::where("status", 1)->orderBy('featured', 'desc')->paginate(20);

    $item = $myClass->get_items($itemdetails);

    $itemdetailsfav = Product::where("status", 1)->where("featured", 1)->orderBy('createdAt', 'desc')->get()->toArray();
    $itemfav = $myClass->get_items($itemdetailsfav);

     $banners = Banner::orderBy('created_at', 'desc')->get()->toArray();

/*
        if(isset(auth()->user()->id))
        {
        $user_id = auth()->user()->id;  
        echo $user_id;die;
        }   

*/
   // echo "<pre>"; print_r($banners); die;

        return view('site.main', ['itemdetails' => $item, 'itemdetailsfav' => $itemfav, 'bannerdetails' => $banners ]);
    }


    public function loadMoreitem(Request $request)
    {
        $myClass = new MyClass();
        $itemdetails = Product::where("status", 1)->orderBy('featured', 'desc')->paginate(20);
        $item = $myClass->get_items($itemdetails);
        $items = '';
        if ($request->ajax()) {
            foreach ($item as $itemdetail) {

        $items.='<div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <a href="'.url("/product/show").'/'.$itemdetail['itemid'].'">
                            <div class="feat_property home3">
                                <div class="thumb">
                                    <img class="img-whp" src="'.url("/storage/app/public/products/thumb300").'/'.$itemdetail['itemimage'].'"  alt="'.$itemdetail['itemtitle'].'">

                                </div>
                                <div class="tc_content">
                                        <div class="d-flex justify-content-between flex-wrap align-items-center">
                                            <p class="txt-truncate sec-color">'.$itemdetail['itemdate'].'
                                            </p>
                                            <div class="txt-truncate mb-1">
                                            '.$itemdetail['itemtitle'].'</div>
                                            <div class="price-dis">
                                                <span class="dollor">'.$itemdetail['itemcurrency'].'</span>
                                                <span class="ml-1">'.$itemdetail['itemprice'].'</span>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </a>
                    </div>';
                          }
            return $items;
        }
        return view('site.main');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {

    $myClass = new MyClass();
    $offset = 0;
    $limit = 20;
    $type = 'normal';
    $catId = $request['catId'];
    $latitude = (isset($request['searchlatitude']) && $request['searchlatitude'] != "") ? $request['searchlatitude'] : Session::get('locationlat');
    $longitude = (isset($request['searchlongitude']) && $request['searchlongitude'] != "") ? $request['searchlongitude'] : Session::get('locationlon');
    $itemnamesearch = $request['itemnamesearch'];
    $itemsellerid = $request['product-sellerid'];
    $categoryId = '';
    $subcategoryId = '';
    $supercategoryId = '';
    $mainCategoryid = '';

    $category = explode('-', $catId); 



        $productarray = Product::where("status", 1);

        if($category[0] == 'cid')
        {
           $productarray->where('mainCategory', $category[1]);
           $categoryId = $category[1];
           $mainCategoryid =  $category[1];
        }    
        if($category[0] == 'subid')
        {
             $productarray->where('subCategory', $category[1]);
            $subcategoryId = $category[1];
            $mainCategoryid = $myClass->get_parent_categoryid($subcategoryId, 'subid');
        }    
        if($category[0] == 'superid')
        {
             $productarray->where('superCategory', $category[1]);
              $supercategoryId = $category[1];
             $mainCategoryid = $myClass->get_parent_categoryid($supercategoryId, 'superid');
        }    
       if($catId == 'featured')
       {
        $productarray->where("featured", 1);
        $type = 'featured'; 
       }
        if($catId == 'location')
       {    
            $productarray->where('location', 'near', [
                '$geometry' => [
                    'type' => 'Point',
                    'coordinates' => [
                        (double)$longitude, // longitude
                        (double)$latitude, // latitude
                    ],
                ],
                '$maxDistance' => 50,
                ]);
      }
        if(!empty($latitude) && !empty($longitude) && $catId == 'itemname')
       {    
            $productarray->where('location', 'near', [
                '$geometry' => [
                    'type' => 'Point',
                    'coordinates' => [
                        (double)$longitude, // longitude
                        (double)$latitude, // latitude
                    ],
                ],
                '$maxDistance' => 50,
                ]);
      }
       if($catId == 'itemname' && isset($itemnamesearch))
        {
        $productarray->where('itemTitle','LIKE','%'.$itemnamesearch.'%');
        }
        if($catId == 'selleritem')
       {
        $productarray->where('userId', $itemsellerid);
       }        

        $itemdetails = $productarray->orderBy('createdAt', 'desc')->offset(intval($offset))->limit(intval($limit))->get()->toArray();

      // print_r($itemdetails);die;
        $item = $myClass->get_items($itemdetails);
        $offset = $offset + count($item);

//        echo $catId;die;

        if(empty($mainCategoryid))
        {
        $categories = Category::orderBy('created_at', 'asc')->get()->toArray();

        } else 
        {
        $categories = Category::where('_id', new \MongoDB\BSON\ObjectID($mainCategoryid))->orderBy('created_at', 'asc')->get()->toArray();
        }

        return view('site.search', ['categoryId' => $categoryId, 'subcategoryId' => $subcategoryId, 'supercategoryId' => $supercategoryId, 'categories' => $categories, 'itemdetails' => $item, 'type' => $type, 'searchlat' => $latitude, 'searchlon' => $longitude ,'catId' => $catId, 'itemnamesearch' => $itemnamesearch, 'itemsellerid' => $itemsellerid, 'offset' => $offset, 'limit' => $limit]);
    }



        public function searchloadMoreitem(Request $request)
    {
        $myClass = new MyClass();

            $offset = (isset($request['offset']) && $request['offset'] != "") ? $request['offset'] : 0;
            $limit = (isset($request['limit']) && $request['limit'] != "") ? $request['limit'] : 20; 
/*            $searchmin = (isset($request['searchmin']) && $request['searchmin'] != "") ? $request['searchmin'] : 0;
            $searchmax = (isset($request['searchmax']) && $request['searchmax'] != "") ? $request['searchmax'] : 10000000;
*/
        $searchmin = $request['searchmin'];
        $searchmax = $request['searchmax'];
        $orderby = $request['orderby'];
        $type = $request['type'];
        $latitude = $request['latitude'];
        $longitude = $request['longitude'];
        $itemnamesearch = $request['itemnamesearch'];
        $itemsellerid = $request['itemsellerid'];
        $categoryId = $request['categoryId'];
        $subcategoryId = $request['subcategoryId'];
        $supercategoryId = $request['supercategoryId'];

        $productarray = Product::where("status", 1);


        if(!empty($categoryId))
        {
           $productarray->where('mainCategory', $categoryId);
        }    
        if(!empty($subcategoryId))
        {
             $productarray->where('subCategory', $subcategoryId);
        }    
        if(!empty($supercategoryId))
        {
             $productarray->where('superCategory', $supercategoryId);
        }    
        if(!empty($searchmin) && !empty($searchmax))
        {
        $productarray->whereBetween('price', array(intval($searchmin) , intval($searchmax)));    
        } 
        if(!empty($orderby))
        {
        $productarray->orderBy('price', $orderby);    
        }
        if(!empty($latitude) && !empty($longitude))
        {
         $productarray->where('location', 'near', [
                '$geometry' => [
                    'type' => 'Point',
                    'coordinates' => [
                        (double)$longitude, // longitude
                        (double)$latitude, // latitude
                    ],
                ],
                '$maxDistance' => 50,
                ]);    
        }  
        if(!empty($itemnamesearch))
        {
        $productarray->where('itemTitle','LIKE','%'.$itemnamesearch.'%');
        }
        if(!empty($itemsellerid))
        {
         $productarray->where('userId', $itemsellerid);
        }     


        if($type == 'featured')
        {
        $productarray->where("featured", 1);   
        } else {
        $productarray->where("featured", 0);   
        } 

        $itemdetails = $productarray->orderBy('createdAt', 'desc')->offset(intval($offset))->limit(intval($limit))->get()->toArray();

        $item = $myClass->get_items($itemdetails);

//        print_r(count($item));die;
        $itemcount = $offset + count($item);

        $items = '';
        if ($request->ajax()) {
            foreach ($item as $itemdetail) {

        $items.='<div class="col-6 col-sm-6 col-md-4 col-lg-3 cat-right " id="item-check">
                        <a href="'.url("/product/show").'/'.$itemdetail['itemid'].'">
                            <div class="feat_property home3">
                                <div class="thumb">
                                    <img class="img-whp" src="'.url("/storage/app/public/products/thumb300").'/'.$itemdetail['itemimage'].'"  alt="'.$itemdetail['itemtitle'].'">';
                                     if($itemdetail['itemfeatured'] == 1) {   
                                       $items.='<div class="thmb_cntnt">
                                          <ul class="tag mb0">
                                             <li class="color-white">'.__('messages.Featured').'</li>
                                          </ul>
                                       </div>';
                                       }

                                $items.='</div>
                                <div class="tc_content">
                                        <div class="d-flex justify-content-between flex-wrap align-items-center">
                                            <p class="txt-truncate sec-color">'.$itemdetail['itemdate'].'
                                            </p>
                                            <div class="txt-truncate mb-1">
                                            '.$itemdetail['itemtitle'].'</div>
                                            <div class="price-dis">
                                                <span class="dollor">'.$itemdetail['itemcurrency'].'</span>
                                                <span class="ml-1">'.$itemdetail['itemprice'].'</span>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </a>
                    </div>';
                          }
            $result['items'] = $items;
            $result['itemcount'] = $itemcount;             
            return $result;
        }
       return view('site.search');
    }



 public function setcurrentlocation(Request $request)
    {
        $type = $request['check'];
        $locationname = $request['locationname'];
        $latitude = $request['latitude'];
        $longitude = $request['longitude'];

            if($type == 'clear')
            {    
            Session::forget('locationname');
            Session::forget('locationlat');
            Session::forget('locationlon');
            } else {
            Session::put('locationname', $locationname);
            Session::put('locationlat', $latitude);
            Session::put('locationlon', $longitude);
            }
            return true;
    }    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
