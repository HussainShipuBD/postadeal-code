<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Like;
use App\Models\Product;
use App\Models\Currency;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Supercategory;
use App\Models\Location;
use App\Models\Productcondition;

use Illuminate\Support\Str;

class ProductController extends Controller
{
	/*public function __construct()
	{
		$this->middleware('auth');
	} */

		public function approveditems(Request $request)
		{
			$page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
			$perPage = 10;
			$sortby = $request->input('sort');
			$sortorder = $request->input('direction');
			$search_for = "itemTitle";
			$search = "";
			$paginate = Product::where('status', 1)->paginate($perPage);
			if ($sortby && $sortorder) {
				$approveditems = Product::where("status", 1)->get()->sortByDesc($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				if ($sortorder == 'asc') {
					$approveditems = Product::where("status", 1)->get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				}
			} else {
				$approveditems = Product::where("status", 1)->orderBy('createdAt', 'desc')->get()->toArray();
			}
			//echo "<pre>"; print_r($approveditems); die;
			$approveditemsrecords = array_slice($approveditems, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder,'search_for' => $search_for));
			return view('admin.products.approveditems', ['approveditemsrecords' => $approveditemsrecords, 'pagination' => $pagination,'search_for' => $search_for,'search' => $search]);
		}

		public function approveditemsearch(Request $request)
		{	
			$page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
			$perPage = 10;
			$search =$request->input('search');
			$sortby = $request->input('sort');
			$sortorder = $request->input('direction');
			$search_for = (!$request->input('search_for')) ? "itemTitle" : $request->input('search_for');
			if ($search) {
				$paginate = Product::where('status', 1)->where($search_for, 'like', "%$search%")->paginate($perPage);
				$approveditems = Product::where('status', 1)->where($search_for, 'like', "%$search%")->orderBy('createdAt', 'desc')->get()->toArray();
			} else {
				$search = "";
				$paginate = Product::where('status', 1)->paginate($perPage);
				$approveditems = Product::where('status', 1)->orderBy('createdAt', 'desc')->get()->toArray();
				if ($sortorder == 'asc') {
					$approveditems = Product::where('status', 1)->get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				} 
			}
			$approveditemsrecords = array_slice($approveditems, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder, 'search' => $search,'search_for' => $search_for ));
			return view('admin.products.approveditems', compact(['approveditemsrecords', 'search', 'sortby', 'sortorder', 'pagination','search_for']));
		}

		public function pendingitems(Request $request)
		{
			$page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
			$perPage = 10;
			$sortby = $request->input('sort');
			$sortorder = $request->input('direction');
			$search_for = "itemTitle";
			$search = "";
			$paginate = Product::where('status', 0)->paginate($perPage);
			if ($sortby && $sortorder) {
				$pendingitems = Product::where('status', 0)->get()->sortByDesc($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				if ($sortorder == 'asc') {
					$pendingitems = Product::where('status', 0)->get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				}
			} else {
				$pendingitems = Product::where('status', 0)->orderBy('created_at', 'desc')->get()->toArray();
			}
			$pendingitemsrecords = array_slice($pendingitems, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder,'search_for' => $search_for));
			return view('admin.products.pendingitems', ['pendingitemsrecords' => $pendingitemsrecords, 'pagination' => $pagination,'search_for' => $search_for,'search' => $search]);
		}

		public function pendingitemsearch(Request $request)
		{	
			$page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
			$perPage = 10;
			$search =$request->input('search');
			$sortby = $request->input('sort');
			$sortorder = $request->input('direction');
			$search_for = (!$request->input('search_for')) ? "itemTitle" : $request->input('search_for');
			if ($search) {
				$paginate = Product::where('status', 0)->where($search_for, 'like', "%$search%")->paginate($perPage);
				$pendingitems = Product::where('status', 0)->where($search_for, 'like', "%$search%")->orderBy('created_at', 'desc')->get()->toArray();
			} else {
				$search = "";
				$paginate = Product::where('status', 0)->paginate($perPage);
				$pendingitems = Product::where('status', 0)->orderBy('created_at', 'desc')->get()->toArray();
				if ($sortorder == 'asc') {
					$pendingitems = Product::where('status', 0)->get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				} 
			}
			$pendingitemsrecords = array_slice($pendingitems, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder, 'search' => $search,'search_for' => $search_for ));
			return view('admin.products.pendingitems', compact(['pendingitemsrecords', 'search', 'sortby', 'sortorder', 'pagination','search_for']));
		}



		public function reportitems(Request $request)
		{
			$page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
			$perPage = 10;
			$sortby = $request->input('sort');
			$sortorder = $request->input('direction');
			$search_for = "itemTitle";
			$search = "";
			$paginate = Product::where('status', 1)->where('reportCount', '>', 0)->paginate($perPage);
			if ($sortby && $sortorder) {
				$pendingitems = Product::where('status', 1)->where('reportCount', '>', 0)->get()->sortByDesc($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				if ($sortorder == 'asc') {
					$pendingitems = Product::where('status', 1)->where('reportCount', '>', 0)->get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				}
			} else {
				$pendingitems = Product::where('status', 1)->where('reportCount', '>', 0)->orderBy('reportDate', 'desc')->get()->toArray();
			}
			$reportitemsrecords = array_slice($pendingitems, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder,'search_for' => $search_for));
			return view('admin.products.reportitems', ['reportitemsrecords' => $reportitemsrecords, 'pagination' => $pagination,'search_for' => $search_for,'search' => $search]);
		}

		public function reportitemsearch(Request $request)
		{	
			$page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
			$perPage = 10;
			$search =$request->input('search');
			$sortby = $request->input('sort');
			$sortorder = $request->input('direction');
			$search_for = (!$request->input('search_for')) ? "itemTitle" : $request->input('search_for');
			if ($search) {
				$paginate = Product::where('status', 1)->where('reportCount', '>', 0)->where($search_for, 'like', "%$search%")->paginate($perPage);
				$pendingitems = Product::where('status', 1)->where('reportCount', '>', 0)->where($search_for, 'like', "%$search%")->orderBy('reportDate', 'desc')->get()->toArray();
			} else {
				$search = "";
				$paginate = Product::where('status', 1)->where('reportCount', '>', 0)->paginate($perPage);
				$pendingitems = Product::where('status', 1)->where('reportCount', '>', 0)->orderBy('reportDate', 'desc')->get()->toArray();
				if ($sortorder == 'asc') {
					$pendingitems = Product::where('status', 1)->where('reportCount', '>', 0)->get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				} 
			}
			$reportitemsrecords = array_slice($pendingitems, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder, 'search' => $search,'search_for' => $search_for ));
			return view('admin.products.reportitems', compact(['reportitemsrecords', 'search', 'sortby', 'sortorder', 'pagination','search_for']));
		}


		
		public function viewitem($itemId)
		{	
			$itemdetails = Product::find($itemId);
			$currencyId = $itemdetails['CurrencyID'];
			$locationId = $itemdetails['locationID'];
			$mainCategory = $itemdetails['mainCategory'];
			$subCategory = $itemdetails['subCategory'];
			$superCategory = $itemdetails['superCategory'];
			$productCondition = $itemdetails['productCondition'];
			$userId = $itemdetails['userId'];



			$currencydetail = Currency::find($currencyId);
			$locationdetail = Location::find($locationId);
			$userdetail = User::find($userId);
			$categorydetail = Category::find($mainCategory);
			$subcategorydetail = Subcategory::find($subCategory);
			$supercategorydetail = Supercategory::find($superCategory);
			$conditiondetail = Productcondition::find($productCondition);


			
	        return view('admin.products.view', ['itemdetails' => $itemdetails, 'currencydetail' => $currencydetail, 'locationdetail' => $locationdetail, 'userdetail' => $userdetail, 'categorydetail' => $categorydetail, 'subcategorydetail' => $subcategorydetail, 'supercategorydetail' => $supercategorydetail, 'conditiondetail' => $conditiondetail, 'page' => $_GET['page']]);
		}

		public function updateitem(Request $request,$itemId)
		{	

			$userData = User::findOrFail($userId);
			$userData->name = $request->name;
			$userData->email = $request->email;



			// ends here
			if ($userData->save()) {
				$notification = array(
					'message' => trans('messages.Product Details has been updated successfully'),
					'alert-type' => 'success',
				);
			} else {
				$notification = array(
					'message' => trans('messages.Something went wrong'),
					'alert-type' => 'error',
				);
			}

			session()->put('notification', $notification);

			if($request->page == "approved") {
				return redirect()->route('users.approved');
			} else {
				return redirect()->route('users.pending');

			}



		}


		public function changestatus($itemId) {
			

			$status = trim($_GET['itemStatus']);
			$itemData = Product::findOrFail($itemId);
			if($status == "0") {
				$itemData->status = 0;

			} else {
				$itemData->status = 1;
			}

			// ends here
			if ($itemData->save()) {
				$notification = array(
					'message' => trans('Item Status Updated'),
					'alert-type' => 'success',
				);
			} else {
				$notification = array(
					'message' => trans('Something went wrong'),
					'alert-type' => 'error',
				);
			}

			session()->put('notification', $notification);

			return redirect()->back();


	}


	public function deleteitem($itemId) {
			
				//Currency::delete($currencyId);

				$remove = Product::find($itemId);

				$images = json_decode($remove->images, true);

				//echo "<pre>"; print_r($images); die;

				for($i=0; $i<count($images); $i++) {
					$imageName = $images[$i];
					
					$file_path1 = storage_path()."/app/public/products/original/".$imageName;
					$file_path2 = storage_path()."/app/public/products/thumb300/".$imageName;

					//echo $file_path1; echo $file_path2; die;
					$this->unlink($file_path1); 
					$this->unlink($file_path2); 

				}

	        	$remove->delete();

	        	Like::where('itemId', $itemId)->delete();

				$notification = array(
					'message' => trans('Product has been Deleted successfully'),
					'alert-type' => 'success',
				);
				session()->put('notification', $notification);

				return redirect()->back();

	}

	public function unlink($file_path)
	{	
			if(file_exists($file_path)){
				unlink($file_path);
			}
	}


	
	//............ Ends here................
}
