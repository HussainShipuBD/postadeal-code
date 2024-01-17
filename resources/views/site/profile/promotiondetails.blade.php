<?php
use App\Classes\MyClass;
$myClass = new MyClass();
?>


@extends('layouts.head')
@section('title', 'Home')
@section('content')  


<div class="wrapper ovh position-relative">


        <section>

            <div class="container">

                <div class="breadcrumb_content style2 mt-3  ml-0
                 d-flex justify-content-between ">

                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <?php if($page == "activepromotions") { ?>
                            <li class="breadcrumb-item  text-thm" aria-current="page"><a
                                href="{{ route('site.profile.activepromotions')}}">Promotions</a></li>
                        <?php } else { ?>
                            <li class="breadcrumb-item  text-thm" aria-current="page"><a
                                href="{{ route('site.profile.expirepromotions')}}">Promotions</a></li>
                        <?php } ?>
                        <li class="breadcrumb-item active text-thm" aria-current="page">Promotions Detail</li>
                    </ol>

                    <div class="back-opt d-flex justify-content-end p-2">
                    <?php if($page == "activepromotions") { ?>
                        <a href="{{ route('site.profile.activepromotions')}}">
                            <button class="btn btn-thm2 d-flex align-items-center backtomove_cont">
                                <i class="flaticon flaticon-back  fz18 mr-1"></i>
                                <span> Back </span>
                            </button>
                        </a>
                    <?php } else { ?>
                        <a href="{{ route('site.profile.expirepromotions')}}">
                            <button class="btn btn-thm2 d-flex align-items-center backtomove_cont">
                                <i class="flaticon flaticon-back  fz18 mr-1"></i>
                                <span> Back </span>
                            </button>
                        </a>
                    <?php } ?>
                    </div>

                </div>

                <div class="row mt-3  mb-5 detail_common_row">

                	@include('site.profile.profilemenu')


                <div class="col-md-12 col-lg-9">
                        <!-- Our Dashbord -->

                        <section class="  ">

                            <div class="row">


                                <div class="col-lg-12">
                                    <div class="my_dashboard_review mb40">
                                        <div class="favorite_item_list">
                                            <div class="row">
                                                <div class="col-xl-6 ml-0 my-3">

                                                    <h3 class="white-nowrap h3">Promotion Detail</h3>

                                                </div>
                                            </div>


                                            <div class="row  ">
                                                <div class="col-md-4 ">
                                                    <div class="promotion_img">
                                                        <img class="img-fluid bdrs8 "
                                                            src="{{url('/storage/app/public/products/thumb300/'.$myClass->get_itemimage($productdetail['images']))}}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="promotion_contents ">
                                                        <div class="fz24 border-bottom py-2">
                                                            {{$productdetail['itemTitle']}}
                                                        </div>
                                                        <div class="d-flex justify-content-start
                                                            align-items-center border-bottom">
                                                            <div class="d-flex flex-wrap">
                                                                <div class="fwb mr-3 white-nowrap ">

                                                                    Promo Type:
                                                                </div>
                                                                <div class="">

                                                                    Urgent
                                                                </div>

                                                            </div>
                                                            <span class="classified-header-har-line mx-3"></span>

                                                            <div class="d-flex flex-wrap">
                                                                <div class="fwb mr-3 white-nowrap ">

                                                                    Paid Amount:
                                                                </div>
                                                                <div>

                                                                    {{$userpromotion['currencySymbol']}} {{$promotiondetail['price']}}
                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="trans_ID py-2 ">
                                                            <div class="">
                                                                Promotion Duration:

                                                            </div>
                                                            <div class="ovh">
                                                                {{$promotiondetail['duration']}} days
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

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

