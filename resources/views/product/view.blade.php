<?php
use App\Classes\MyClass;
$myClass = new MyClass();
?>


@extends('layouts.head')
@section('title', 'Home')
@section('content')  


  <div class="wrapper ovh position-relative bgc-white ">
      <section class="sticky_heading  p0 ">
         <div class="container-fluid">
            <div class="row">
               <div class="col-xl-12">
                  <div class="sticky-nav-tabs">
                     <ul class="sticky-nav-tabs-container">
                        <li class="list-inline-item nav-item active"><a class="sticky-nav-tab" href="#tab-1">{{ __('messages.Details')}}</a>
                        </li>
                        <li class="list-inline-item nav-item"><a class="sticky-nav-tab" href="#tab-2">{{ __('messages.Description')}}</a>
                        </li>
                        <li class="list-inline-item nav-item"><a class="sticky-nav-tab" href="#tab-3">{{ __('messages.Locations')}}</a></li>
                        <li class="list-inline-item nav-item"><a class="sticky-nav-tab" href="#tab-4">{{ __('messages.Reviews')}}</a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </section>


      <!-- Listing Single Property -->
      <section class="listing-title-area mt100 " id="tab-1">
         <div class="container">
            <div class=" my-3 ">

               <!-- <div class="col-lg-5 col-xl-4">
                     <div class="single_property_social_share">
                       
                      
                     </div>
                  </div> -->
            </div>
            <div class="row">
               <div class="col-sm-12 col-md-7 col-lg-8 m0a">
       <div class="row">
                   <?php $images = json_decode($itemdetails->images, TRUE); 
                  $imgCount = count($images); ?>

                  <div class="col-sm-7 col-lg-8 m0a">
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="spls_style_two mb30-520 imagebigbg_clr">
                              
                              <a class="popup-img-lar" 
                              class="img-fluid w100" href="{{url('/storage/app/public/products/original/'.$images[0])}}">

                                <img class="img-fluid w100 "
                                  src="{{url('/storage/app/public/products/original/'.$images[0])}}" alt="{{$images[0]}}"></a>

                                 
                           <div class="single_property_title view_photos_box">
                              <a href="{{url('/storage/app/public/products/original/'.$images[0])}}" class="upload_btn popup-img">
                                 <span class="flaticon-photo-camera"></span> {{ __('messages.View Photos')}}</a>
                           </div>
                           </div>

                        </div>
                     </div>
                  </div>
                  @if($imgCount > 1)
                   <div class="col-sm-5 col-lg-4 d-none d-sm-block">
                     <div class="row">
                        <?php foreach($images as $i=> $image) {
                        if($i != 0) { ?>
                        <div class="col-sm-6 col-lg-6">
                           <div class="spls_style_two mb30 imagesmbgclr">
                              <a class="popup-img" href="{{url('/storage/app/public/products/original/'.$image)}}">
                                 <img class="img-fluid w100 "
                                 src="{{url('/storage/app/public/products/original/'.$image)}}" alt="{{$image}}"></a>
                           </div>
                        </div>
                        <?php 
                        }
                      } ?>
                        
                     </div>
                  </div> 
                  @endif
               </div>            
         </div>
      </section>
      <!-- Agent Single Grid View -->
      <section class="our-agent-single  pb30-991 mt-3 tpp">
         <div class="container">
            <div class="row">
               <div class="col-md-12 col-lg-8 mb-5">
                  <div class="container">

                     <div class="row">
                        <div class="col-12">
                           <div class="d-flex justify-content-between align-items-center mb-2 ">
                              <div class="single_property_title product_tit_desc ">
                                 <div class="mb-2 text-gray-color fz17">{{$myClass->get_itemdate($itemdetails['createdAt'])}}</div>
                                 <div class="product_title">{{$itemdetails->itemTitle}}</div>

                                 <h3>{{$currencydetail->currencysymbol}} {{$itemdetails->price}}</h3>
                                 <div class="d-flex align-items-center my-3">
                                    <div class="like-new"> {{ __('messages.Like new')}}</div>
                                    <!--<span class="red-color">{{ __('messages.Hurry up only one is available')}}</span>-->
                                 </div>

                              </div>

                              <div class="price d-flex align-items-center fn-400">


                                 <ul class="mb0 ml-5 d-flex">
                                    <!-- <li class="list-inline-item ">
                                       <a href="#"> <span class="flaticon-heart fz24 "></span></a>
                                       <a href="#"> <span class="flaticon-love fz24 "></span></a>

                                    </li> -->

                                    <div class="form-label-group position-relative">


                                       <div class="struct">
                                          <span id="img1" class="imag">
                                             <span class="flaticon-heart fz24 white-color "></span> </span>
                                          <span id="img2"> <span class="flaticon-love fz24 white-color "></span>
                                          </span>
                                       </div>
                                    </div>

                                 </ul>
                              </div>
                           </div>
                           <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 ">
                              <div class="d-flex align-items-center">

                                 <div class=" mr-3">
                                    <a href="#" class="social-circle">
                                       <i class="fa fa-facebook f-28 fb-color"></i>
                                    </a>
                                 </div>


                                 <div class="">
                                    <a href="#" class="social-circle">
                                       <i class="fa fa-twitter f-28 tw-color"></i>
   2019                                 </a>
                                 </div>

                              </div>

                              <div class="d-flex align-items-center my-2">
                                 <!-- <i class=" mx-2"></i> -->
                                 <span class="flaticon-warning mx-2"></span>
                                 <span>{{ __('messages.Report inappropriate')}}</span>
                              </div>


                           </div>

                        </div>

             
                        <div class="col-lg-12" id="tab-2">
                           <div class="listing_single_description">
                             
                              <h4 class="mb30">{{ __('messages.Description')}}</h4>

                              <?php //echo strlen($itemdetails->itemDesc); 

                                    if(strlen($itemdetails->itemDesc) < 200) { ?>

                              <p class="mb25">{{$itemdetails->itemDesc}}
                              </p>
                              
                              <?php } else { ?>

                                  <p class="mb25">{!!strlen($itemdetails->itemDesc) > 200 ? substr($itemdetails->itemDesc,0,200) : $itemdetails->itemDesc!!}
                              </p>
                                 <p class="gpara second_para white_goverlay mt10 mb10">{!!strlen($itemdetails->itemDesc) > 200 ? substr($itemdetails->itemDesc,200,1000) : $itemdetails->itemDesc!!}</p>
                              <div class="collapse" id="collapseExample">
                                 <div class="card card-body">
                                    <p class="mt10 mb10">{!!strlen($itemdetails->itemDesc) > 200 ? substr($itemdetails->itemDesc,200,1000) : $itemdetails->itemDesc!!}</p>
                                 </div>
                              </div>
                              <p class="overlay_close">
                                 <a class="text-thm fz14" data-toggle="collapse" href="#collapseExample"
                                    role="button" aria-expanded="false" aria-controls="collapseExample">
                                    {{ __('messages.Show More')}} <span class="flaticon-download-1 fz12"></span>
                                 </a>
                              </p>
                           <?php } ?>
                           </div>


                        </div>



                        <div class="col-lg-12" id="tab-3">
                           <div class="application_statics mt30">
                            <h4 class="mb30">{{ __('messages.Location')}} <small class="float-right">{{$itemdetails->locationName}}</small>
                              </h4>
                              <input type="hidden" value="{{$itemdetails->locationName}}" class="product-location-name" />
                              <input type="hidden" value="{{$itemdetails->latitude}}" class="product-location-lat" /> 
                              <input type="hidden" value="{{$itemdetails->longitude}}" class="product-location-long" />

                              <div class="property_video p0">
                                      <!-- <div id="map_canvas" class="map-location" style="width: 600; height: 450"></div> -->
                                      <div class="thumb">
                                    <div id="map_canvas" class="map-location" style="width: 800; height: 450"></div>
                                    <!-- <div class="overlay_icon">
                                       <a href="#"><img class="map_img_icon" src="{{ URL::asset('/storage/app/public/admin_assets/dark.png') }}"
                                          alt="header-logo.png"></a>
                                    </div> -->
                                 </div>
                              </div>
                           </div>
                        </div>


                 @if(!empty($reviewdetails))
                        <div class="col-lg-12"  id="tab-4">
                           <div class="product_single_content">
                              <div class="mbp_pagination_comments mt30">
                                 <ul class="total_reivew_view">
                                    <li class="list-inline-item sub_titles">{{$reviewdetailcount}}</li>
                                    <li class="list-inline-item">
                                       <ul class="star_list">
                                          <?php
                                         $averageRating = $reviewratingtotal;
                                         for ($i = 1; $i <= 5; $i++) {
                                             if ($i <= $averageRating) {
                                                 echo '<li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>';
                                             } else {
                                                 echo '<li class="list-inline-item"><a href="#"><span><i class="fa fa-star"></i></span></a></li>';
                                             }
                                         }
                                         ?>
                                       </ul>
                                    </li>
                                    <li class="list-inline-item avrg_review">( {{$reviewratingtotal}} out of 5 )</li>
                                    <li class="list-inline-item write_review">
				       @auth	
                                       @if(Auth::user()->_id != $itemdetails->userId)        
                                       <a href="#" data-toggle="modal" data-target=".bd-example-modal-lg">
                                       <span class="text-thm">{{ __('messages.Write a Review')}}</span></a>
                                       @endif
				       @else
                                       <a href="{{ route('auth.login') }}">
                                       <span class="text-thm">{{ __('messages.Write a Review')}}</span></a>
					@endauth		
                                    </li>
                                 </ul>
                                 
                                 @foreach($reviewdetails as $reviewdetail)
                                 @php $reviewuserdetail = $myClass->get_userdetails($reviewdetail['userId']); @endphp
				<div id="data-loadreview">
                                 <div class="mbp_first media profile-img">
                                    <?php 
                                    if(!empty($reviewuserdetail['image']) && isset(($reviewuserdetail['image']))) {
                                         $imageurl = url('/storage/app/public/users/thumb100/'.$reviewuserdetail['image']);
                                         $imagename = $reviewuserdetail['image']; 
                                    } else {
                                          $imageurl = url('/storage/app/public/users/thumb100/default.png');
                                         $imagename = 'default.png'; 
                                    }
                                     ?>  
                                    <img src="{{$imageurl}}" class="mr-3" alt="{{$imagename}}">
                                    <div class="media-body">
                                       <h4 class="sub_title mt-0">
                                          {{$reviewuserdetail[0]['name']}}
                                          <div class="sspd_review dif">
                                             <ul class="ml10">
                                                <?php
                                                      $averageRating = $reviewdetail['rating'];
                                                     for ($i = 1; $i <= 5; $i++) {
                                                         if ($i <= $averageRating) {
                                                             echo '<li class="list-inline-item"><a href="#"><i class="fa fa-star"></i></a></li>';
                                                         } else {
                                                             echo '<li class="list-inline-item"><a href="#"><span><i class="fa fa-star"></i></span></a></li>';
                                                         }
                                                     }
                                                     ?>
                                             </ul>
                                          </div>
                                       </h4>
                                       <a class="sspd_postdate fz14">{{$myClass->get_itemdate($reviewdetail['createdAt']->toDateTime()->format('Y-m-d H:i:s'))}}</a>
                                       <p class="mt10">{{$reviewdetail['message']}}</p>
                                    </div>
                                 </div>
				</div>
                                 <div class="custom_hr"></div>
                                  @endforeach
				 @if(count($reviewdetails) >= 1)
                                 <input type="hidden" value="{{$itemdetails->userId}}" class="product-sellerid-review" />
                                 <a id="loadMoreReview" class="review-load">
                                 <div class="loadmore_rev">
                                    <span class="loadmore_stock">Load More</span> 
                                 </div></a>
                                 @endif
                              </div>
                           </div>
                        </div>
                        @endif

                     </div>
                  </div>
               </div>


               <div class="col-lg-4 col-xl-4 wids">
                  <div class="make_fix">
                     <div class="sidebar_listing_list">
                        <div class="sidebar_advanced_search_widget">
                           <div class="mb40">

                              <h4 class="mb20">{{ __('messages.Listed By')}}</h4>

                              <div class="media ">
				<a href="{{ route('site.profile.mylistings', ['userId' => $userdetail['_id']]) }}">
                                 <div class="position-relative mr-3 ">
                                     <?php 
                                    if(!empty($userdetail['image']) && isset(($userdetail['image']))) {
                                         $imageurl = url('/storage/app/public/users/thumb100/'.$userdetail['image']);
                                         $imagename = $userdetail['image']; 
                                    } else {
                                          $imageurl = url('/storage/app/public/users/thumb100/default.png');
                                         $imagename = 'default.png'; 
                                    }
                                     ?>                                      
                                    <div class="profile-img">
                                       <img class="mr-3 " src="{{$imageurl}}" alt="{{$imagename}}">
                                    </div>

