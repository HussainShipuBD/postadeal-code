<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Supercategory;
use App\Models\Product;
//use App\Models\Pricing;
use Illuminate\Support\Str;

class SuperCategoryController extends Controller
{
	/*public function __construct()
	{
		$this->middleware('auth');
	} */


		public function supercategories(Request $request)
		{
			$page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
			$perPage = 10;
			$sortby = $request->input('sort');
			$sortorder = $request->input('direction');
			$search_for = "name";
			$search = "";
			$paginate = Supercategory::paginate($perPage);
			if ($sortby && $sortorder) {
				$categories = Supercategory::get()->sortByDesc($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				if ($sortorder == 'asc') {
					$categories = Supercategory::get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				}
			} else {
				$categories = Supercategory::orderBy('created_at', 'desc')->get()->toArray();
			}
			$categoryrecords = array_slice($categories, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder,'search_for' => $search_for));
			return view('admin.supercategories.index', ['categoryrecords' => $categoryrecords, 'pagination' => $pagination,'search_for' => $search_for,'search' => $search]);
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
				$paginate = Supercategory::where($search_for, 'like', "%$search%")->paginate($perPage);
				$categories = Supercategory::where($search_for, 'like', "%$search%")->orderBy('created_at', 'desc')->get()->toArray();
			} else {
				$search = "";
				$paginate = Supercategory::paginate($perPage);
				$categories = Supercategory::orderBy('created_at', 'desc')->get()->toArray();
				if ($sortorder == 'asc') {
					$categories = Supercategory::get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				} 
			}
			$categoryrecords = array_slice($categories, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder, 'search' => $search,'search_for' => $search_for ));
			return view('admin.supercategories.index', compact(['categoryrecords', 'search', 'sortby', 'sortorder', 'pagination','search_for']));
		}

		public function addsupercategory(Request $request)
		{	
			$maincategories = Category::get();
			//echo "<pre>"; print_r($maincategories); die;
			return view('admin.supercategories.create', ['maincategories' => $maincategories]);
		}
		
		public function ajaxsubcategories(Request $request)
		{	
		if($request->ajax()){
			//$price_required = false;
			$maincategory = Category::where("_id",$request->category_id)->first();
			$subcategories = Subcategory::where("parentCategory",new \MongoDB\BSON\ObjectID($request->category_id))->get();
			
			$data = view('admin.ajax.subcategories-select',compact('maincategory','subcategories'))->render();
			return response()->json(['html'=>$data]);
		}
		}

		public function storesupercategory(Request $request)
		{	

			$this->validate(
				$request,
				[
					'category_name' => 'required|min:3|max:40',
					'main_category_type'=>'required',
					'sub_category_type'=>'required',

				],
				[
					'category_name.required' => __('The super category name field is required.'),
					'main_category_type'=> __('The parent category name field is required.'),
					'sub_category_type'=> __('The sub category name field is required.'),					
					'category_name.regex' => __('The super category name may only contain letters, hyphens and spaces.'),
					'category_name.min' => __('The super category name must be at least 3 characters.'),
					'category_name.max' => __('The super category name may not be greater than 40 characters.'),
				]
			);

			$name = $request->category_name;
			$supercategory_names = Supercategory::where('name', $name)->get();
			foreach($supercategory_names as $supercategory_name){
                if ($supercategory_name) {
                    if ($supercategory_name->name == $name){
                        if ($supercategory_name->parentCategory == $request->main_category_type && $supercategory_name->subCategory == $request->sub_category_type){
                            $notification = array(
                                'message' => trans('Supercategory Already Exists'),
                                'alert-type' => 'error',
                            );
                            session()->put('notification', $notification);
                            return redirect()->back();
                        }
                    }
                }
			}
			$supercategory=Supercategory::updateOrCreate(
				['name' => $name,
				'parentCategory'=>new \MongoDB\BSON\ObjectID($request->main_category_type),
				'subCategory'=>new \MongoDB\BSON\ObjectID($request->sub_category_type),
				]
			);
			
			
			if ($supercategory->save()) {
				$notification = array(
					'message' => trans('Supercategory has been saved successfully'),
					'alert-type' => 'success',
				);
			} else {
				$notification = array(
					'message' => trans('Something went wrong'),
					'alert-type' => 'error',
				);
			}
			session()->put('notification', $notification);
			return redirect()->route('supercategories.index');
		}

		public function showSuperCategory()
		{	
			/*$subcategorydetail = Subcategory::find($subcategoryId);
			$categories = Category::where('_id',new \MongoDB\BSON\ObjectID($subcategorydetail->parentCategory))->first();
			$services = Service::where('subCategory',new \MongoDB\BSON\ObjectID($subcategoryId))->get();
	    	return view('admin.subcategories.show', ['subcategorydetail' => $subcategorydetail,'categories' => $categories,'services' => $services]);*/
	    	
	    		    	return view('admin.supercategories.show');
		}
		
		public function editsupercategory($categoryId)
		{	

			$subcategorydetails = Subcategory::groupBy('parentCategory')->get();
			foreach($subcategorydetails as $subCategoryname){
				$maincategories[] = Category::where('_id', $subCategoryname->parentCategory)->                         get();

			}


			$categorydetails = Supercategory::find($categoryId);

			$subcategories = Subcategory::find($categorydetails->subCategory);

			$subcategoryList = Subcategory::where('parentCategory', $categorydetails->parentCategory)->get();

	        return view('admin.supercategories.edit', ['categorydetails' => $categorydetails,'maincategories' => $maincategories, 'subcategories' => $subcategories, 'subcategoryList' => $subcategoryList]);
		}

		public function updatesupercategory(Request $request,$categoryId)
		{	

			$this->validate(
				$request,
				[
					'supercategory_name' => 'required|min:3|max:40',
					'main_category_type'=>'required',
					'sub_category_type'=>'required',

				],
				[
					'supercategory_name.required' => __('The super category name field is required.'),
					'main_category_type'=> __('The parent category name field is required.'),
					'sub_category_type'=> __('The sub category name field is required.'),					
					'supercategory_name.regex' => __('The super category name may only contain letters, hyphens and spaces.'),
					'supercategory_name.min' => __('The super category name must be at least 3 characters.'),
					'supercategory_name.max' => __('The super category name may not be greater than 40 characters.'),
				]
			);

			$category = Supercategory::findOrFail($categoryId);
			$name = $request->supercategory_name;

			if($request->supercategory_name != $request->supercategory_hiddenname  || $request->main_category_type != $request->parentcategory_hiddenid || $request->sub_category_type != $request->subcategory_hiddenid) {
				$name = $request->supercategory_name;
				$category_name = Supercategory::where('name', $name)->get();
				foreach($category_name as $subCategoryname){
					if ($subCategoryname) {
						if ($subCategoryname->name == $name){
							if ($subCategoryname->parentCategory == $request->main_category_type){
								if($subCategoryname->subCategory == $request->sub_category_type) {
									$notification = array(
										'message' => trans('Super Category Already Exists'),
										'alert-type' => 'error',
									);
									session()->put('notification', $notification);
									return redirect()->back();
								}
							}
						}
					}
				}

			}

			/*Subcategory::updateOrCreate([
				'_id' => $category,
				],['parentCategory'=>new \MongoDB\BSON\ObjectID($request->category_parent),
				'name' => $name
			]);*/

			$category = Supercategory::findOrFail($categoryId);
			$name = $request->get('category_name');
			$category->name = $request->supercategory_name;
			$category->parentCategory = new \MongoDB\BSON\ObjectID($request->main_category_type);
			$category->subCategory = new \MongoDB\BSON\ObjectID($request->sub_category_type);


			
			// ends here
			if ($category->save()) {
				$notification = array(
					'message' => trans('Supercategory has been updated successfully'),
					'alert-type' => 'success',
				);
			} else {
				$notification = array(
					'message' => trans('Something went wrong'),
					'alert-type' => 'error',
				);
			}

			session()->put('notification', $notification);
			return redirect()->route('supercategories.index');
		}


		public function deletesupercategory($categoryId) {
			$productcheck = Product::where('superCategory' , $categoryId)->count();
			if($productcheck != '0') {

				$notification = array(
					'message' => 'Super Category is using for Some Products',
					'alert-type' => 'error',
				);

				session()->put('notification', $notification);
				return redirect()->back();
			
			} else {

				//Currency::delete($currencyId);

				$remove = Supercategory::find($categoryId);
	        	$remove->delete();


				$notification = array(
					'message' => trans('Super Category has been Deleted successfully'),
					'alert-type' => 'success',
				);

				session()->put('notification', $notification);


				return redirect()->route('supercategories.index');

			}

		}


		public function unlink($file_path)
		{	
			if(file_exists($file_path)){
				unlink($file_path);
			}
		}
		public function validation(Request $request)
		{	
			$this->validate(
				$request,
				[
					'category_name' => 'required|min:3|max:30|',
					'category_parent'=>'required',
					'category_image' => 'image|mimes:jpeg,png,jpg|max:2000',
					'category_status' => 'required',
				],
				[
					'category_name.required' => trans('messages.The category name field is required.'),
					'category_parent'=> trans('messages.The parent category name field is required.'),
					'category_name.regex' => trans('messages.The category name may only contain letters, hyphens and spaces.'),
					'category_name.min' => trans('messages.The category name must be at least 3 characters.'),
					'category_name.max' => trans('messages.The category name may not be greater than 30 characters.'),
					'category_name.unique' => trans('messages.The category name has already been taken.'),
				]
			);
		}
	//............ Ends here................
}
