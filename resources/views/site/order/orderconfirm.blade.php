<?php
use App\Classes\MyClass;
$myClass = new MyClass();
?>


@extends('layouts.head')
@section('title', 'My Orders')
@section('content')  





<div class="wrapper ovh position-relative">


        <section>

            <div class="container">


                <div class="row my-2 detail_common_row">

                    <div class="col-md-12 col-lg-12">
                        <!-- Our Dashbord -->
                        <section class="our-dashbords dashbord pl15 pr15 ">
                            <div class="row">
                                <div class="col-lg-10 m-auto ">
                                    <div class="add_product_dashboard">
                                        <div class="d-flex justify-content-between flex-wrap  py-3 border-bottom">
                                            <div class="prod_detail_stru">
                                                <div class="mb-2 text-gray-color fz17">{{$myClass->get_itemdate($itemdetail['createdAt'])}}</div>
                                                <div class="product_title">{{$itemdetail['itemTitle']}}</div>
                                                <!--<div class="">


                                                    <div class="qty_selectbox_section 
                                                        ui_kit_select_search form-group my-3">
                                                        <Label>Qty :</Label>
                                                        <div class="qty_selectpicker mx-2">
                                                            <select class="selectpicker ">
                                                                <option data-tokens="Status1">1</option>
                                                                <option data-tokens="Status2">2</option>
                                                                <option data-tokens="Status3">3</option>
                                                                <option data-tokens="Status4">4</option>
                                                                <option data-tokens="Status5">5</option>
                                                                <option data-tokens="Status5">6</option>
                                                                <option data-tokens="Status5">7</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>-->
                                            </div>

                                            <div class="confirm_prod">
                                                <?php
                                                $itemimg = $myClass->get_itemimage($itemdetail['images'])
                                                ?>
                                                <img src="{{url('/storage/app/public/products/thumb300/'.$itemimg)}}" class="h100p w100 obj_cov bdrs8  " />
                                            </div>

                                        </div>

                                        <!--<form id="commentForm">
                                            <div class="py-3 d-flex justify-content-between 
                                            align-items-center">
                                                <div class="add_coupen">

                                                    <input type="text" placeholder="Add Coupen" class="data-input"
                                                        required />
                                                    <p class="validate_text color-red"></p>
                                                    <div id="coupen_cont"></div>
                                                </div>

                                                <div class="d-flex">
                                                    <a href="#">
                                                        <div class="apply_link">Apply </div>
                                                    </a>
                                                    <a href="#">
                                                        <div class="remove_link " id="remove"> Remove </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </form>-->

                                        <div class="py-3 border-top border-bottom address_section">
                                            <div class=" d-flex justify-content-between">
                                                <span>Address</span>
                                                <span>
                                                    <a href="#" onclick ="return addaddress();" data-toggle="modal" class="primary_clr"
                                                        data-target=".bd-address-modal-lg">Add Address </a>
                                                </span>
                                            </div>

                                            <div class="favorite_item_list ">

                                                <div class=" address_radiobox mb-2">
                                                    <div class="ui_kit_checkbox style2 radioboxstyle">
                                                        <?php if(!empty($addressdetail)) { ?>
                                                        @foreach($addressdetail as $key=>$userAddress)
                                                        <div class="custom-control custom-checkbox  my-4 ">
                                                            <input type="checkbox" class="custom-control-input" style="width:25% !important;"
                                                                value="{{$userAddress['_id']}}" id="customCheck8{{$key}}">
                                                            <label id="checkbox_labid{{$key}}" class="custom-control-label 
                                                                checkbox_labid{{$key}} d-flex justify-content-between "
                                                                for="customCheck8{{$key}}">

                                                                <div
                                                                    class="d-flex flex-wrap justify-content-between w-100">
                                                                    <div class="details">

                                                                        <div class="d-flex 
                                                                        align-items-center flex-wrap">
                                                                            <div>{{$userAddress['name']}}</div>
                                                                            <!--<p class="default_tag">
                                                                                Default
                                                                            </p>-->
                                                                        </div>

                                                                        <p>
                                                                            {{$userAddress['addressOne']}} , {{$userAddress['addressTwo']}} , {{$userAddress['country']}} , {{$userAddress['pincode']}}
                                                                        </p>

                                                                    </div>
                                                                    <ul class="view_edit_delete_list mb0 ">

                                                                <input type="hidden" value="{{$userAddress['name']}}" id="name{{$userAddress['_id']}}">
                                                                <input type="hidden" value="{{$userAddress['addressOne']}}" id="addressOne{{$userAddress['_id']}}">
                                                                <input type="hidden" value="{{$userAddress['addressTwo']}}" id="addressTwo{{$userAddress['_id']}}">
                                                                <input type="hidden" value="{{$userAddress['country']}}" id="country{{$userAddress['_id']}}">
                                                                <input type="hidden" value="{{$userAddress['pincode']}}" id="zipcode{{$userAddress['_id']}}">
                                                                <input type="hidden" value="{{$userAddress['phone']}}" id="phone{{$userAddress['_id']}}">


                                                                        <li class="list-inline-item"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            title="Edit">
                                                                    <a href="#" onclick ="return editaddress('{{$userAddress['_id']}}');" data-toggle="modal" class="primary_clr" data-target=".bd-address-modal-lg">
                                                                                <span
                                                                                    class="flaticon-writing"></span></a>
                                                                        </li>

                                                                        <li class="list-inline-item"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            title="Delete">
                                                                            <a href="#" data-toggle="modal"
                                                                                data-target=".bd-Delet-modal-lg{{$userAddress['_id']}}">
                                                                                <span
                                                                                    class="flaticon-delete"></span></a>
                                                                        </li>
                                                                         @include('site.profile.deleteaddresspopup')
                                                                    </ul>
                                                                </div>
                                                            </label>

                                                        </div>
                                                        @endforeach
                                                    <?php } else { ?>
                                                        <div style="color: red;">
                                                            Please add the shipping address details to proceed the payment process
                                                        </div>

                                                    <?php } ?>

                                                       
                                                    </div>

                                                </div>








                                            </div>
                                        </div>

                                        <div class="py-3">
                                            <div class="order_details">
                                                <h4 class="title text-left mb20">
                                                    <span class="text-gray-color">Price Details </span>
                                                </h4>

                                                <div class="product_conf_details">
                                                    <ul>
                                                        <li>Selling Price <span class="float-right">{{$currencydetail['currencysymbol']}}{{$itemdetail['price']}} {{$currencydetail['currencycode']}}</span>
                                                        </li>
                                                        @if($itemdetail['shippingprice'])
                                                        <li>Shipping <span class="float-right">{{$currencydetail['currencysymbol']}}{{$itemdetail['shippingprice']}} {{$currencydetail['currencycode']}}</span></li>
                                                        @endif
                                                        <!--<li>Tax <span class="float-right">$35.00 JMD</span></li>
                                                        <li>Coupon <span class="float-right">-$20.00 JMD</span></li>-->

                                                        <?php

                                                            if($itemdetail['shippingprice']) {
                                                                $totalprice = intval($itemdetail['price']) + intval($itemdetail['shippingprice']);
                                                            } else {
                                                                $totalprice = intval($itemdetail['price']);
                                                            }

                                                        ?>

                                                        <div class="text-thm border-bottom border-top py-3">
                                                            Total Amount

                                                            <span class="float-right tamount">{{$currencydetail['currencysymbol']}} {{$totalprice}} {{$currencydetail['currencycode']}}</span>
                                                        </div>

                                                        <div class="d-flex justify-content-end">
                                                            <button type="button"
                                                                class="btn btn-log     btn-thm2 bdrs8 my-3" return id="submitorder">
                                                                Confirm</button>
                                                        </div>
                                                        <div class="order-alert">Please select shipping address</span>

                                                        <input type="hidden" id="userId" value="{{$userId}}">
                                                        <input type="hidden" id="currency" value="{{$currencydetail['currencycode']}}">
                                                        <input type="hidden" id="amount" value="{{$totalprice}}">
                                                        <input type="hidden" id="itemId" value="{{$itemdetail['_id']}}">
                                                        <input type="hidden" id="stripepublickey" value="{{$myClass->site_settings()->publickey}}">

                                                    </ul>
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

       
    @include('site.profile.addressform')


    @endsection