<!--                                     <div class="prime_tag">
                                       <img src="images/prime.png" alt="prime.png">
                                    </div>
 -->

                                 </div>
				</a>
                                 <div class="media-body">
                                    <h5 class="mt-0 mb0 fz17">{{$userdetail['name']}}</h5>

                                    <div class="d-flex  align-items-center mt-2">

                                       <div class="star-review">
                                          <i class="flaticon-star white-color fz11 "></i>
                                          <span class="ml-1 white-color">{{$reviewratingtotal}}</span>
                                       </div>

                                       <div class="mx-2">{{$reviewdetailcount}} reviews </div>

                                    </div>

                                 </div>


                              </div>
                           </div>

                           @if($itemdetails['buynow'] == 'true' && $itemdetails['userId'] != $loginuserId)
                           <a href="{{ route('site.order.orderconfirm', ['itemId' => $itemdetails['_id']]) }}">
                              <button type="button" class="btn btn-log btn-block btn-thm2 bdrs8 my-3">
                                 {{ __('messages.Buy Now')}}</button> </a>
                           @endif

                           @if($itemdetails['userId'] == $loginuserId)
                           <a href="{{ route('product.editsell', ['itemId' => $itemdetails['_id']]) }}">
                              <button type="button" class="btn btn-log btn-block btn-thm2 bdrs8 my-3">
                                 {{ __('Edit Product')}}</button> </a>
                           @endif

                           <!--<div id="checking-inputs" class="checking-inputs clearfix mb15" style="position: relative;">
                              <div class="form-text2 clshome">
                                 <input type="button" id="daterangepick" name="daterange"
                                    class="btn btn-log btn-block btn-bordbg bdrs8 click_inside" value="Dates" />
                              </div>
                           </div>-->

                           <a href="javascript:;" onclick="get_to_chat();">
                              <button type="button" class="btn btn-log btn-block btn-bordbg bdrs8">

                                 {{ __('messages.Chat with Seller')}}</button> </a>
                                 <p class="text-danger" id="create_chat_err"></p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>


      <!-- Feature Properties -->
       @if(!empty($selleritemdetails))
      <section class="sections zi-1  mb-5">
         <div class="container">
            <div class="row">
               <div class="col-lg-12 p-2">
                  <div class="main-title">
                     <h2> {{ __('messages.More Product from')}} {{$userdetail['name']}}</h2>

                     <a class="" href="#">
                        <div class="d-flex align-items-center">
                           <span class="w70">{{ __('messages.View All')}} </span>
                           <span class="flaticon-right-arrow-1"></span>
                        </div>
                     </a>

                  </div>
               </div>
            </div>
            <div class="row">
               @foreach($selleritemdetails as $selleritemdetail)
               <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                  <a href="{{ route('product.show', ['itemId' => $selleritemdetail['itemid']]) }}">
                     <div class="feat_property home3">
                        <div class="thumb">

                           <img class="img-whp" src="{{url('/storage/app/public/products/thumb300/'.$selleritemdetail['itemimage'])}}" alt="{{$selleritemdetail['itemtitle']}}">

                           @if($selleritemdetail['itemfeatured'] == 1)   
                           <div class="thmb_cntnt">
                              <ul class="tag mb0">
                                 <li class="color-white">{{ __('messages.Featured')}}</li>
                              </ul>
                           </div>
                           @endif

                        </div>
                        <div class="tc_content">
                           <div class="d-flex justify-content-between flex-wrap align-items-center">
                              <p class="txt-truncate sec-color"> {{$selleritemdetail['itemdate']}}
                              </p>
                              <div class="txt-truncate mb-1">
                                 {{$selleritemdetail['itemtitle']}}</div>
                              <div class="price-dis">
                                 <span class="dollor">{{$selleritemdetail['itemcurrency']}}</span>
                                 <span class="ml-1">{{$selleritemdetail['itemprice']}}</span>
                              </div>
                           </div>
                        </div>
                     </div>
                  </a>
               </div>
                @endforeach
            </div>
         </div>
      </section>
   @endif



 <!-- Modal -->
      <div class="sign_up_modal modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
           <div class="modal-content">
              <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
              </div>
           @auth		
            @php $reviewuserdetail = $myClass->get_reviewdetails(Auth::user()->_id, $itemdetails->userId); @endphp
	   @else
            @php $reviewuserdetail = ""; @endphp
	   @endauth		

            <?php // print_r($reviewuserdetail); ?>
              <div class="modal-body container pb20">
                <div class="mbp_comment_form style2">
                    <h4>Write a Review</h4>
                    <ul class="sspd_review">
                       <li class="list-inline-item">
  <div class='rating-stars text-center'>
