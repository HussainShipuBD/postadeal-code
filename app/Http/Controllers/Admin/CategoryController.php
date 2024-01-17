<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Supercategory;
use Illuminate\Support\Str;
use Session;
use Auth;


class CategoryController extends Controller
{ 
	/*public function __construct()
	{
		$this->middleware('auth');
	}*/

	//............ Category crud functions................
		public function index(Request $request, $search = null)
		{
			$page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
			$perPage = 10;
			$sortby = $request->input('sort');
			$sortorder = $request->input('direction');
			$search_for = "name";
			$search = "";
			$paginate = Category::paginate($perPage);
			if ($sortby && $sortorder) {
				$categories = Category::get()->sortByDesc($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				if ($sortorder == 'asc') {
					$categories = Category::get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				}
			} else {
				$categories = Category::orderBy('created_at', 'desc')->get()->toArray();
			}
			$categoryrecords = array_slice($categories, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder,'search_for' => $search_for));
			return view('admin.categories.index', ['categoryrecords' => $categoryrecords, 'pagination' => $pagination,'search_for' => $search_for,'search' => $search])->with('successMsg','You must stay away from this link.');
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
				$paginate = Category::where($search_for, 'like', "%$search%")->paginate($perPage);
				$categories = Category::where($search_for, 'like', "%$search%")->orderBy('created_at', 'desc')->get()->toArray();
			} else {
				$search = "";
				$paginate = Category::paginate($perPage);
				$categories = Category::orderBy('created_at', 'desc')->get()->toArray();
				if ($sortorder == 'asc') {
					$categories = Category::get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				} 
			}
			$categoryrecords = array_slice($categories, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder, 'search' => $search,'search_for' => $search_for ));
			return view('admin.categories.index', compact(['categoryrecords', 'search', 'sortby', 'sortorder', 'pagination','search_for']));
		}

		public function addcategory(Request $request)
		{	
			return view('admin.categories.create');
		}

		public function storecategory(Request $request)
		{	
			$this->validate(
				$request,
				[
					'category_name' => 'required|min:3|max:30',					
					'category_image' => 'image|mimes:jpeg,png,jpg',
					
				],
				[
					'category_name.required' => __('The category name field is required.'),
					
					'category_name.regex' => __('The category name may only contain letters, hyphens and spaces.'),
					'category_name.min' => __('The category name must be at least 3 characters.'),
					'category_name.max' => __('The category name may not be greater than 30 characters.'),
					'category_name.unique' => __('The category name has already been taken.'),
				]
			);
						//echo "<pre>"; print_r($request); die;
			$name = $request->category_name;
			$category_name = Category::where('name', $name)->first();
			if ($category_name) {
				$notification = array(
					'message' => __('Category Already exists'),
					'alert-type' => 'error',
				);
				session()->put('notification', $notification);
				return redirect()->back();
			}
			$category = new Category();
			$name = $request->get('category_name');
			$category->name = $name;
			//$category->title = $request->get('title');
			//$category->desc = $request->get('desc');
			if ($request->file('category_image')) {
				$filename = Str::random(6);
				$extension = $request->file('category_image')->getClientOriginalExtension();
				$fileNameToStore = $filename.'_'.time().'.'.$extension;
				$path = $request->file('category_image')->storeAs('public/categories',$fileNameToStore);
				$category->image = $fileNameToStore;
			}
			if ($category->save()) { 
				$notification = array(
					'message' => __('Category has been saved successfully'),
					'alert-type' => 'success',
				);
			} else {
				$notification = array(
					'message' => __('Something went wrong'),
					'alert-type' => 'error',
				);
			}
			session()->put('notification', $notification);
			return redirect()->route('category.index');
		}

		public function showCategory()
		{	
			//$categorydetail = Category::find($categoryId);
			//$subcategorydetails = Subcategory::where('parentCategory',new \MongoDB\BSON\ObjectID($categoryId))->get();
	    		//return view('admin.categories.show', ['categorydetail' => $categorydetail,'subcategorydetails' => $subcategorydetails]);
	    	//return view('admin.categories.show');
		}

		public function editcategory($categoryId)
		{	
			$categorydetails = Category::find($categoryId);
	        return view('admin.categories.edit', ['categorydetails' => $categorydetails]);
		}

		public function updatecategory(Request $request, $categoryId)
		{
			$this->validate(
				$request,
				[
					'category_name' => 'required|min:3|max:30',					
					'category_image' => 'image|mimes:jpeg,png,jpg',
					
				],
				[
					'category_name.required' => __('The category name field is required.'),
					
					'category_name.regex' => __('The category name may only contain letters, hyphens and spaces.'),
					'category_name.min' => __('The category name must be at least 3 characters.'),
					'category_name.max' => __('The category name may not be greater than 30 characters.'),
					'category_name.unique' => __('The category name has already been taken.'),
				]
			);

			if($request->category_name != $request->category_hiddenname) {
				$name = $request->category_name;
				$category_name = Category::where('name', $name)->first();
				if ($category_name) {
					$notification = array(
						'message' => __('Category Already exists'),
						'alert-type' => 'error',
					);
					Session()->put('notification', $notification);
					return redirect()->back();
				}

			}

			$category = Category::findOrFail($categoryId);
			$name = $request->get('category_name');
			$category->name = $request->category_name;
			
			if ($request->file('category_image')) {
				$filename = Str::random(6);
				$extension = $request->file('category_image')->getClientOriginalExtension();
				$fileNameToStore = $filename.'_'.time().'.'.$extension;
				$path = $request->file('category_image')->storeAs('public/categories',$fileNameToStore);
				$file_path = storage_path()."/app/public/categories/".$category->image;
				$this->unlink($file_path); 
				$category->image = $fileNameToStore;
			}
			
			if ($category->save()) {
				$notification = array(
					'message' => __('Category has been updated successfully'),
					'alert-type' => 'success',
				);
			} else {
				$notification = array(
					'message' => __('Something went wrong'),
					'alert-type' => 'error',
				);
			}
			session()->put('notification', $notification);
			           // return redirect()->route('category.index')->with('success','Updated successfully');

					return redirect()->route('category.index')->with('successMsg','You must stay away from this link.');




			//return redirect()->route('category.index');
		}


		public function deletecategory($categoryId) {
			$productcheck = Product::where('mainCategory' , $categoryId)->count();
			if($productcheck != '0') {

				$notification = array(
					'message' => 'Category is using for Some Products',
					'alert-type' => 'error',
				);

				session()->put('notification', $notification);
				return redirect()->back();
			
			} else {

				//Currency::delete($currencyId);

				$remove = Category::find($categoryId);
	        	$remove->delete();

	        	$removesub = Subcategory::where('parentCategory', new \MongoDB\BSON\ObjectID($categoryId))->delete();

    		    $removesuper = Supercategory::where('parentCategory', new \MongoDB\BSON\ObjectID($categoryId))->delete();


    		    $file_path = storage_path()."/app/public/categories/".$remove->image;
				$this->unlink($file_path); 


				$notification = array(
					'message' => trans('Category has been Deleted successfully'),
					'alert-type' => 'success',
				);

				session()->put('notification', $notification);


				return redirect()->route('category.index');

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
					'category_name' => 'required|min:3|max:30|unique:categories,name',
					'category_type' => 'required',
					'category_image' => 'image|mimes:jpeg,png,jpg|max:2000',
					'category_status' => 'required',
					'category_feature' => 'required',
				],
				[
					'category_name.required' => __('messages.The category name field is required.'),
					'category_name.regex' => __('messages.The category name may only contain letters, hyphens and spaces.'),
					'category_name.min' => __('messages.The category name must be at least 3 characters.'),
					'category_name.max' => __('messages.The category name may not be greater than 30 characters.'),
					'category_name.unique' => __('messages.The category name has already been taken.'),
				]
			);
			
		}
	//............ Ends here................
}
