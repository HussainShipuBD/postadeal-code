<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Commission;
use App\Models\Setting;
use Illuminate\Support\Str;

class CommissionController extends Controller
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
			$paginate = Commission::paginate($perPage);
			if ($sortby && $sortorder) {
				$commissions = Commission::get()->sortByDesc($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				if ($sortorder == 'asc') {
					$commissions = Commission::get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				}
			} else {
				$commissions = Commission::orderBy('created_at', 'desc')->get()->toArray();
			}
			$commissionrecords = array_slice($commissions, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder,'search_for' => $search_for));
			return view('admin.commissions.index', ['commissionrecords' => $commissionrecords, 'pagination' => $pagination,'search_for' => $search_for,'search' => $search]);
		}

		
		public function addcommission(Request $request)
		{	
			
			return view('admin.commissions.create');
		}
		
		

		public function storecommission(Request $request)
		{	

			$this->validate(
				$request,
				[
					'percentage' => 'required|numeric',
					'minrange' => 'required|numeric',
					'maxrange' => 'required|numeric',
					
				],
				[
					'percentage.required' => __('The Percentage field is required.'),
					'percentage.numeric' => __('The Percentage value should be number'),
					'minrange.required' => __('The Min Range field is required.'),
					'minrange.numeric' => __('The Min Range value should be number'),
					'maxrange.required' => __('The Max Range field is required.'),
					'maxrange.numeric' => __('The Max Range value should be number'),

				]
			);

			$percentage = $request->percentage;
			$minrange = $request->minrange;
			$maxrange = $request->maxrange;

			if($minrange == $maxrange) {
				$notification = array(
                        'message' => trans('Min Range and Max Range will not be Same'),
                        'alert-type' => 'error',
                );
                session()->put('notification', $notification);
                return redirect()->back();
			}

			$commissiondetails = Commission::where('minrange', $minrange)->where('maxrange', $maxrange)->get();
			foreach($commissiondetails as $commissiondetails){
                if ($commissiondetails) {
                    if ($commissiondetails->minrange == $minrange && $commissiondetails->maxrange == $maxrange){
            
                            $notification = array(
                                'message' => trans('Commission Range Already Exists'),
                                'alert-type' => 'error',
                            );
                            session()->put('notification', $notification);
                            return redirect()->back();
                        
                    }
                }
			}
			
			$commission = new Commission();
			
			$commission->percentage = $percentage;
			$commission->minrange = $minrange;
			$commission->maxrange = $maxrange;

			if ($commission->save()) {
				$notification = array(
					'message' => trans('Commission has been saved successfully'),
					'alert-type' => 'success',
				);
			} else {
				$notification = array(
					'message' => trans('Something went wrong'),
					'alert-type' => 'error',
				);
			}
			session()->put('notification', $notification);
			return redirect()->route('commissions.index');
		}

		public function showSuperCategory()
		{	
			/*$subcategorydetail = Subcategory::find($subcategoryId);
			$categories = Category::where('_id',new \MongoDB\BSON\ObjectID($subcategorydetail->parentCategory))->first();
			$services = Service::where('subCategory',new \MongoDB\BSON\ObjectID($subcategoryId))->get();
	    	return view('admin.subcategories.show', ['subcategorydetail' => $subcategorydetail,'categories' => $categories,'services' => $services]);*/
	    	
	    		    	return view('admin.supercategories.show');
		}
		
		public function editcommission($commissionId)
		{	
			$commissiondetails = Commission::find($commissionId);
	        return view('admin.commissions.edit', ['commissiondetails' => $commissiondetails]);
		}

		public function updatecommission(Request $request,$commissionId)
		{	

			$this->validate(
				$request,
				[
					'percentage' => 'required|numeric',
					'minrange' => 'required|numeric',
					'maxrange' => 'required|numeric',
					
				],
				[
					'percentage.required' => __('The Percentage field is required.'),
					'percentage.numeric' => __('The Percentage value should be number'),
					'minrange.required' => __('The Min Range field is required.'),
					'minrange.numeric' => __('The Min Range value should be number'),
					'maxrange.required' => __('The Max Range field is required.'),
					'maxrange.numeric' => __('The Max Range value should be number'),

				]
			);

			$percentage = $request->percentage;
			$minrange = $request->minrange;
			$maxrange = $request->maxrange;

			if($minrange == $maxrange) {
				$notification = array(
                        'message' => trans('Min Range and Max Range will not be Same'),
                        'alert-type' => 'error',
                );
                session()->put('notification', $notification);
                return redirect()->back();
			}

			$commissiondetails = Commission::where('minrange', $minrange)->where('maxrange', $maxrange)->get();
			if($request->minrange != $request->hiddenminrange || $request->maxrange != $request->hiddenmaxrange) {
				foreach($commissiondetails as $commissiondetails){
	                if ($commissiondetails) {
	                	if($commissiondetails)

	                    if ($commissiondetails->minrange == $minrange && $commissiondetails->maxrange == $maxrange){
	            
	                            $notification = array(
	                                'message' => trans('Commission Range Already Exists'),
	                                'alert-type' => 'error',
	                            );
	                            session()->put('notification', $notification);
	                            return redirect()->back();
	                        
	                    }
	                }
				}
			}

			$commission = Commission::findOrFail($commissionId);
			$commission->percentage = $percentage;
			$commission->minrange = $minrange;
			$commission->maxrange = $maxrange;



			// ends here
			if ($commission->save()) {
				$notification = array(
					'message' => trans('Commission has been updated successfully'),
					'alert-type' => 'success',
				);
			} else {
				$notification = array(
					'message' => trans('Something went wrong'),
					'alert-type' => 'error',
				);
			}

			session()->put('notification', $notification);
			return redirect()->route('commissions.index');
		}


		public function deletecommission($commisionId) {
			
				//Currency::delete($currencyId);

				$remove = Commission::find($commisionId);
	        	$remove->delete();

				$notification = array(
					'message' => trans('Commission has been Deleted successfully'),
					'alert-type' => 'success',
				);
				session()->put('notification', $notification);

				return redirect()->route('commissions.index');

			

	}

	
	//............ Ends here................
}
