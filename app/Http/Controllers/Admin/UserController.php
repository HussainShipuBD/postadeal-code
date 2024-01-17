<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Str;

class UserController extends Controller
{
	/*public function __construct()
	{
		$this->middleware('auth');
	} */

		public function approvedusers(Request $request)
		{
			$page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
			$perPage = 10;
			$sortby = $request->input('sort');
			$sortorder = $request->input('direction');
			$search_for = "name";
			$search = "";
			$paginate = User::where('status', 1)->paginate($perPage);
			if ($sortby && $sortorder) {
				$approvedusers = User::where("status", 1)->get()->sortByDesc($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				if ($sortorder == 'asc') {
					$approvedusers = User::where("status", 1)->get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				}
			} else {
				$approvedusers = User::where("status", 1)->orderBy('createdAt', 'desc')->get()->toArray();
			}
			$approvedusersrecords = array_slice($approvedusers, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder,'search_for' => $search_for));
			return view('admin.users.approvedusers', ['approvedusersrecords' => $approvedusersrecords, 'pagination' => $pagination,'search_for' => $search_for,'search' => $search]);
		}

		public function approvedusersearch(Request $request)
		{	
			$page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
			$perPage = 10;
			$search =$request->input('search');
			$sortby = $request->input('sort');
			$sortorder = $request->input('direction');
			$search_for = (!$request->input('search_for')) ? "name" : $request->input('search_for');
			if ($search) {
				$paginate = User::where('status', 1)->where($search_for, 'like', "%$search%")->paginate($perPage);
				$approvedusers = User::where('status', 1)->where($search_for, 'like', "%$search%")->orderBy('createdAt', 'desc')->get()->toArray();
			} else {
				$search = "";
				$paginate = User::where('status', 1)->paginate($perPage);
				$approvedusers = User::where('status', 1)->orderBy('createdAt', 'desc')->get()->toArray();
				if ($sortorder == 'asc') {
					$approvedusers = User::where('status', 1)->get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				} 
			}
			$approvedusersrecords = array_slice($approvedusers, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder, 'search' => $search,'search_for' => $search_for ));
			return view('admin.users.approvedusers', compact(['approvedusersrecords', 'search', 'sortby', 'sortorder', 'pagination','search_for']));
		}

		public function pendingusers(Request $request)
		{
			$page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
			$perPage = 10;
			$sortby = $request->input('sort');
			$sortorder = $request->input('direction');
			$search_for = "name";
			$search = "";
			$paginate = User::where('status', 0)->paginate($perPage);
			if ($sortby && $sortorder) {
				$pendingusers = User::where('status', 0)->get()->sortByDesc($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				if ($sortorder == 'asc') {
					$pendingusers = User::where('status', 0)->get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				}
			} else {
				$pendingusers = User::where('status', 0)->orderBy('createdAt', 'desc')->get()->toArray();
			}
			$pendingusersrecords = array_slice($pendingusers, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder,'search_for' => $search_for));
			return view('admin.users.pendingusers', ['pendingusersrecords' => $pendingusersrecords, 'pagination' => $pagination,'search_for' => $search_for,'search' => $search]);
		}

		public function pendingusersearch(Request $request)
		{	
			$page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
			$perPage = 10;
			$search =$request->input('search');
			$sortby = $request->input('sort');
			$sortorder = $request->input('direction');
			$search_for = (!$request->input('search_for')) ? "name" : $request->input('search_for');
			if ($search) {
				$paginate = User::where('status', 0)->where($search_for, 'like', "%$search%")->paginate($perPage);
				$pendingusers = User::where('status', 0)->where($search_for, 'like', "%$search%")->orderBy('createdAt', 'desc')->get()->toArray();
			} else {
				$search = "";
				$paginate = User::where('status', 0)->paginate($perPage);
				$pendingusers = User::where('status', 0)->orderBy('createdAt', 'desc')->get()->toArray();
				if ($sortorder == 'asc') {
					$pendingusers = User::where('status', 0)->get()->sortBy($sortby, SORT_NATURAL | SORT_FLAG_CASE)->toArray();
				} 
			}
			$pendingusersrecords = array_slice($pendingusers, $perPage * ($page - 1), $perPage);
			$pagination = $paginate->appends(array('sort' => $sortby, 'direction' => $sortorder, 'search' => $search,'search_for' => $search_for ));
			return view('admin.users.pendingusers', compact(['pendingusersrecords', 'search', 'sortby', 'sortorder', 'pagination','search_for']));
		}


		
		public function edituser($userId)
		{	
			$userdetails = User::find($userId);
	        return view('admin.users.edit', ['userdetails' => $userdetails, 'page' => $_GET['page']]);
		}

		public function updateuser(Request $request,$userId)
		{	


			$this->validate(
                $request,
                [
                    'name' => 'required|min:3|max:30',
                    'email' => 'required|email',
                ],
                [
                    'name.required' => __('Please enter user name.'),
                    'name.min' => __('The name must be at least 3 characters.'),
                    'name.max' => __('The name may not be greater than 30 characters.'),
                    'email.required' => __('Please enter user E-mail.'),
                ]
            );

			if($request->email != $request->hiddenemail) {
				$email = $request->email;
				$emailExist = User::where('email', $email)->first();
				if ($emailExist) {
					$notification = array(
						'message' => __('messages.Email Already exists'),
						'alert-type' => 'error',
					);
					Session()->put('notification', $notification);
					return redirect()->back();
				}

			}

			$userData = User::findOrFail($userId);
			$userData->name = $request->name;
			$userData->email = $request->email;



			// ends here
			if ($userData->save()) {
				$notification = array(
					'message' => trans('User Details has been updated successfully'),
				);
			} else {
				$notification = array(
					'message' => trans('Something went wrong'),
				);
			}

			session()->put('notification', $notification);

			if($request->page == "approved") {
				return redirect()->route('users.approved');
			} else {
				return redirect()->route('users.pending');

			}



		}


		public function changestatus($userId) {
			

			$status = trim($_GET['userStatus']);
			$userData = User::findOrFail($userId);
			if($status == "0") {
				$userData->status = 0;
				Product::where('userId',$userId)->update(['status'=>'0']);

			} else {
				$userData->status = 1;
				Product::where('userId',$userId)->update(['status'=>'1']);
			}

			$itemData = Product::where('userId',$userId)->get();
			

			// ends here
			if ($userData->save()) {
				
				$notification = array(
					'message' => trans('User Status has been updated successfully'),
				);
			} else {
				$notification = array(
					'message' => trans('Something went wrong'),
				);
			}

			session()->put('notification', $notification);

			return redirect()->back();


	}

	
	//............ Ends here................
}
