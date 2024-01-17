<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Supercategory;
use App\Models\Product;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
	/*public function __construct()
	{
		$this->middleware('auth');
	}*/
	//............ Sub-Category crud functions...............
		public function subcategories(Request $request)
		{
			$page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
			$perPage = 10;
			$sortby = $request->input('sort');
			$sortorder = $request->input('direction');
			$search_for = "name";
			$search = "";
			$paginate = Subcategory::paginate($perPage);
			if ($sortby && $sortorder) {
				$categories = Subcategory::get()->sortByDesc($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				if ($sortorder == 'asc') {
					$categories = Subcategory::get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				}
			} else {
				$categories = Subcategory::orderBy('created_at', 'desc')->get()->toArray();
			}
			$categoryrecords = array_slice($categories, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder,'search_for' => $search_for));
			//echo "<pre>"; print_r($categoryrecords); die;
			return view('admin.subcategories.index', ['categoryrecords' => $categoryrecords, 'pagination' => $pagination,'search_for' => $search_for,'search' => $search]);
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
				$paginate = Subcategory::where($search_for, 'like', "%$search%")->paginate($perPage);
				$categories = Subcategory::where($search_for, 'like', "%$search%")->orderBy('created_at', 'desc')->get()->toArray();
			} else {
				$search = "";
				$paginate = Subcategory::paginate($perPage);
				$categories = Subcategory::orderBy('created_at', 'desc')->get()->toArray();
				if ($sortorder == 'asc') {
					$categories = Subcategory::get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				} 
			}
			$categoryrecords = array_slice($categories, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder, 'search' => $search,'search_for' => $search_for ));
			return view('admin.subcategories.index', compact(['categoryrecords', 'search', 'sortby', 'sortorder', 'pagination','search_for']));
		}

		public function addsubcategory(Request $request)
		{	
			$maincategories = Category::get();
			//echo "<pre>"; print_r($maincategories); die;
			return view('admin.subcategories.create', ['maincategories' => $maincategories]);
		}

		public function storesubcategory(Request $request)
		{	
			//$this->validation($request);

			$this->validate(
				$request,
				[
					'category_name' => 'required|min:3|max:30',
					'category_parent'=>'required',

				],
				[
					'category_name.required' => __('The sub category name field is required.'),
					'category_parent'=> __('The parent category name field is required.'),
					
					'category_name.regex' => __('The sub category name may only contain letters, hyphens and spaces.'),
					'category_name.min' => __('The sub category name must be at least 3 characters.'),
					'category_name.max' => __('The sub category name may not be greater than 30 characters.'),
				]
			);

			$name = $request->category_name;
			$subcategory_names = Subcategory::where('name', $name)->get();
			foreach($subcategory_names as $subcategory_name){
                if ($subcategory_name) {
                    if ($subcategory_name->name == $name){
                        if ($subcategory_name->parentCategory == $request->category_parent){
                            $notification = array(
                                'message' => trans('Subcategory Already Exists'),
                                'alert-type' => 'error',
                            );
                            session()->put('notification', $notification);
                            return redirect()->back();
                        }
                    }
                }
			}
			$subcategory=Subcategory::updateOrCreate(
				['name' => $name,
				'parentCategory'=>new \MongoDB\BSON\ObjectID($request->category_parent),
				]
			);
			
			
			if ($subcategory->save()) {
				$notification = array(
					'message' => trans('Subcategory has been saved successfully'),
					'alert-type' => 'success',
				);
			} else {
				$notification = array(
					'message' => trans('Something went wrong'),
					'alert-type' => 'error',
				);
			}
			session()->put('notification', $notification);
			return redirect()->route('subcategories.index');
		}

		public function showSubCategory()
		{	
			/*$subcategorydetail = Subcategory::find($subcategoryId);
			$categories = Category::where('_id',new \MongoDB\BSON\ObjectID($subcategorydetail->parentCategory))->first();
			$services = Service::where('subCategory',new \MongoDB\BSON\ObjectID($subcategoryId))->get();*/
	    	return view('admin.subcategories.show');
		}
		
		public function editsubcategory($categoryId)
		{	
			$maincategories = Category::get();
			$categorydetails = Subcategory::find($categoryId);
	        return view('admin.subcategories.edit', ['categorydetails' => $categorydetails,'maincategories' => $maincategories]);
		}

		public function updatesubcategory(Request $request,$categoryId)
		{	
			/*$this->validation($request);
			
			if($category->name != $name){
				$category_names = Subcategory::where('name', $name)->get();
				foreach($category_names as $subCategoryname){
					if ($subCategoryname) {
						if ($subCategoryname->name == $name){
							if ($subCategoryname->parentCategory == $request->category_parent){
								$notification = array(
									'message' => trans('messages.Service Already Exists'),
									'alert-type' => 'error',
								);
								session()->put('notification', $notification);
								return redirect()->back();
							}
						}
					}
				}
			}*/

			$this->validate(
				$request,
				[
					'category_name' => 'required|min:3|max:30',
					'category_parent'=>'required',

				],
				[
					'category_name.required' => __('The sub category name field is required.'),
					'category_parent'=> __('The parent category name field is required.'),
					
					'category_name.regex' => __('The sub category name may only contain letters, hyphens and spaces.'),
					'category_name.min' => __('The sub category name must be at least 3 characters.'),
					'category_name.max' => __('The sub category name may not be greater than 30 characters.'),
				]
			);

			$category = Subcategory::findOrFail($categoryId);
			$name = $request->category_name;

			if($request->category_name != $request->category_hiddenname || $request->category_parent != $request->parentcategory_hiddenid) {
				$name = $request->category_name;
				$category_name = Subcategory::where('name', $name)->get();
				foreach($category_name as $subCategoryname){
					if ($subCategoryname) {
						if ($subCategoryname->name == $name){
							if ($subCategoryname->parentCategory == $request->category_parent){
								$notification = array(
									'message' => trans('Sub Category Already Exists'),
									'alert-type' => 'error',
								);
								session()->put('notification', $notification);
								return redirect()->back();
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

			$category = Subcategory::findOrFail($categoryId);
			$name = $request->get('category_name');
			$category->name = $request->category_name;
			$category->parentCategory = new \MongoDB\BSON\ObjectID($request->category_parent);

			
			// ends here
			if ($category->save()) {
				$notification = array(
					'message' => trans('Subcategory has been updated successfully'),
					'alert-type' => 'success',
				);
			} else {
				$notification = array(
					'message' => trans('Something went wrong'),
					'alert-type' => 'error',
				);
			}

			session()->put('notification', $notification);
			return redirect()->route('subcategories.index');
		}


		public function deletesubcategory($categoryId) {
			$productcheck = Product::where('subCategory' , $categoryId)->count();
			if($productcheck != '0') {

				$notification = array(
					'message' => 'Sub Category is using for Some Products',
					'alert-type' => 'error',
				);

				session()->put('notification', $notification);
				return redirect()->back();
			
			} else {

				//Currency::delete($currencyId);

				$remove = Subcategory::find($categoryId);
	        	$remove->delete();

    		    $removesuper = Supercategory::where('subCategory', new \MongoDB\BSON\ObjectID($categoryId))->delete();
    		   // $removesuper->delete();

				$notification = array(
					'message' => trans('Sub Category has been Deleted successfully'),
					'alert-type' => 'success',
				);
				
				session()->put('notification', $notification);

				return redirect()->route('subcategories.index');

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
