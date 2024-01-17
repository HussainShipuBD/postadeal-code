<?php
use App\Classes\MyClass;
$myClass = new MyClass();
?>

@extends('layouts.head')
@section('title', 'Mylisting')
@section('content')  


<div class="wrapper ovh position-relative">


 <section>

            <div class="container">

                <div class="breadcrumb_content style2 mt-3 ml-0 d-flex justify-content-between ">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ __('messages.Home') }}</a></li>
                        <li class="breadcrumb-item active text-thm" aria-current="page">{{ __('messages.Profile') }}</li>
                    </ol>

                </div>

            <div class="row mt-3  mb-5 detail_common_row">


               @include('site.profile.profilemenu')


                    <div class="col-md-12 col-lg-9">
                        <!-- Our Dashbord -->
                        <section class="our-dashbord dashbord ">
                            <div class="row">
                           
                                <div class="col-lg-12">
                                    <div class="my_dashboard_review">
                                        <div class="row">
                                            <div class="col-xl-6 ml-3 my-3 no-h-padding">
                                                <h3 class="white-nowrap h3">{{ __('messages.Profile Information') }}</h3>
                                            </div>
                                    
                                     <form method="POST" action="{{ route('site.profile.editdetail') }}" enctype="multipart/form-data">
                                        @csrf                                      
                                            <div class="col-xl-12">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <?php if(!empty($userdetail['image']) && isset(($userdetail['image']))) {
                                                                     $imageurl = url('/storage/app/public/users/thumb100/'.$userdetail['image']);
                                                                     $imagename = $userdetail['image']; 
                                                                } else {
                                                                      $imageurl = url('/storage/app/public/users/thumb100/default.png');
                                                                     $imagename = 'default.png'; 
                                                                }
                                                                 ?>  

                                                        <div class="wrap-custom-file">
                                                            <input type="file" name="profilephoto" id="image1"
                                                                accept=".gif, .jpg, .png" />
                                                            <label for="image1" style="background-image: url({{$imageurl}});">
                                                                <span class="profile-img-up">
																<i class="flaticon-download"></i> {{ __('messages.Change Photo') }}
                                                                </span>
                                                            </label>
                                                        </div>
                                                        
                                                    </div>


                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput1">{{ __('messages.Name') }}</label>
                                                            <input type="text" name="name" value="{{$userdetail['name']}}" class="form-control"
                                                                id="formGroupExampleInput1" placeholder="alitfn">
                                                        </div>
                                                                     @error('name')
                                                        <span class="invalid-feedback product-check-error" id="products_image_error" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                             @enderror 
                                                    </div>
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleEmail">{{ __('messages.Email') }}</label>
                                                            <input type="email" name="email" value="{{$userdetail['email']}}" class="form-control"
                                                                id="formGroupExampleEmail"
                                                                placeholder="creativelayers@gmail.com">
                                                                <input type="hidden" value="{{$userdetail['email']}}" name="hiddenemail" id="hiddenemail">
                                                        </div>
                                                                     @error('email')
                                                        <span class="invalid-feedback product-check-error" id="products_image_error" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                             @enderror 

                                                    </div>
                                                    

                                                    <div class="col-xl-12 text-right">
                                                        <div class="my_profile_setting_input">
                                                            <!-- <button class="btn btn1">View Public Profile</button> -->
                                                            <button class="btn btn2">{{ __('messages.Update Profile') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                            <div class="col-xl-12">
                                                <h3 class="white-nowrap fwb change-pass">{{ __('messages.Change password') }}</h3>
                                            </div>
											<div class="col-xl-12">
                                             <form method="POST" action="{{ route('site.profile.editdetailpassword') }}" enctype="multipart/form-data">
                                        @csrf  </div>
                                            <div class="col-xl-12">
<!--                                                 <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleOldPass">Old Password</label>
                                                            <input type="text" class="form-control"
                                                                id="formGroupExampleOldPass" placeholder="alitfn">
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div class="row">
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleNewPass">{{ __('messages.New Password') }}</label>
                                                            <input type="password" name="password" class="form-control"
                                                                id="formGroupExampleNewPass">
                                                        </div>
                                                             @error('password')
                                                        <span class="invalid-feedback product-check-error" id="products_image_error" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                             @enderror                                                         
                                                    </div>
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleConfPass">{{ __('messages.Confirm New Password') }} </label>
                                                            <input type="password" name="password_confirmation" class="form-control"
                                                                id="formGroupExampleConfPass">
                                                        </div>
                                                             @error('password_confirmation')
                                                        <span class="invalid-feedback product-check-error" id="products_image_error" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                             @enderror                                                         
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <!-- <div class="my_profile_setting_input float-left fn-520">
                                                            <button class="btn btn3 btn-dark">Update Profile</button>
                                                        </div> -->
                                                        <div class="my_profile_setting_input float-right fn-520">
                                                            <button class="btn btn2">{{ __('messages.Save') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                          </div>
                                    </div>
                                  
                                   
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

        </section>
        
        </div>

 @endsection