<script src="https://js.stripe.com/v3/"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script type='text/javascript'>

    var baseURL = "{{ url('/') }}";

    jQuery('#submitorder').live('click',function(e) {

        var addressId = $("input:checkbox:checked").val();

        //var check = $('#customCheck80:checkbox:checked').length;

        //alert(check);

        if(typeof addressId == 'undefined'){
            $('.order-alert').show();
            return false;
        } else {

            $('.order-alert').hide();

            var addressId = $("input:checkbox:checked").val();

            var itemId = $('#itemId').val();

            var userId = $('#userId').val();

            var amount = $('#amount').val();

            var currency = $('#currency').val();

            var stripekey = $('#stripepublickey').val();

            var stripe = Stripe(stripekey);


            $.ajax({
                url: baseURL + "/order/orderpaycreation",
                type: "POST",
                dataType : "json",
                data:{ addressId : addressId, amount : amount, itemId : itemId, userId : userId, currency : currency },
                success: function (res) {
                    if(res){
                       
                        if(res.session_id){
                            return stripe.redirectToCheckout({ sessionId: res.session_id });
                        }
                    }
                    else{
                        return false; 
                    }
                },
            });
            return false;
        }

        
    });


</script>

<style>
    .order-alert {
        color:red; 
        display:none; 
        text-align: right;
    }
</style>
    