<ul id='stars' class="mb0">

<?php if(empty($reviewuserdetail))
{ 
$reviewmesssage = "";
$averageRating = "0";
   ?>
      <li class='star' data-value='1'>
        <i class='fa fa-star fa-fw'></i>
      </li>
      <li class='star' data-value='2'>
        <i class='fa fa-star fa-fw'></i>
      </li>
      <li class='star' data-value='3'>
        <i class='fa fa-star fa-fw'></i>
      </li>
      <li class='star' data-value='4'>
        <i class='fa fa-star fa-fw'></i>
      </li>
      <li class='star' data-value='5'>
        <i class='fa fa-star fa-fw'></i>
      </li>
<?php
} else {
 $averageRating = $reviewuserdetail[0]['rating'];
 $reviewmesssage = $reviewuserdetail[0]['message'];
     for ($i = 1; $i <= 5; $i++) {
         if ($i <= $averageRating) {
             echo "<li class='star selected' data-value='".$i."'><i class='fa fa-star fa-fw'></i></li>";
         } else {
             echo "<li class='star' data-value='".$i."'><i class='fa fa-star fa-fw'></i></li>";
         }
     }
}
?>
    </ul>
</div>
                       </li>
                      
                    </ul>

 <div class='success-box'>
    <div class='clearfix'></div>
    <div class='text-message'></div>
