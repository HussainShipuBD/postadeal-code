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
                 d-flex justify-content-between  align-items-center">

                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active text-thm" aria-current="page">Address</li>
                    </ol>

                    <a  href="#" onclick ="return addaddress();" data-toggle="modal" class="primary_clr"
                    data-target=".bd-address-modal-lg" >
                        <div class="p-2 color-white primarybg_clr
                         btn p-2 d-flex align-items-center">
                         <i class="flaticon-plus pr-2 mt-1"></i> 
                         <span> Add Address </span> 
                        </div>
                    </a>
                </div>

                <div class="row mt-3  mb-5 detail_common_row">

                	@include('site.profile.profilemenu')


                <div class="col-md-12 col-lg-9">
                        <!-- Our Dashbord -->

                        <section>

                            <div class="row">


                                <div class="col-lg-12">
                                    <div class="my_dashboard_review mb40">
                                        <div class="favorite_item_list">
                                            <div class="row">
                                                <div class="col-xl-6 ml-0 my-3">

                                                    <h3 class="white-nowrap h3">My Address</h3>

                                                </div>
                                            </div>

                                            <?php if(!empty($userAddress)) { ?>
                                            @foreach($userAddress as $userAddress)
                                            <div class="favorite_item_list">
                                            <div class="feat_property list favorite_page">

                                                <div class="details">
                                                    <div class="">
                                                        <h4>{{$userAddress['name']}}</h4>
                                                        <p><span class="flaticon-placeholder"></span>{{$userAddress['addressOne']}} , {{$userAddress['addressTwo']}} </p>
                                                    <p><span class="flaticon-placeholder"></span>{{$userAddress['country']}} , {{$userAddress['pincode']}}</p>
                                                    <p><span class="flaticon-placeholder"></span>Phone Number : {{$userAddress['phone']}}</p>

                                                        <!--<a href="">
                                                            <div class="default_cls ">
                                                                Default
                                                            </div>
                                                        </a>-->
                                                    </div>
                                                </div>
                                                <ul class="view_edit_delete_list mb0 mt35">

                                                    <input type="hidden" value="{{$userAddress['name']}}" id="name{{$userAddress['_id']}}">
                                                    <input type="hidden" value="{{$userAddress['addressOne']}}" id="addressOne{{$userAddress['_id']}}">
                                                    <input type="hidden" value="{{$userAddress['addressTwo']}}" id="addressTwo{{$userAddress['_id']}}">
                                                    <input type="hidden" value="{{$userAddress['country']}}" id="country{{$userAddress['_id']}}">
                                                    <input type="hidden" value="{{$userAddress['pincode']}}" id="zipcode{{$userAddress['_id']}}">
                                                    <input type="hidden" value="{{$userAddress['phone']}}" id="phone{{$userAddress['_id']}}">


                                                    <li class="list-inline-item" data-toggle="tooltip"
                                                        data-placement="top" title="Edit">

                                                       <a  href="#" data-toggle="modal" class="primary_clr"
                                                        data-target=".bd-address-modal-lg" onclick ="return editaddress('{{$userAddress['_id']}}');">
                                                            <span class="flaticon-writing"></span></a>
                                                    </li>

                                                    <li class="list-inline-item" data-toggle="tooltip"
                                                        data-placement="top" title="Delete">
                                                        <a href="" data-toggle="modal"   data-target=".bd-Delet-modal-lg{{$userAddress['_id']}}">
                                                            <span class="flaticon-delete"></span></a>
                                                    </li>
                                                </ul>
                                                    @include('site.profile.deleteaddresspopup')

                                            </div>
                                            


                                            </div>
                                            @endforeach
                                        <?php } else { ?>
                                                <div class="favorite_item_list">
                                                <div class="feat_property list favorite_page">

                                                <div class="details">
                                                    <spann>No Address Found</spann>
                                                </div>
                                                </div>
                                                </div>

                                        <?php } ?>

                                        </div>
                                    </div>
                                </div>
                            </div>


                        </section>
                    </div>

                    </div>

        </section>





    </div>

    @include('site.profile.addressform')


    @endsection

