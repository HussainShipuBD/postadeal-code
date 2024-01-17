<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Productcondition;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductConditionController extends Controller
{
	/*public function __construct()
	{
		$this->middleware('auth');
	} */
	//............ Sub-Category crud functions...............
		public function index(Request $request)
		{
			$page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
			$perPage = 10;
			$sortby = $request->input('sort');
			$sortorder = $request->input('direction');
			$search_for = "name";
			$search = "";
			$paginate = Productcondition::paginate($perPage);
			if ($sortby && $sortorder) {
				$prtconditions = Productcondition::get()->sortByDesc($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				if ($sortorder == 'asc') {
					$prtconditions = Productcondition::get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				}
			} else {
				$prtconditions = Productcondition::orderBy('created_at', 'desc')->get()->toArray();
			}
			$prtconditionrecords = array_slice($prtconditions, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder,'search_for' => $search_for));
			return view('admin.productconditions.index', ['prtconditionrecords' => $prtconditionrecords, 'pagination' => $pagination,'search_for' => $search_for,'search' => $search]);
		}

		public function search(Request $request)
		{	
			$page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
			$perPage = 10;
			$search =$request->input('search');
			$sortby = $request->input('sort');
			$sortorder = $request->input('direction');
			$search_for = (!$request->input('search_for')) ? "name" : $request->input('search_for');
			if ($search) {
				$paginate = Productcondition::where($search_for, 'like', "%$search%")->paginate($perPage);
				$prtconditions = Productcondition::where($search_for, 'like', "%$search%")->orderBy('created_at', 'desc')->get()->toArray();
			} else {
				$search = "";
				$paginate = Productcondition::paginate($perPage);
				$prtconditions = Productcondition::orderBy('created_at', 'desc')->get()->toArray();
				if ($sortorder == 'asc') {
					$prtconditions = Productcondition::get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				} 
			}
			$prtconditionrecords = array_slice($prtconditions, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder, 'search' => $search,'search_for' => $search_for ));
			return view('admin.productconditions.index', compact(['prtconditionrecords', 'search', 'sortby', 'sortorder', 'pagination','search_for']));
		}

		public function addcondition(Request $request)
		{	
			
			return view('admin.productconditions.create');
		}
		
		

		public function storecondition(Request $request)
		{	

			$this->validate(
				$request,
				[
					'productcondition_name' => 'required|min:3|max:40',
					
				],
				[
					'productcondition_name.required' => __('The Productcondition name field is required.'),
					
					'productcondition_name.regex' => __('The Productcondition name may only contain letters, hyphens and spaces.'),
					'productcondition_name.min' => __('The Productcondition name must be at least 3 characters.'),
					'productcondition_name.max' => __('The Productcondition name may not be greater than 40 characters.'),
					'productcondition_name.unique' => __('The Productcondition name has already been taken.'),
				]
			);

			$name = $request->productcondition_name;
			$productcondition_names = Productcondition::where('name', $name)->get();
			foreach($productcondition_names as $productcondition_name){
                if ($productcondition_name) {
                    if ($productcondition_name->name == $name){
            
                            $notification = array(
                                'message' => trans('messages.Productcondition Already Exists'),
                                'alert-type' => 'error',
                            );
                            session()->put('notification', $notification);
                            return redirect()->back();
                        
                    }
                }
			}
			$productcondition = new Productcondition();
			$name = $request->get('productcondition_name');
			$productcondition->name = $name;
			
			if ($productcondition->save()) {
				$notification = array(
					'message' => trans('Product Condition has been saved successfully'),
					'alert-type' => 'success',
				);
			} else {
				$notification = array(
					'message' => trans('Something went wrong'),
					'alert-type' => 'error',
				);
			}
			session()->put('notification', $notification);
			return redirect()->route('productconditions.index');
		}

		public function showSuperCategory()
		{	
			/*$subcategorydetail = Subcategory::find($subcategoryId);
			$categories = Category::where('_id',new \MongoDB\BSON\ObjectID($subcategorydetail->parentCategory))->first();
			$services = Service::where('subCategory',new \MongoDB\BSON\ObjectID($subcategoryId))->get();
	    	return view('admin.subcategories.show', ['subcategorydetail' => $subcategorydetail,'categories' => $categories,'services' => $services]);*/
	    	
	    		    	return view('admin.supercategories.show');
		}
		
		public function editproductcondition($conditionId)
		{	
			$conditiondetails = Productcondition::find($conditionId);
	        return view('admin.productconditions.edit', ['conditiondetails' => $conditiondetails]);
		}

		public function updateproductcondition(Request $request,$conditionId)
		{	

			$this->validate(
				$request,
				[
					'productcondition_name' => 'required|min:3|max:40',
					
				],
				[
					'productcondition_name.required' => __('The Productcondition name field is required.'),
					
					'productcondition_name.regex' => __('The Productcondition name may only contain letters, hyphens and spaces.'),
					'productcondition_name.min' => __('The Productcondition name must be at least 3 characters.'),
					'productcondition_name.max' => __('The Productcondition name may not be greater than 40 characters.'),
					'productcondition_name.unique' => __('The Productcondition name has already been taken.'),
				]
			);

			if($request->productcondition_name != $request->productcondition_hiddenname) {
				$name = $request->productcondition_name;
				$productcondition_name = Productcondition::where('name', $name)->first();
				if ($productcondition_name) {
					$notification = array(
						'message' => __('messages.Productcondition Already exists'),
						'alert-type' => 'error',
					);
					Session()->put('notification', $notification);
					return redirect()->back();
				}

			}

			$productcondition = Productcondition::findOrFail($conditionId);
			$name = $request->get('productcondition_name');
			$productcondition->name = $request->productcondition_name;


			// ends here
			if ($productcondition->save()) {
				$notification = array(
					'message' => trans('Productcondition has been updated successfully'),
					'alert-type' => 'success',
				);
			} else {
				$notification = array(
					'message' => trans('Something went wrong'),
					'alert-type' => 'error',
				);
			}

			session()->put('notification', $notification);
			return redirect()->route('productconditions.index');
		}


		public function deleteproductcondition($conditionId) {
			$productcheck = Product::where('productCondition' , $conditionId)->count();
			if($productcheck != '0') {

				$notification = array(
					'message' => 'Product Condition is using for Some Products',
					'alert-type' => 'error',
				);

				session()->put('notification', $notification);
				return redirect()->back();
			
			} else {

				//Currency::delete($currencyId);

				$remove = Productcondition::find($conditionId);
	        	$remove->delete();

				$notification = array(
					'message' => trans('Product Condition has been Deleted successfully'),
					'alert-type' => 'success',
				);
				session()->put('notification', $notification);

				return redirect()->route('productconditions.index');

			}

	}

	
	//............ Ends here................
}
