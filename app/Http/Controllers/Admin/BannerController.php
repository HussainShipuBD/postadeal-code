<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Banner;
use App\Models\Admin;
//use App\Models\Subcategory;
//use App\Models\Service;
use Illuminate\Support\Str;

class BannerController extends Controller
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
			$paginate = Banner::paginate($perPage);
			if ($sortby && $sortorder) {
				$banners = Banner::get()->sortByDesc($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				if ($sortorder == 'asc') {
					$banners = Banner::get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				}
			} else {
				$banners = Banner::orderBy('created_at', 'desc')->get()->toArray();
			}
			$bannerrecords = array_slice($banners, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder,'search_for' => $search_for));
			return view('admin.banners.index', ['bannerrecords' => $bannerrecords, 'pagination' => $pagination,'search_for' => $search_for,'search' => $search]);
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
				$paginate = Banner::where($search_for, 'like', "%$search%")->paginate($perPage);
				$banners = Banner::where($search_for, 'like', "%$search%")->orderBy('created_at', 'desc')->get()->toArray();
			} else {
				$search = "";
				$paginate = Banner::paginate($perPage);
				$banners = Banner::orderBy('created_at', 'desc')->get()->toArray();
				if ($sortorder == 'asc') {
					$banners = Banner::get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				} 
			}
			$bannerrecords = array_slice($banners, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder, 'search' => $search,'search_for' => $search_for ));
			return view('admin.banners.index', compact(['bannerrecords', 'search', 'sortby', 'sortorder', 'pagination','search_for']));
		}

		public function addbanner(Request $request)
		{	
			return view('admin.banners.create');
		}

		public function storebanner(Request $request)
		{	
			$this->validation($request);
			//echo "<pre>"; print_r($check); die;
			$name = $request->banner_name;
			
			$banner = new Banner();
			$banner->name = $name;
			$banner->url = $request->banner_url;

			//$category->title = $request->get('title');
			//$category->desc = $request->get('desc');
			if ($request->file('banner_image')) {
				$filename = Str::random(6);
				$extension = $request->file('banner_image')->getClientOriginalExtension();
				$fileNameToStore = $filename.'_'.time().'.'.$extension;
				$path = $request->file('banner_image')->storeAs('public/banners',$fileNameToStore);
				$banner->image = $fileNameToStore;
			}
			$banner->status = 1;
			if ($banner->save()) { 
				$notification = array(
					'message' => __('Banner has been added successfully'),
				);
			} else {
				$notification = array(
					'message' => __('Something went wrong'),
				);
			}
			session()->put('notification', $notification);
			return redirect()->route('banner.index');
		}
		public function showCategory()
		{	
			//$categorydetail = Category::find($categoryId);
			//$subcategorydetails = Subcategory::where('parentCategory',new \MongoDB\BSON\ObjectID($categoryId))->get();
	    		//return view('admin.categories.show', ['categorydetail' => $categorydetail,'subcategorydetails' => $subcategorydetails]);
	    	//return view('admin.categories.show');
		}

		public function editbanner($bannerId)
		{	
			$bannerdetails = Banner::find($bannerId);
	        return view('admin.banners.edit', ['bannerdetails' => $bannerdetails]);
		}

		public function updatebanner(Request $request, $bannerId)
		{
			$this->validation($request);
			$banner = Banner::findOrFail($bannerId);
			$banner->name = $request->banner_name;
			$banner->url = $request->banner_url;
			
			if ($request->file('banner_image')) {
				$filename = Str::random(6);
				$extension = $request->file('banner_image')->getClientOriginalExtension();
				$fileNameToStore = $filename.'_'.time().'.'.$extension;
				$path = $request->file('banner_image')->storeAs('public/banners',$fileNameToStore);
				$file_path = storage_path()."/app/public/banners/".$banner->image;
				$this->unlink($file_path); 
				$banner->image = $fileNameToStore;
			}
			
			if ($banner->save()) {
				$notification = array(
					'message' => __('Banner has been updated successfully'),
				);
			} else {
				$notification = array(
					'message' => __('messages.Something went wrong'),
				);
			}

			session()->put('notification', $notification);
			return redirect()->route('banner.index');
		}


		public function deletebanner($bannerId) {


				$remove = Banner::find($bannerId);
	        	$remove->delete();

	        
    		    $file_path = storage_path()."/app/public/banners/".$remove->image;
				$this->unlink($file_path); 


				$notification = array(
					'message' => trans('Banner has been Deleted successfully'),
					'alert-type' => 'success',
				);
				session()->put('notification', $notification);

				return redirect()->route('banner.index');


		}

		public function unlink($file_path)
		{	
			if(file_exists($file_path)){
				unlink($file_path);
			}
		}

		public function validation(Request $request)
		{	
		// ...................Validation starts here...............
			$regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
			$this->validate(
				$request,
				[
					'banner_name' => 'required|min:3|max:30',
					'banner_url' => 'required|regex:'.$regex,
					'banner_image' => 'image|mimes:jpeg,png,jpg|dimensions:min_width=1086,min_height=390',
				],
				[
					'banner_name.required' => __('The Banner name field is required.'),
					'banner_url.required' => __('The url field is required'),
					'banner_url.regex' => __('Enter the valid url'),
					'banner_image.required' => __('The Image field is required'),
					'banner_image.image' => __('The uploaded is not an image'),
					'banner_image.mimes' => __('The image should be in jpeg, png or jpg format'),
				]
			);
		// ...................Ends here...............
		}

	//............ Ends here................
}
