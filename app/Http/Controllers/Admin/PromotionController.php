<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Location;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Userpromotion;
use App\Models\Setting;
use Illuminate\Support\Str;

class PromotionController extends Controller
{
	/*public function __construct()
	{
		$this->middleware('auth');
	} */

		public function index(Request $request)
		{
			$page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
			$perPage = 10;
			$sortby = $request->input('sort');
			$sortorder = $request->input('direction');
			$search_for = "name";
			$search = "";
			$paginate = Promotion::paginate($perPage);
			if ($sortby && $sortorder) {
				$promotions = Promotion::get()->sortByDesc($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				if ($sortorder == 'asc') {
					$promotions = Promotion::get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				}
			} else {
				$promotions = Promotion::orderBy('created_at', 'desc')->get()->toArray();
			}
			$promotionrecords = array_slice($promotions, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder,'search_for' => $search_for));
			$settings = Setting::first();
			return view('admin.promotions.index', ['promotionrecords' => $promotionrecords, 'settings' => $settings, 'pagination' => $pagination,'search_for' => $search_for,'search' => $search]);
		}

		
		public function addpromotion(Request $request)
		{	
			
			return view('admin.promotions.create');
		}
		
		

		public function storepromotion(Request $request)
		{	

			$this->validate(
				$request,
				[
					'promotion_name' => 'required|min:3|max:30',
					'promotion_duration' => 'required',
					'promotion_price' => 'required',
					
				],
				[
					'promotion_name.required' => __('The Promotion name field is required.'),
					'promotion_name.unique' => __('The Promotion name has already been taken.'),
					'promotion_duration.required' => __('The Promotion duration field is required.'),
					'promotion_price.required' => __('The Promotion price field is required.'),

				]
			);

			$name = $request->promotion_name;
			$duration = $request->promotion_duration;
			$promotions_names = Promotion::where('name', $name)->get();
			foreach($promotions_names as $promotions_names){
                if ($promotions_names) {
                    if ($promotions_names->name == $name){
            
                            $notification = array(
                                'message' => trans('Promotion Name Already Exists'),
                                'alert-type' => 'error',
                            );
                            session()->put('notification', $notification);
                            return redirect()->back();
                        
                    }
                }
			}
			foreach($promotions_names as $promotions_names){
                if ($promotions_names) {
                    if ($promotions_names->duration == $duration){
            
                            $notification = array(
                                'message' => trans('Promotion Duration Already Exists'),
                                'alert-type' => 'error',
                            );
                            session()->put('notification', $notification);
                            return redirect()->back();
                        
                    }
                }
			}
			$promotion = new Promotion();
			$name = $request->get('promotion_name');
			$duration = $request->get('promotion_duration');
			$price = $request->get('promotion_price');
			$promotion->name = $name;
			$promotion->duration = $duration;
			$promotion->price = $price;

			if ($promotion->save()) {
				$notification = array(
					'message' => trans('Promotion has been saved successfully'),
					'alert-type' => 'success',
				);
			} else {
				$notification = array(
					'message' => trans('Something went wrong'),
					'alert-type' => 'error',
				);
			}
			session()->put('notification', $notification);
			return redirect()->route('promotions.index');
		}

		public function showSuperCategory()
		{	
			/*$subcategorydetail = Subcategory::find($subcategoryId);
			$categories = Category::where('_id',new \MongoDB\BSON\ObjectID($subcategorydetail->parentCategory))->first();
			$services = Service::where('subCategory',new \MongoDB\BSON\ObjectID($subcategoryId))->get();
	    	return view('admin.subcategories.show', ['subcategorydetail' => $subcategorydetail,'categories' => $categories,'services' => $services]);*/
	    	
	    		    	return view('admin.supercategories.show');
		}
		
		public function editpromotion($promotionId)
		{	
			$promotiondetails = Promotion::find($promotionId);
	        return view('admin.promotions.edit', ['promotiondetails' => $promotiondetails]);
		}

