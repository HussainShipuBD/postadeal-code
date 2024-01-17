<?php
use App\Classes\MyClass;
$myClass = new MyClass();
?>

@extends('layouts.head')
@section('title', 'Home')
@section('content')  

      <section class=" bgc-white">
         <div class="container-fluid">
            <div class="breadcrumb_content style2 my-3 ml-1 ml-lg-3 ">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('main.index')}}">{{ __('messages.Home') }}</a></li>
                  <li class="breadcrumb-item active " aria-current="page">{{ __('messages.Category View') }}</li>
               </ol>
            </div>
            <div class="row">
               <div class="col-lg-3 wids">
                  <div class="">
                     <div class=" make_fix sidebar_content_details style3  sidebar_ml0">
                        <div class="sidebar_listing_list style2 mb0">
                           <div class="sidebar_advanced_search_widget">
                              <h4 class="mb25">{{ __('messages.Filter By') }}
                                 <a class="filter_closed_btn float-right d-block d-lg-none" href="#">
                                    <span class="flaticon-close "></span></a>
                              </h4>
                              <ul class="sasw_list style2 mb0">
                        @if(!empty($categories))
                           @foreach($categories as $key => $maincategory)

                                 <li>
                                    <div id="accordion" class="panel-group">
                                       <div class="panel">
                                          <div class="panel-heading">
                                             <h4 class="panel-title">
                                                <a href="#panelBodyRating{{$key}}" class="accordion-toggle link"
                                                   data-toggle="collapse" data-parent="#accordion">
                                                   {{$maincategory['name']}} <i class="flaticon-down-arrow float-right"></i>
                                                </a>
                                             </h4>
                                          </div>
                                          <div id="panelBodyRating{{$key}}" class="panel-collapse collapse ">
                                             <div class="panel-body row">
                                                <div class="col-lg-12">
                                                   <ul class=" selectable-list w-100">
                                                <?php $sub_category = $myClass->get_subcategory($maincategory['_id']); ?>
                                                         @if(!empty($sub_category))
                                                         @foreach($sub_category as $key => $subcategory) 
                                                      <li class="position-relative">
                                                         <ul class="submenu-dropdown ">
                                                            <li class="menu-hasdropdown  my-2">
                                                               
                                                                  <?php $super_category_check = $myClass->get_supercategory_check($maincategory['_id'], $subcategory['_id']); ?>
                                                                        @if($super_category_check == 1)
                                                                  <span class="">      
                                                                  <a class="d-flex justify-content-between">
                                                                     <span>{{$subcategory['name']}}</span>
                                                                     <i class="flaticon-down-arrow float-right"></i>
                                                                  </a>
                                                               </span>
                                                                  @else
                                                                  <a href="{{ url('/search/subid-'.$subcategory['_id']) }}" class="d-flex justify-content-between">
                                                                     <span>{{$subcategory['name']}}</span>
                                                                  </a>
                                                                  @endif
                                                               <input type="checkbox" class="drop-menu-checkbox">
                                                               <ul class="drop-menu-dropdown ">
                                                                  <?php $super_category = $myClass->get_supercategory($maincategory['_id'], $subcategory['_id']); ?>
                                                                        @if(!empty($super_category))
                                                                        @foreach($super_category as $key => $supercategory)
                                                                  <li>
                                                                     <a class="" href="{{ url('/search/superid-'.$supercategory['_id']) }}">{{$supercategory['name']}}</a>
                                                                  </li>
                                                                    @endforeach
                                                                     @endif
