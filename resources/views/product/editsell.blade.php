<?php
use App\Classes\MyClass;
$myClass = new MyClass();
?>

@extends('layouts.head')
@section('title', 'Edit Sell')
@section('content')  

        <section>
            <div class="container">
                <div class="row my-2 detail_common_row">

                    <div class="col-md-12 col-lg-12">
                        <!-- Our Dashbord -->
                        <section class="our-dashbords dashbord pl15 pr15 ">
                            <div class="row">
                                <div class="col-lg-10 m-auto">

                                    <div class="breadcrumb_content style2 mt-3 ml-0 d-flex justify-content-between ">
                                        <ol class="d-flex">
                                            <li class="breadcrumb-item"><a href="#">{{ __('messages.Home') }}</a></li>
                                            <li class="breadcrumb-item active text-thm" aria-current="page">{{ __('messages.Edit Sell') }}
                                            </li>
                                        </ol>
                                    </div>


                                    <?php if($itemdetails[0]['productAvailability'] == 'available'){
                                         $product_status = "Mark as Sold";   
                                    } else {
                                         $product_status = "Mark as available";   
                                    } ?>    

                                    <div class="row" style="flex-flow: row-reverse;">    
                                    <div class="col-xl-12 text-right">
                                        <button class="btn btn-thm" id="productstatus_change"><?php echo __('messages.'.$product_status.''); ?></button>  
                                       <button class="btn btn-thm" id="productstatus_delete">{{ __('messages.Delete Product') }}</button> 
                                    </div>    
                                    <input type="hidden" value="{{$itemdetails[0]['productAvailability']}}" name="product_availability" id="product_availability">
                                </div>


                                    <div class="row">
                                        <div class="col-xl-6  my-3">
                                            <h3 class="white-nowrap h3">{{ __('messages.Advertise free') }}</h3>
                                            <p> {{ __('messages.Sale Tip: Tell us more about your photos & upload only quality photos!') }} </p>
                                        </div>
                                    </div>

                                    <div class="add_product_dashboard">

                                         <form method="POST" action="{{ route('product.editproduct') }}">
                                        @csrf      
                                        <div class="col-xl-12">
                                            <div class="row">
                                                <input type="hidden" name="itemId" id="itemId" value="{{ $itemdetails[0]['_id']}}">

                                                <div class="col-lg-12 col-xl-12">
                                                    <h4 class="white-nowrap h4">
                                                        {{ __('messages.Add photos of your product') }} </h4>
                                                    <div class="d-flex flex-wrap " id="new-uploadimage">
                                                        <!-- <input type="file" id="image_file" multiple="true" name="images[]" accept=".png, .jpg, .jpeg" onchange="start_image_upload();">
 -->
                                                        <div class="wrap-custom-file">
                                                        
                                                        <input type="file" id="image1" multiple="true" name="images[]" accept=".png, .jpg, .jpeg" onchange="start_image_upload();">

                                                            <label for="image1" class="flaticon-image gall-icon">

                                                            </label>
                                                        </div>
                                                        <div id="image_error" class="errorMessage"></div>
                                                        <?php $images = json_decode($itemdetails[0]['images'], TRUE); 
                                                                  $imgCount = count($images); 
                                                        foreach($images as $i=> $image) { ?>
                                                        
                                                        <div class="upld_imgdiv ">
                                                                <img src="<?php echo url("/storage/app/public/products/original").'/'.$image; ?>"  />
                                                            </div>
                                                        <?php } ?>         
                                                                           
                                                        <input type="hidden" value="{{$itemdetails[0]['images']}}" name="uploadedfiles" id="uploadedfiles">
                                                        <input type="hidden" name="count" id="count" value="{{$imgCount}}">
                                          

                                                    </div>
                                                 <span class="errorMessageproduct" id="Products_image_em"></span>       
                                                </div>
                                               @error('uploadedfiles')
                                            <span class="invalid-feedback product-check-error" id="products_image_error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                 @enderror  



                                                <div class="col-lg-12 col-xl-6">
                                                    <div class="my_profile_setting_input form-group">
                                                        <label for="formGroupExampleInput5">{{ __('messages.Name') }} </label>
                                                        <input type="text" class="form-control" 
                                                            placeholder="{{ __('messages.product title') }}" value="{{$itemdetails[0]['itemTitle']}}" name="products_name" id="products_name">


                                                 <span class="errorMessageproduct" id="Products_name_em"></span>
                                                                                             @error('products_name')
                                            <span class="invalid-feedback product-check-error" id="products_name_error" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                 @enderror


                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-xl-6">


                                                    <div class="my_profile_setting_input form-group">

                                                        <div class="search_option_two">
                                                            <label for="formGroupExampleInput3">{{ __('messages.Choose Categories') }}</label>

                                                            <div class="candidate_revew_select">
                                                                <select class="selectpicker w100 " id="products_category">
                                                                    <?php $main_category_name = $myClass->get_maincategory_item($itemdetails[0]['mainCategory']); ?>
                                                                    <option value="{{$main_category_name[0]['_id']}}">{{$main_category_name[0]['name']}}</option>
                                                                    @if(!empty($get_maincategory))
                                                                    @foreach($get_maincategory as $key => $maincategory)
								     @if($itemdetails[0]['mainCategory'] != $maincategory['_id'])	
                                                                    <option value="{{$maincategory['_id']}}">{{$maincategory['name']}}</option>
								     @endif	
                                                                     @endforeach
                                                                     @endif
                                                                </select>
                                                                 <input type="hidden" value="{{$itemdetails[0]['mainCategory']}}" name="products_maincat" id="select-maincat" />

                                                        <span class="errorMessageproduct" id="Products_maincat_em"></span>         
                                                        @error('products_maincat')
                                                        <span class="invalid-feedback product-check-error" id="products_maincat_error" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                             @enderror

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-xl-6 ">
                                                    <div class="my_profile_setting_input form-group">
                                                        <label for="formGroupExampleInput3"> {{ __('messages.Select Sub-category') }}
                                                        </label>
                                                        <div class="candidate_revew_select">
                                                            <select class="selectpicker w100 " id="products_subcategory">
                                                                
                                                                <option value="">{{ __('messages.Select Sub-category') }}</option>
                                                            </select>
                                                            <input type="hidden" value="{{$itemdetails[0]['subCategory']}}" name="products_subcat" id="select-subcat" />
                                                         <span class="errorMessageproduct" id="Products_subcat_em"></span>    
                                                        @error('products_subcat')
                                                        <span class="invalid-feedback product-check-error" id="products_subcat_error" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                             @enderror

                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-lg-12 col-xl-6" id="supercategoryhide">

                                                    <div class="my_profile_setting_input form-group">
                                                        <label for="formGroupExampleInput3">
                                                            {{ __('messages.Select child category for Mobile') }} </label>
                                                        <div class="candidate_revew_select">
                                                            <select class="selectpicker w100 " id="products_supercategory">
                                                                <option value=""> {{ __('messages.Select child category for Products') }}</option>
                                                            </select>
                                                            <input type="hidden" value="{{$itemdetails[0]['superCategory']}}" name="products_supercat" id="select-supercat" />

                                                         <span class="errorMessageproduct" id="Products_supercat_em"></span>                                                           @error('products_supercat')
                                                        <span class="invalid-feedback product-check-error" id="products_supercat_error" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                             @enderror

                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="showsuperfield"></div>



                                                <div class="col-lg-12 col-xl-12">

                                                    <div class="my_profile_setting_input form-group">

                                                        <label for="formGroupExampleInput5">{{ __('messages.Description') }} </label>

                                                        <textarea id="form_message" name="products_description"
                                                            class="form-control products_desc" rows="6">{{$itemdetails[0]['itemDesc']}}</textarea>

                                                            <span class="errorMessageproduct" id="Products_desc_em"></span>

                                                        @error('products_description')
                                                        <span class="invalid-feedback product-check-error" id="products_desc_error" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                             @enderror

                                                    </div>
                                                </div>



                                                <div class="col-lg-12 col-xl-6">
                                                    <div class="my_profile_setting_input form-group">

                                                        <!-- <input type="checkbox" class="custom-control-input "
                                                                id="customCheck3">
                                                            <label class="custom-control-label"
                                                                for="customCheck3">&nbsp;</label> -->



                                                        <div id="prices">
                                                            <label class="product_prices">{{ __('messages.Price') }}</label>

                                                            <div class=" product_prices ">

                                                                <div class="w100">

                                                                    <input type="text" value="{{$itemdetails[0]['price']}}" name="products_price" id="products_price" class="form-control"
                                                                        placeholder="{{ __('messages.Product Prices')}}" />

                                                                @error('products_price')
                                                                <span class="invalid-feedback product-check-error" id="products_price_error" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                     @enderror
                                                                </div>


                                                                <div class="currency_symbols">

                                                                    <div>
                                                                        <div class="candidate_revew_select">
                                                                            <select class="selectpicker  " id="products_currency">
                                                                                @if(!empty($currencydetails))
                                                                                 @foreach($currencydetails as $key => $currencydetail)
                                                                                <option value="{{$currencydetail['_id']}}">{{$currencydetail['currencycode']}}</option>
                                                                                @endforeach
                                                                                @endif
                                                                            </select>
                                                                            <input type="hidden" value="{{$itemdetails[0]['CurrencyID']}}" name="products_currency" id="select-currency" />

                                                                            @error('products_currency')
                                                                <span class="invalid-feedback product-check-error" id="products_currency_error" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                     @enderror
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>
                                           <span class="errorMessageproduct" id="Products_price_em"></span>

                                        <input type="hidden" value="6" name="before_decimal" id="before_decimal" />
                                        <input type="hidden" value="2" name="after_decimal" id="after_decimal" />

                                                        </div>

                                                    </div>


                                                </div>


                                                 <div class="col-lg-12 col-xl-6">

                                                    <div class="my_profile_setting_input form-group">
                                                        <label for="formGroupExampleInput3"> {{ __('messages.Product Condition') }} </label>
                                                        <div class="candidate_revew_select">
                                                        <select class="selectpicker w100 " id="products_condition">
                                                             <?php $product_con_name = $myClass->get_prodcutcondition_item($itemdetails[0]['productCondition']); ?>

                                                                <option value="{{$product_con_name[0]['_id']}}">{{$product_con_name[0]['name']}}</option>
                                                                    @if(!empty($productconditiondetails))
                                                                    @foreach($productconditiondetails as $key => $productconditiondetail)
                                                                    @if($product_con_name[0]['_id'] != $productconditiondetail['_id'])
                                                                    <option value="{{$productconditiondetail['_id']}}">{{$productconditiondetail['name']}}</option>
                                                                    @endif
                                                                     @endforeach
                                                                     @endif
                                                            </select>
                                                            <input type="hidden" value="{{$itemdetails[0]['productCondition']}}" name="products_condition" id="select-productscondition" />

                                                            <span class="errorMessageproduct" id="Products_productcondition_em"></span>
                                                                @error('products_condition')
                                                                <span class="invalid-feedback product-check-error" id="products_condition_error" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                     @enderror
                                                        </div>
                                                    </div>
                                                </div>


 						 <?php if($itemdetails[0]['buynow'] == 'true')
                                                       {
                                                        $buynow = 1;
                                                        $check = 'checked';
                                                        $style = "display: block;";
                                                       } 
                                                       else 
                                                       {
                                                        $buynow = 0;
                                                        $check = '';
                                                        $style = "display: none;";
                                                       } 

                                                ?>

                                                <div class="col-lg-12 col-xl-12">
                                                     <div class="my_profile_setting_input form-group">
                                                        <label for="formGroupExampleInput3"> {{ __('messages.Product Buynow') }} </label>
                                                        <div class="candidate_revew_select">

                                                        <label class="productswitch">
                                                          <input type="checkbox" {{$check}} id="buynow_check">
                                                          <span class="productslider round"></span>
                                                        </label>

                                                        </div>
                                                            <input type="hidden" value="{{$buynow}}" name="products_buynow" id="products_buynow" />
                                                     </div> 
                                                   </div>    


                                                 <div class="col-lg-12 col-xl-6" id="shipping_check" style="{{$style}}">
                                                     <div class="my_profile_setting_input form-group">
                                                        <label for="formGroupExampleInput3"> {{ __('messages.Product Shipping Price') }} </label>
                                                        <div class="w50">
                                                        <input type="text" value="{{ ((isset($itemdetails[0]['shippingprice'])) ? $itemdetails[0]['shippingprice'] : 0 )}}" class="form-control"
                                                                    placeholder="{{ __('messages.Enter the product shipping price') }}" name="products_shipping_price" id="products_shipping_price"/>
                                                        <span class="errorMessageproduct" id="Products_shippingprice_em"></span>

                                                     </div> 
                                                   </div>   
                                                   </div> 

                                                <div class="col-lg-12 col-xl-12">
                                                    <div class="my_profile_setting_input form-group">
                                                        <div>
                                                            <label> {{ __('messages.Product location') }} </label>


                                                            <div class="w100">
                                                                <input type="text" value="{{$itemdetails[0]['locationName']}}" class="form-control"
                                                                    placeholder="{{ __('messages.Tell Where you sell this item') }}" id="productautocomplete" name="products_location"/>

                                                                <p> {{ __('messages.Note: Choose a location from the dropdown list. Avoid entering manually') }} </p>
                                                            </div>
                                                            <input type="hidden" value="{{$itemdetails[0]['latitude']}}" name="products_lat" id="products_lat" />
                                                            <input type="hidden" value="{{$itemdetails[0]['longitude']}}" name="products_lon" id="products_lon" />

                                                            <span class="errorMessageproduct" id="Products_location_em"></span>
                                                                @error('products_location')
                                                                <span class="invalid-feedback product-check-error" id="products_location_error" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                     @enderror

                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="col-xl-12 text-right">
                                                    <div class="my_profile_setting_input form-group">
                                                        <!-- <button class="btn btn1">View Public Profile</button> -->
                                                       <!--  <a href="#" data-toggle="modal"
                                                            data-target=".bd-example-modal-lg">
                                                            <button class="btn btn2">Post now</button></a>
 -->
                                                     <button class="btn btn2" onclick="return validateproduct();">{{ __('messages.Post now') }}</button>
                                                    </div>

                                                </div>



                                            </div>
                                        </div>
                                         </form>
                                    </div>

                                </div>


                            </div>
                    </div>
                </div>
            </div>
        </section>
    </div>




    <!-- Modal -->

  
    <!-- Modal -->
    <div class="payment_modal modal fade bd-example-modal-lg px-3" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom">

                    <div class="features_text_heading w-100">
                        Promoto your listing
                    </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="flaticon-close"></i> </button>
                </div>

                <div class="modal-body container pb20 px-0 pt-0">

                    <div class="modal_insidebody_scroll">
                        <div class=" modal_radiobox mb-2">
                            <div class="ui_kit_checkbox style2 radioboxstyle">

                                <div class="custom-control custom-checkbox   ">
                                    <input type="checkbox" class="custom-control-input" value="option_1"
                                        id="customCheck80">
                                    <label id="checkbox_labid1" class="custom-control-label 
                              checkbox_labid1 d-flex justify-content-between " for="customCheck80">
                                        <span> 7 Days </span>

                                        <div class="amount w60">
                                            <span>$</span> <span>10.00</span>
                                        </div>
                                    </label>

                                </div>
                                <div class="custom-control custom-checkbox  ">
                                    <input type="checkbox" class="custom-control-input" value="option_2"
                                        id="customCheck82">
                                    <label id="checkbox_labid2"
                                        class="custom-control-label checkbox_labid2 d-flex justify-content-between "
                                        for="customCheck82">
                                        <span> 30Days </span>

                                        <div class="amount w60">
                                            <span>$</span> <span>50.00</span>
                                        </div>
                                    </label>
                                </div>
                                <div class=" custom-control custom-checkbox  ">
                                    <input type="checkbox" class="custom-control-input" value="option_3"
                                        id="customCheck83">
                                    <label id="checkbox_labid3"
                                        class="custom-control-label checkbox_labid3 d-flex justify-content-between "
                                        for="customCheck83">
                                        <span> 90Days</span>

                                        <div class="amount w60">
                                            <span>$</span> <span>90.00</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="modal_content my-3">

                            <div class="contents">
                                <div class="tickbg"><i class="flaticon-checked"></i> </div>
                                Get Noticed with 'FEATURED' tag in a tap position
                            </div>

                            <div class="contents">
                                <div class="tickbg"><i class="flaticon-checked"></i> </div>
                                Add Will be Highlighted to top positions
                            </div>

                            <div class="contents">
                                <div class="tickbg"><i class="flaticon-checked"></i> </div>
                                Reach up to 4 times more buyers

                            </div>
                        </div>


                        <div class="featured_cont_box ">
                            <h4 class="p-2">See Below Example</h4>
                            <div class="d-flex align-items-center justify-content-around flex-wrap">

                                    <div class="feat_property home3">
                                       


                                        <div class="featured_thumb-bg ">
                                    
                                               
                                            <div class="thmb_cntnt">
                                               
                                                <ul class="tag mb0 featured_tag-bg">

                                                </ul>
                                                
                                            </div>

                                        </div>
                                        <div class="tc_content">
                                            <div class="d-flex justify-content-between flex-wrap align-items-center">

                                                <div class="featured_content-bg_1">
                                                    <div class="txt-truncate mb-1"></div>
                                                </div>

                                                <div class="featured_content-bg_2">
                                                    <div class="price-dis">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                           
                            
                                    <div class="feat_property home3">


                                        <div class="featured_thumb-bg">
                                            <div class="thmb_cntnt">


                                            </div>

                                        </div>
                                        <div class="tc_content">
                                            <div class="d-flex justify-content-between flex-wrap align-items-center">

                                                <div class="featured_content-bg_1">
                                                    <div class="txt-truncate mb-1"></div>
                                                </div>

                                                <div class="featured_content-bg_2">
                                                    <div class="price-dis">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                              

                            </div>
                        </div>

                    </div>

                    <a href="#">
                        <div class=" pay_btn btn-thm white-color mx-3
                          d-flex justify-content-center align-items-center h45 ">
                            Confrim
                        </div>
                    </a>



                </div>
            </div>
        </div>
    </div>


@endsection

