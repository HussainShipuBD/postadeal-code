<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Product;
use App\Models\Review;
use App\Classes\MyClass;
use Session;
use Image;
use Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mylisting()
    {
    $myClass = new MyClass();


    $userId = Auth::user()->_id;

    $userdetails = User::where("status", 1)->where("_id", new \MongoDB\BSON\ObjectID($userId))->get()->toArray();

    $itemdetail = Product::where("status", 1)->where("userId", $userId)->orderBy('createdAt', 'desc')->paginate(10);
    $item = $myClass->get_items($itemdetail);

    $reviewdetail = Review::where('sellerId', new \MongoDB\BSON\ObjectID($userId))->orderBy('created_at', 'asc')->get()->toArray();

    $reviewratingtotal = 0;
    $reviewdetailcount = 0;
    if(!empty($reviewdetail))
    {
    $reviewdetailcount = count($reviewdetail);    
    foreach($reviewdetail as $reviewdetailtotal)
     {
      $reviewrating += $reviewdetailtotal['rating']; 
     }
    $reviewratingtotal = $reviewrating / $reviewdetailcount;        
    }


    return view('user.mylisting', ['itemdetails' => $item, 'userdetail' => $userdetails, 'userId' => $userId, 'reviewratingtotal' => $reviewratingtotal, 'reviewdetailcount' => $reviewdetailcount, ]);

    }



    public function loadMoreitemlisting(Request $request)
    {
        $myClass = new MyClass();
        $userId = Auth::user()->_id;
        $itemdetails = Product::where("status", 1)->where("userId", $userId)->orderBy('createdAt', 'desc')->paginate(10);
        $item = $myClass->get_items($itemdetails);
        $items = '';
        if ($request->ajax()) {
            foreach ($item as $itemdetail) {

        $items.='<div class="feat_property list favorite_page position-relative ">
                                                <a href="'.url("/product/show").'/'.$itemdetail['itemid'].'" class="overlaylink"></a>
                                                <div class="thumb">
                                                    <img class="img-whp" src="'.url("/storage/app/public/products/thumb300").'/'.$itemdetail['itemimage'].'"  alt="'.$itemdetail['itemtitle'].'">
                                                    <div class="thmb_cntnt">
                                                        <ul class="tag mb0">
                                                            <li class="list-inline-item dn"></li>

                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="details">
                                                    <div class="tc_content">
                                                        <p class="txt-truncate sec-color"> '.$itemdetail['itemdate'].'</p>
                                                        <div class="text-gray-color mb-1">
                                                            <span>ID :</span>
                                                            <span class="txt-truncate ">'.$itemdetail['itemid'].'</span>
                                                        </div>
                                                        <h4>'.$itemdetail['itemtitle'].'</h4>
                                                        <a class="fp_price text-thm" href="#">'.$itemdetail['itemcurrency'].' '.$itemdetail['itemprice'].'</a>
                                                    </div>
                                                </div>
                                                <ul class="view_edit_delete_list mb0 mt35">

                                                    <li class="list-inline-item" data-toggle="tooltip"
                                                        data-placement="top" title="Edit">
                                                        <a href="./addproduct.html">
                                                            <span class="flaticon-writing"></span> </a>
                                                    </li>
                                                </ul>
                                            </div>';            

                          }
            return $items;
        }
        return view('user.mylisting');
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editprofile()
    {

             if(!Auth::user())
             {
                return redirect()->route('main.index');
             }  

    $myClass = new MyClass();


    $userId = Auth::user()->_id;

    $userdetails = User::where("status", 1)->where("_id", new \MongoDB\BSON\ObjectID($userId))->get()->toArray();


    $reviewdetail = Review::where('sellerId', new \MongoDB\BSON\ObjectID($userId))->orderBy('created_at', 'asc')->get()->toArray();

    $reviewratingtotal = 0;
    $reviewdetailcount = 0;
    if(!empty($reviewdetail))
    {
    $reviewdetailcount = count($reviewdetail);    
    foreach($reviewdetail as $reviewdetailtotal)
     {
      $reviewrating += $reviewdetailtotal['rating']; 
     }
    $reviewratingtotal = $reviewrating / $reviewdetailcount;        
    }

//    print_r($userdetails);die;

    return view('user.editprofile', [ 'userdetail' => $userdetails, 'userId' => $userId, 'reviewratingtotal' => $reviewratingtotal, 'reviewdetailcount' => $reviewdetailcount, ]);

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editdetail(Request $request)
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

            $userId = Auth::user()->_id;

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


            if ($request->file('profilephoto')) {

                $image = $request->file('profilephoto');

                $filename = Str::random(6);
                $extension = $request->file('profilephoto')->getClientOriginalExtension();
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                $path = $request->file('profilephoto')->storeAs('public/users/original',$fileNameToStore);

               // $realpath = storage_path()."/app/public/users/original/".$fileNameToStore;
                $thumbnailFilePath = storage_path()."/app/public/users/thumb100/".$fileNameToStore;

                $img = Image::make($image->path());

                $img->resize(300, 300, function ($const) {
                    $const->aspectRatio();
                })->save($thumbnailFilePath);


                $userData->image = $fileNameToStore;
            }



            // ends here
            if ($userData->save()) {
                $notification = array(
                    'message' => __('messages.User Details has been updated successfully'),
                );
            } else {
                $notification = array(
                    'message' => __('messages.Something went wrong'),
                );
            }

            session()->put('notification', $notification);

            return redirect()->route('user.editprofile');
    }


 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editdetailpassword(Request $request)
    {

             $this->validate(
                $request,
                [
                    'password' => 'required|min:6|required_with:password_confirmation|same:password_confirmation',
                    'password_confirmation' => 'required|min:6'
                ],
                [
                    'password.required' => __('messages.Please enter the password.'),
                    'password.min' => __('messages.The name must be at least 6 characters.'),
                    'password_confirmation.required' => __('messages.Please enter the confirm password.')
                ]
            );

            $userId = Auth::user()->_id;


            $userData = User::findOrFail($userId);
            $userData->password = Hash::make($request->password);

            // ends here
            if ($userData->save()) {
                Auth::logout();
                $notification = array(
                    'message' => __('messages.Password updated successfully. Please Login'),
                );

                session()->put('notification', $notification);

                 return redirect()->route('main.index');



            } else {
                $notification = array(
                    'message' => __('messages.Something went wrong'),
                );

                session()->put('notification', $notification);

                return redirect()->route('user.editprofile');
            }
     }       


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
