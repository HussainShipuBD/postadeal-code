<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Help;
use Illuminate\Support\Str;

class HelpController extends Controller
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
			$paginate = Help::paginate($perPage);
			if ($sortby && $sortorder) {
				$helppages = Help::get()->sortByDesc($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				if ($sortorder == 'asc') {
					$helppages = Help::get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				}
			} else {
				$helppages = Help::orderBy('created_at', 'desc')->get()->toArray();
			}
			$helppagesrecords = array_slice($helppages, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder,'search_for' => $search_for));
			return view('admin.helps.index', ['helppagesrecords' => $helppagesrecords, 'pagination' => $pagination,'search_for' => $search_for,'search' => $search]);
		}

		

		public function addhelp(Request $request)
		{	
			
			return view('admin.helps.create');
		}
		
		

		public function storehelp(Request $request)
		{	

			$this->validation($request);
			
			$name = $request->title;

               /* if ($name == 'Privacy Policy' || $name == 'Terms And Conditions') {
                    $notification = array(
                        'message' => __('messages.Terms and policies cannot be saved in help'),
                        'alert-type' => 'error',
                    );
                    session()->put('notification', $notification);
                    return redirect()->back();
                } */
            
            $help_names = Help::where('name', $name)->get();
            foreach($help_names as $help_name){
                if ($help_name) {
                    if ($help_name->name == $name){
                        if ($help_name->type == $request->type){
                            $notification = array(
                                'message' => trans('Help Content Already exists'),
                                'alert-type' => 'error',
                            );
                            session()->put('notification', $notification);
                            return redirect()->route('helps.index');
                        }
                    }
                }
            }
            $help = new Help();
            $help->name = $name;
            $help->description = $request->description;
            if ($help->save()) {
                $notification = array(
                    'message' => __('Help has been created successfully'),
                    'alert-type' => 'success',
                );
            } else {
                $notification = array(
                    'message' => __('Something went wrong'),
                    'alert-type' => 'error',
                );
            }
            session()->put('notification', $notification);
            if( $name == 'Privacy Policy' || $name == 'Terms And Conditions' ){
                return redirect()->back();
            }
            else{
                return redirect()->route('helps.index');
            }
		}

		
		public function edithelp($helpId)
		{	
			$helpdetails = Help::find($helpId);
	        return view('admin.helps.edit', ['helpdetails' => $helpdetails]);
		}

		public function updatehelp(Request $request,$helpId)
		{	

			$this->validation($request);

			$help = Help::find($helpId);
            $name = $request->title;
            if($help->name != $name){
                $help_names = Help::where('name', $name)->get();
                foreach($help_names as $help_name){
                    if ($help_name) {
                        if ($help_name->name == $name){
                                $notification = array(
                                    'message' => trans('Help Content Already exists'),
                                    'alert-type' => 'error',
                                );
                                session()->put('notification', $notification);
                				return redirect()->back();
                            
                        }
                    }
                }
            }
            $name = $request->title;
           
           
			$helpdata = Help::findOrFail($helpId);
			$helpdata->name = $request->title;
			$helpdata->description = $request->description;


			// ends here
			if ($helpdata->save()) {
				$notification = array(
					'message' => trans('Help Page has been updated successfully'),
					'alert-type' => 'success',
				);
			} else {
				$notification = array(
					'message' => trans('Something went wrong'),
					'alert-type' => 'error',
				);
			}

			if( $name == 'Privacy Policy' || $name == 'Terms And Conditions' ){
                session()->put('notification', $notification);
                return redirect()->back();
            }
            else{
                session()->put('notification', $notification);
                return redirect()->route('helps.index');
            }
		}


		public function deletehelp($helpId) {
			
				//Currency::delete($currencyId);

				$remove = Help::find($helpId);
	        	$remove->delete();

				$notification = array(
					'message' => trans('Help Page has been Deleted successfully'),
					'alert-type' => 'success',
				);
				session()->put('notification', $notification);

				return redirect()->route('helps.index');

			

	}

	public function validation(Request $request)
	{	
		// ...................Validation starts here...............
            $this->validate(
                $request,
                [
                    'title' => 'required|min:3|max:40',
                    'description' => 'required'
                ],
                [
                    'title.required' => __('The title is required.'),
                    'title.min' => __('The title must be at least 3 characters.'),
					'title.max' => __('The title may not be greater than 40 characters.'),
                    'description.required' => __('The description is required'),
                    'description.min' => __('The description must be at least 3 characters.')
                ]
            );
        // ...................Ends here...............
	}

	
	//............ Ends here................
}
