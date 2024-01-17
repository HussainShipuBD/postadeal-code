<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Location;
use App\Models\Product;
use Illuminate\Support\Str;

class LocationController extends Controller
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
			$paginate = Location::paginate($perPage);
			if ($sortby && $sortorder) {
				$locations = Location::get()->sortByDesc($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				if ($sortorder == 'asc') {
					$locations = Location::get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				}
			} else {
				$locations = Location::orderBy('created_at', 'desc')->get()->toArray();
			}
			$locationrecords = array_slice($locations, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder,'search_for' => $search_for));
			return view('admin.locations.index', ['locationrecords' => $locationrecords, 'pagination' => $pagination,'search_for' => $search_for,'search' => $search]);
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
				$paginate = Location::where($search_for, 'like', "%$search%")->paginate($perPage);
				$locations = Location::where($search_for, 'like', "%$search%")->orderBy('created_at', 'desc')->get()->toArray();
			} else {
				$search = "";
				$paginate = Location::paginate($perPage);
				$locations = Location::orderBy('created_at', 'desc')->get()->toArray();
				if ($sortorder == 'asc') {
					$locations = Location::get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				} 
			}
			$locationrecords = array_slice($locations, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder, 'search' => $search,'search_for' => $search_for ));
			return view('admin.locations.index', compact(['locationrecords', 'search', 'sortby', 'sortorder', 'pagination','search_for']));
		}

		public function addlocation(Request $request)
		{	
			
			return view('admin.locations.create');
		}
		
		

		public function storelocation(Request $request)
		{	

			$this->validate(
				$request,
				[
					'location_name' => 'required|min:3|max:30',
					
				],
				[
					'location_name.required' => __('The Location name field is required.'),
					'location_name.unique' => __('The Location name has already been taken.'),
				]
			);

			$name = $request->location_name;
			$locations_names = Location::where('name', $name)->get();
			foreach($locations_names as $locations_name){
                if ($locations_name) {
                    if ($locations_name->name == $name){
            
                            $notification = array(
                                'message' => trans('Location Already Exists'),
                                'alert-type' => 'error',
                            );
                            session()->put('notification', $notification);
                            return redirect()->back();
                        
                    }
                }
			}
			$location = new Location();
			$name = $request->get('location_name');
			$location->name = $name;
			
			if ($location->save()) {
				$notification = array(
					'message' => trans('Location has been saved successfully'),
					'alert-type' => 'success',
				);
			} else {
				$notification = array(
					'message' => trans('Something went wrong'),
					'alert-type' => 'error',
				);
			}
			session()->put('notification', $notification);
			return redirect()->route('locations.index');
		}

		public function showSuperCategory()
		{	
			/*$subcategorydetail = Subcategory::find($subcategoryId);
			$categories = Category::where('_id',new \MongoDB\BSON\ObjectID($subcategorydetail->parentCategory))->first();
			$services = Service::where('subCategory',new \MongoDB\BSON\ObjectID($subcategoryId))->get();
	    	return view('admin.subcategories.show', ['subcategorydetail' => $subcategorydetail,'categories' => $categories,'services' => $services]);*/
	    	
	    		    	return view('admin.supercategories.show');
		}
		
		public function editlocation($locationId)
		{	
			$locationdetails = Location::find($locationId);
	        return view('admin.locations.edit', ['locationdetails' => $locationdetails]);
		}

		public function updatelocation(Request $request,$locationId)
		{	

			$this->validate(
				$request,
				[
					'location_name' => 'required|min:3|max:30',
					
				],
				[
					'location_name.required' => __('The Location name field is required.'),
					'location_name.unique' => __('The Location name has already been taken.'),
				]
			);

			if($request->location_name != $request->location_hiddenname) {
				$name = $request->location_name;
				$location_name = Location::where('name', $name)->first();
				if ($location_name) {
					$notification = array(
						'message' => __('Location Already exists'),
						'alert-type' => 'error',
					);
					Session()->put('notification', $notification);
					return redirect()->back();
				}

			}

			$location = Location::findOrFail($locationId);
			$name = $request->get('location_name');
			$location->name = $request->location_name;


			// ends here
			if ($location->save()) {
				$notification = array(
					'message' => trans('Location has been updated successfully'),
					'alert-type' => 'success',
				);
			} else {
				$notification = array(
					'message' => trans('Something went wrong'),
					'alert-type' => 'error',
				);
			}

			session()->put('notification', $notification);
			return redirect()->route('locations.index');
		}


		public function deletelocation($locationId) {
			$productcheck = Product::where('locationID' , $locationId)->count();
			if($productcheck != '0') {

				$notification = array(
					'message' => 'Location is using for Some Products',
					'alert-type' => 'error',
				);

				session()->put('notification', $notification);
				return redirect()->back();
			
			} else {

				//Currency::delete($currencyId);

				$remove = Location::find($locationId);
	        	$remove->delete();

				$notification = array(
					'message' => trans('Location has been Deleted successfully'),
					'alert-type' => 'success',
				);
				session()->put('notification', $notification);

				return redirect()->route('locations.index');

			}

	}

	
	//............ Ends here................
}