		public function updatepromotion(Request $request,$promotionId)
		{	

			$this->validate(
				$request,
				[
					'promotion_name' => 'required|min:3|max:30',
					'promotion_duration' => 'required',
					'promotion_price' => 'required',
					
				],
				[
					'promotion_name.required' => __('The Promotion name field is required.'),
					'promotion_name.unique' => __('The Promotion name has already been taken.'),
					'promotion_duration.required' => __('The Promotion duration field is required.'),
					'promotion_price.required' => __('The Promotion price field is required.'),

				]
			);

			$name = $request->promotion_name;
			$duration = $request->promotion_duration;
			$promotions_names = Promotion::where('name', $name)->get();
			if($request->promotion_name != $request->promotion_hiddenname) {
				foreach($promotions_names as $promotions_names){
	                if ($promotions_names) {
	                    if ($promotions_names->name == $name){
	            
	                            $notification = array(
	                                'message' => trans('Promotion Name Already Exists'),
	                                'alert-type' => 'error',
	                            );
	                            session()->put('notification', $notification);
	                            return redirect()->back();
	                        
	                    }
	                }
				}
			}

			$promotions_duration = Promotion::where('duration', $duration)->get();
			if($request->promotion_duration != $request->promotion_hiddenduration) {
				foreach($promotions_duration as $promotions_names){
	                if ($promotions_names) {
	                    if ($promotions_names->duration == $duration){
	            
	                            $notification = array(
	                                'message' => trans('Promotion Duration Already Exists'),
	                                'alert-type' => 'error',
	                            );
	                            session()->put('notification', $notification);
	                            return redirect()->back();
	                        
	                    }
	                }
				}
			}
			$promotion = Promotion::findOrFail($promotionId);
			$name = $request->get('promotion_name');
			$promotion->name = $request->promotion_name;
			$promotion->duration = $request->promotion_duration;
			$promotion->price = $request->promotion_price;



			// ends here
			if ($promotion->save()) {
				$notification = array(
					'message' => trans('Promotion has been updated successfully'),
					'alert-type' => 'success',
				);
			} else {
				$notification = array(
					'message' => trans('Something went wrong'),
					'alert-type' => 'error',
				);
			}

			session()->put('notification', $notification);
			return redirect()->route('promotions.index');
		}


		public function deletepromotion($promotionId) {
			$promotioncheck = Userpromotion::where('promotionId' , $promotionId)->count();
			if($promotioncheck != '0') {

				$notification = array(
					'message' => 'Promotion is using by Users',
					'alert-type' => 'error',
				);

				session()->put('notification', $notification);
				return redirect()->back();
			
			} else {

				//Currency::delete($currencyId);

				$remove = Promotion::find($promotionId);
	        	$remove->delete();

				$notification = array(
					'message' => trans('Promotion has been Deleted successfully'),
					'alert-type' => 'success',
				);
				session()->put('notification', $notification);

				return redirect()->route('promotions.index');

			}

	}

		public function promotioncurrency()
		{
			$settings = Setting::first();
			$currencylist = $this->getCurrencyList();
			return view('admin.promotions.promotioncurrency', [
				'settings' => $settings,
				'currencylist' => $currencylist
			]);
		}


		public function updatepromotioncurrency(Request $request)
		{

			
			$settings = Setting::first();
			$settings->promotioncurrencycode = $request->currencycode;
			$settings->promotioncurrencysymbol = $request->currencysymbol;
			$settings->promotioncurrencyname = $request->currencyname;


			if ($settings->save()) {
				$notification = array(
					'message' => trans('Promotion Currency has been Updated successfully'),
					'alert-type' => 'success',
				);
			} else {
				$notification = array(
					'message' => trans('Something went wrong'),
					'alert-type' => 'error',
				);
			}

			session()->put('notification', $notification);

			return redirect()->route('promotions.currency');
		}


		public static function getCurrencyList($cur = null)
		{
			$currency =  array(
				'' => 'Select Currency', '$-Australian Dollar-AUD' => 'AUD',
				'R$-Brazilian Rea-BRL' => 'BRL', 'C$-Canadian Dollar-CAD' => 'CAD',
				'Kč-Czech Koruna-CZK' => 'CZK', 'kr.-Danish Krone-DKK' => 'DKK',
				'€-Euro-EUR' => 'EUR', 'HK$-Hong Kong Dollar-HKD' => 'HKD',
				'Ft-Hungarian Forint-HUF' => 'HUF', '₪-Israeli New Sheqel-ILS' => 'ILS',
				'¥-Japanese Yen-JPY' => 'JPY', 'RM-Malaysian Ringgit-MYR' => 'MYR',
				'Mex$-Mexican Peso-MXN' => 'MXN', 'kr-Norwegian Krone-NOK' => 'NOK',
				'$-New Zealand Dollar-NZD' => 'NZD', '₱-Philippine Peso-PHP' => 'PHP',
				'zł-Polish Zloty-PLN' => 'PLN', '£-Pound Sterling-GBP' => 'GBP',
				'руб-Russian Ruble-RUB' => 'RUB', 'S$-Singapore Dollar-SGD' => 'SGD',
				'kr-Swedish Krona-SEK' => 'SEK', 'CHF-Swiss Franc-CHF' => 'CHF',
				'NT$-Taiwan New Dolla-TWD' => 'TWD', '฿-Thai Baht-THB' => 'THB',
				'も-Turkish Lira-TRY' => 'TRY', '$-U.S. Dollar-USD' => 'USD',
				'NAƒ-Netherlands Antillean guilder-NAFI' => 'NAFI',
				'$-Jamaican Dollar-JMD' => 'JMD', 'Afl-Aruban florin-AWG' => 'AWG',
			);
			if (!empty($cur)) {
				return $currency[$cur];
			} else {
				return $currency;
			}
		}

	
	//............ Ends here................
}