</div>
                    <form method="post"  action="{{ route('product.reviewrating') }}" class="comments_form">
                     @csrf 
                       
                       <div class="form-group">
                          <textarea class="form-control review_desc" name="reviewsellermessage" id="exampleFormControlTextarea1"
                             rows="7" placeholder="Your Review">{{$reviewmesssage}}</textarea>
                       </div>

                     <input type="hidden" value="{{$itemdetails->_id}}" name="reviewitemid" id="review_itemid" />
                     <input type="hidden" value="{{$itemdetails->userId}}" name="reviewsellerid" id="review_sellerid" />
                     <input type="hidden" value="{{$averageRating}}" name="reviewrating" id="review_rating" />

                       <button onclick="return validatereview();" class="btn btn-thm float-right">Submit Review <span
                          class="flaticon-right-arrow-1-1"></span></button>
                    </form>
                    <span class="errorMessageproduct" id="seller_review_em"></span>
                 </div>
              </div>
           </div>
        </div>
     </div>
     <input type="hidden" id="seller_id" value="<?php echo $itemdetails['userId']; ?>">
      <input type="hidden" id="item_id" value="<?php echo $itemdetails['_id']; ?>">
      <input type="hidden" id="user_id" value="<?php echo Auth::id(); ?>">
   <script>
      var baseURL = "{{ url('/') }}";
   function get_to_chat() {
      var userId = $('#user_id').val();
      var sellerId = $('#seller_id').val();
      var itemId = $('#item_id').val();
      $.ajax({
            url: baseURL + "/chat/createchat",
            type: "POST",
            dataType : "html",
            data:{ userId : userId, sellerId : sellerId, itemId : itemId, type : 'user' },
            success: function (res) {
               if(res){
                  console.log(res);
                  var response = JSON.parse(res);
                  console.log(response);
                  var status = response.status;
                  var message = response.message;
                  if(status == 'false') {
                     $('#create_chat_err').html(message);
                  }
                  else {
                     var short_code = response.short_code;
                     if(short_code == 'new') {
                        $.ajax({
                              url: baseURL + "/chat/postmessage",
                              type: "POST",
                              dataType : "html",
                              async : false,
                              data:{ userId : userId, chatId : response.chat_id, message : 'Be safe while bought product from seller' },
                              success: function (res1) {
                                 if(res1){
                                    return false;
                                 }
                                 else{
                                    return false; 
                                 }
                              }
                        });
                     }
                     window.location.href = "<?php echo URL::to('/chat/view/')."/" ?>"+''+response.chat_id;
                  }
                  return false;
               }
               else{
                  return false; 
               }
            }
      });
   }
   </script>


@endsection
     
