<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Currency;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class CurrencyController extends Controller
{
	/*protected $CategoryController;
	public function __construct(CategoryController $CategoryController)
	{
		$this->middleware('auth');
		$this->CategoryController = $CategoryController;
	}*/

	public function index(Request $request)
	{
		$page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
		$perPage = 10;
		$sortby = $request->input('sort');
		$sortorder = $request->input('direction');
		$search_for = "currencyname";
		$search = "";
		$paginate = Currency::paginate($perPage);
		if ($sortby && $sortorder) {
			$currencies = Currency::get()->sortByDesc($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
			if ($sortorder == 'asc') {
				$currencies = Currency::get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
			}
		} else {
			$currencies = Currency::orderBy('created_at', 'desc')->get()->toArray();
		}
		// echo '<pre>'; print_r($services); die;
		$currencyrecords = array_slice($currencies, $perPage * ($page - 1), $perPage);
		$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder, 'search_for' => $search_for));

		// echo '<pre>'; print_r($pagination); die;
		return view('admin.currency.index', ['currencyrecords' => $currencyrecords, 'pagination' => $pagination, 'search_for' => $search_for, 'search' => $search]);
	}

	public function search(Request $request)
		{	
			$page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
			$perPage = 10;
			$search =$request->input('search');
			$sortby = $request->input('sort');
			$sortorder = $request->input('direction');
			$search_for = (!$request->input('search_for')) ? "currencyname" : $request->input('search_for');
			if ($search) {
				$paginate = Currency::where($search_for, 'like', "%$search%")->paginate($perPage);
				$currencies = Currency::where($search_for, 'like', "%$search%")->orderBy('created_at', 'desc')->get()->toArray();
			} else {
				$search = "";
				$paginate = Currency::paginate($perPage);
				$currencies = Currency::orderBy('created_at', 'desc')->get()->toArray();
				if ($sortorder == 'asc') {
					$currencies = Currency::get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				} 
			}
			$currencyrecords = array_slice($currencies, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder, 'search' => $search,'search_for' => $search_for ));
			return view('admin.currency.index', compact(['currencyrecords', 'search', 'sortby', 'sortorder', 'pagination','search_for']));
		}

	public function addCurrency(Request $request)
	{
		
		$currencylist = $this->getCurrencyList();
		return view('admin.currency.create', ['currencylist' => $currencylist]);
	}

	public function storecurrency(Request $request)
	{
		$this->validation($request);
		$currency_code = $request->currencycode;
		$currency_symbol = $request->currencysymbol;
		$currency_name = $request->currencyname;


		$currency = Currency::updateOrCreate([
			'currencycode' => $currency_code,
			'currencysymbol' => $currency_symbol,
			'currencyname' => $currency_name,
		]);
		$currency->save();
		if ($currency->save()) {
			$notification = array(
				'message' => trans('Currency has been saved successfully'),
				'alert-type' => 'success',
			);
		} else {
			$notification = array(
				'message' => trans('Something went wrong'),
				'alert-type' => 'error',
			);
		}

		session()->put('notification', $notification);

		return redirect()->route('currency.index');
	}


	public function showCurrency($serviceId)
	{
		$currencydetail = Currency::find($serviceId);
		return view('admin.currency.show', ['currencydetail' => $currencydetail]);
	}

	public function editcurrency($currencyId)
	{
		$currencydetails = Currency::find($currencyId);
		$currencylist = $this->getCurrencyList();
		return view('admin.currency.edit', [
			'currencydetails' => $currencydetails,
			'currencylist' => $currencylist
		]);
	}

	public function updatecurrency(Request $request, $currencyId)
	{
		$this->validation($request);

		$currency = Currency::find($currencyId);
		$currency_code = $request->currencycode;
		$currency_symbol = $request->currencysymbol;
		$currency_name = $request->currencyname;

		$checkCurrencyExist = Currency::where(['currencycode' => $currency_code])->where('_id', '!=', $currencyId)->first();
		if (!empty($checkCurrencyExist)) {
			$notification = array(
				'message' => 'Currency Already Exists',
				'alert-type' => 'error',
			);
			session()->put('notification', $notification);
			return redirect()->back();
		}
		


		$currency = Currency::findOrFail($currencyId);
			$currency->currencycode = $request->currencycode;
			$currency->currencysymbol = $request->currencysymbol;
			$currency->currencyname = $request->currencyname;


		if ($currency->save()) {
			$notification = array(
				'message' => trans('Currency has been Updated successfully'),
				'alert-type' => 'success',
			);
		} else {
			$notification = array(
				'message' => trans('Something went wrong'),
				'alert-type' => 'error',
			);
		}

		session()->put('notification', $notification);

		return redirect()->route('currency.index');
	}

	public function deletecurrency($currencyId) {
		$productcheck = Product::where('CurrencyID' , $currencyId)->count();
		if($productcheck != '0') {

			$notification = array(
				'message' => 'Currency is using for Some Products',
				'alert-type' => 'error',
			);

			session()->put('notification', $notification);
			return redirect()->back();
		
		} else {

			//Currency::delete($currencyId);

			$remove = Currency::find($currencyId);
        	$remove->delete();

			$notification = array(
				'message' => trans('Currency has been Deleted successfully'),
				'alert-type' => 'success',
			);

			session()->put('notification', $notification);


			return redirect()->route('currency.index');

		}

	}

	public function ajaxcurrencyRate(Request $request)
	{
		if ($request->ajax()) {
			$defaultCur = Currency::where(['defaultcurrency' => '1'])->first();
			if (!empty($defaultCur)) {
				$default = $defaultCur->currencycode;
				$dynamic = $request->currency;
				echo $amt = $this->currencyConverter($default, $dynamic, 1);
			}
		}
	}
	
	public function unlink($file_path)
	{
		if (file_exists($file_path)) {
			unlink($file_path);
		}
	}
	public function validation(Request $request)
	{
		$this->validate(
			$request,
			[
				'currencycode' => 'required|min:3|max:30',
				'currencysymbol' => 'required',
				'currencyname' => 'required'
			],
			[
				'currencycode.required' => __('The currency code name field is required.'),
				'currencysymbol.required' => __('The currency symbol field is required.'),
				'currencyname.required' => __('The currency name field is required')
			]
		);
	}

	/*
		Custom functions
	*/
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

}