<!--                                                                   <li>
                                                                     <a class="" href="#">Mac</a>
                                                                  </li>
                                                                  <li>
                                                                     <a class="" href="#">View
                                                                        All</a>
                                                                  </li>
 -->                                                               </ul>
                                                            </li>
                                                         </ul>
                                                      </li>
                                                      @endforeach
                                                        @endif
                                                   </ul>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </li>
                                @endforeach
                                @endif
                                 <li>
                                 <div id="accordion" class="panel-group">
                                    <div class="panel">
                                       <div class="panel-heading">
                                          <h4 class="panel-title">
                                             <a href="#panelBodyRating2" class="accordion-toggle link"
                                                data-toggle="collapse" data-parent="#accordion">
                                                {{ __('messages.Prices') }}<i class="flaticon-down-arrow float-right"></i>
                                             </a>
                                          </h4>
                                       </div>
                                       <div id="panelBodyRating2" class="panel-collapse collapse ">
                                          <div class="panel-body ">
                                             <div class="d-flex align-items-center justify-content-start  flex-nowrap ">
                                                <div class=" style2 list-inline-item my-3">
                                                   <input class="cart_count" placeholder="min" id="search-min" type="number">
                                                </div>
                                                <div class=" list-inline-item">
                                                   <input class="cart_count " placeholder="max" id="search-max" type="number">
                                                </div>
                                                <button class=" btn primary_clr" id="search_priceload">{{ __('messages.Apply') }}</button>
                                             </div>
                                                <span class="errorMessageproduct" id="Products_search_price"></span>

                                          </div>
                                       </div>
                                    </div>
                                 </div> </li>


                                 <li>
                                 <div id="accordion" class="panel-group">
                                    <div class="panel">
                                       <div class="panel-heading">
                                          <h4 class="panel-title">
                                             <a href="#panelBodyRating3" class="accordion-toggle link"
                                                data-toggle="collapse" data-parent="#accordion">
                                                {{ __('messages.Distance') }}<i class="flaticon-down-arrow float-right"></i>
                                             </a>
                                          </h4>
                                       </div>
                                       <div id="panelBodyRating3" class="panel-collapse collapse ">
                                        
                                         
                                           
                                                   <div class="my-3">
                                                      
                                                   
                                                      <span id="slider-range-value1"></span>
                                                     <span class="mt0" id="slider-range-value2"></span>
                                                      <div id="slider"></div>
                                                   </div>
                                              
                                  

                                            
                                          </div>
                                       </div>
                                    </div>
                                 </li>


                                 <li>
                                    <div id="accordion" class="panel-group">
                                       <div class="panel">
                                          <div class="panel-heading">
                                             <h4 class="panel-title">
                                                <a href="#panelBodyRating4" class="accordion-toggle link"
                                                   data-toggle="collapse" data-parent="#accordion">
                                                   {{ __('messages.Product condition') }}<i class="flaticon-down-arrow float-right"></i>
                                                </a>
                                             </h4>
                                          </div>
                                          <div id="panelBodyRating4" class="panel-collapse collapse">
                                             <div class="panel-body row">
                                                <div class="col-lg-12">
                                                   <ul class="ui_kit_checkbox selectable-list float-left fn-400">

							<?php $get_prodcutcondition_search = $myClass->get_prodcutcondition_search(); ?>
                                                         @if(!empty($get_prodcutcondition_search))
                                                         @foreach($get_prodcutcondition_search as $key => $get_prodcutcondition) 
                                                      <li>
                                                         <div class="custom-control custom-radio">
                                                            <input type="radio" name="productcondition" value="{{$get_prodcutcondition['_id']}}" class="custom-control-input"
                                                               id="customCheck{{$key}}">
                                                            <label class="custom-control-label" for="customCheck{{$key}}"> {{$get_prodcutcondition['name']}}
                                                            </label>
                                                         </div>
                                                      </li>
							@endforeach
							@endif

                                                   </ul>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </li>

                                 <li>
                                 <div id="accordion" class="panel-group">
                                    <div class="panel">
                                       <div class="panel-heading">
                                          <h4 class="panel-title">
                                             <a href="#panelBodyRating5" class="accordion-toggle link"
                                                data-toggle="collapse" data-parent="#accordion">
                                                {{ __('messages.Order By') }}<i class="flaticon-down-arrow float-right"></i>
                                             </a>
                                          </h4>
                                       </div>
                                       <div id="panelBodyRating5" class="panel-collapse collapse ">
                                          <div class="panel-body row">
                                             <div class="col-lg-12">
                                                <div class="ui_kit_checkbox style2 radioboxstyle">
                                                   <div class="custom-control custom-radio   ">
                                                      <input type="radio" name="orderby" value="" class="custom-control-input"
                                                         id="customCheck80">
                                                      <label class="custom-control-label"
                                                         for="customCheck80">Recent</label>
                                                   </div>
                                                   
                                                   <div class="custom-control  custom-radio  ">
                                                      <input type="radio" name="orderby" value="asc" class="custom-control-input"
                                                         id="customCheck83">
                                                      <label class="custom-control-label" for="customCheck83">Low to
                                                         High</label>
                                                   </div>
                                                   <div class="custom-control custom-radio ">
                                                      <input type="radio" name="orderby" value="desc" class="custom-control-input"
                                                         id="customCheck84">
                                                      <label class="custom-control-label" for="customCheck84">High to
                                                         low</label>
                                                   </div>
                                                </div>



                                             </div>


                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </li>

                             


                                 <li>
                                    <div class="search_option_button">
                                       <button type="submit" id="complete-search" class="btn btn-block btn-thm">{{ __('messages.Search') }}</button>
                                    </div>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-12 col-lg-9">
                  <!-- Land Properties -->
                  <section class="sections zi-1 ">
                     <div class="container-fluid container-lg">
                        <div class="row">
                           <div class="d-flex align-items-center  flex-column-reverse w-100 my-2">

                              <div id="main2" class="d-lg-none d-block">
                                 <span id="open_3"
                                  class="flaticon-filter-results-button filter_open_btn_2">
                                    {{ __('messages.Show Filter') }}</span>
                              </div>
                           </div>
                        </div>
                        <div class="row" id="data-wrapper-search">
                          
            @if(!empty($itemdetails))
                  @foreach($itemdetails as $itemdetail)
               <div class="col-6 col-sm-6 col-md-4 col-lg-3 cat-right " id="item-check">
                  <a href="{{ route('product.show', ['itemId' => $itemdetail['itemid']]) }}">
                     <div class="feat_property home3">
                        <div class="thumb">
                           <img class="img-whp" src="{{url('/storage/app/public/products/thumb300/'.$itemdetail['itemimage'])}}" alt="{{$itemdetail['itemtitle']}}">

                           @if($itemdetail['itemfeatured'] == 1)   
                           <div class="thmb_cntnt">
                              <ul class="tag mb0">
                                 <li class="color-white">{{ __('messages.Featured')}}</li>
                              </ul>
                           </div>
                           @endif

                        </div>
                        <div class="tc_content">
                              <div class="d-flex justify-content-between flex-wrap align-items-center">
                                 <p class="txt-truncate sec-color">  {{$itemdetail['itemdate']}}
                                 </p>
                                 <div class="txt-truncate mb-1">
                                 {{$itemdetail['itemtitle']}}</div>
                                 <div class="price-dis">
                                    <span class="dollor">{{$itemdetail['itemcurrency']}}</span>
                                    <span class="ml-1">{{$itemdetail['itemprice']}}</span>
                                 </div>
                              </div>
                           </div>
                     </div>
                  </a>
               </div>
                @endforeach
                 @else
                 <div class="noresult-item" id="noresult-item"> <img src="{{url('/storage/app/public/admin_assets/noresult.png')}}" alt="noresult.png"> </div>

                 @endif
                        
                 <div style="display: none;" class="noresult-item" id="noresult-item"> <img src="{{url('/storage/app/public/admin_assets/noresult.png')}}" alt="noresult.png"> </div>
                       
                        </div>
                  </section>
                  @if(count($itemdetails) >= 20)
                  <!-- more items  -->
                  <section class="section" id="more-item-search">
                     <div class="moreover ">
                        <a id="searchload_more" class="d-flex justify-content-center ">
                           <span class="flaticon-plus"></span>
                           <span class="mx-2"> {{ __('messages.More Over')}}</span> </a>
                     </div>
                  </section>
                  @endif
               </div>
            </div>
         </div>
      </section>
           <input type="hidden" value="<?php echo $offset; ?>" id="search-offset" />
           <input type="hidden" value="<?php echo $limit; ?>" id="search-limit" />
           <input type="hidden" value="" id="search-productcondition" />
           <input type="hidden" value="" id="search-orderby" />
           <input type="hidden" value="<?php echo $type; ?>" id="search-type" />
           <input type="hidden" value="<?php echo $itemnamesearch; ?>" id="search-itemname" />
           <input type="hidden" value="<?php echo $searchlat; ?>" id="searchpage-latitude" />
           <input type="hidden" value="<?php echo $searchlon; ?>" id="searchpage-longitude" />
           <input type="hidden" value="<?php echo $itemsellerid; ?>" id="search-selleruserId" />
           <input type="hidden" value="<?php echo $categoryId; ?>" id="search-categoryId" />
           <input type="hidden" value="<?php echo $subcategoryId; ?>" id="search-subcategoryId" />
           <input type="hidden" value="<?php echo $supercategoryId; ?>" id="search-supercategoryId" />
           <input type="hidden" value="" id="search-locationkm" />

   </div>
   @endsection

<script>

      $(' .radioboxstyle input.custom-control-input').on('change', function () {
         $(' .radioboxstyle input.custom-control-input ').not(this).prop('checked', false);
      });

  </script> 
