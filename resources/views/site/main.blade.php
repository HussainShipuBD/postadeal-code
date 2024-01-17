<?php
use App\Classes\MyClass;
$myClass = new MyClass();
?>


@extends('layouts.head')
@section('title', 'Home')
@section('content')	

	<!-- 4th Home Slider -->

		<section class="mb-3 position-relative">

			<div class="home8-sliders">
				<div class="slick-carousel">
					@if(!empty($bannerdetails))
                	@foreach($bannerdetails as $bannerdetail)

						<a href="{{$bannerdetail['url']}}" target="_blank"><img src="{{url('/storage/app/public/banners/'.$bannerdetail['image'])}}" class="home-banner d-xl-block d-none" /></a>

					 @endforeach
					 @endif

				</div>
				<div class="pagingInfo">
				</div>
			</div>


		</section>

		<!-- Feature Properties -->
		<!--<section id="feature-property" class="feature-property  section">
			<div class="container ovh ">
				<div class="row">
					<div class="col-lg-12">
						<div class="main-title ">
							<h2>{{ __('messages.Featured Products')}}</h2>

							<a class="" href="#">
								<div class="d-flex align-items-center">
									<span class="w70">{{ __('messages.View All')}} </span>
									<span class="flaticon-right-arrow-1"></span>
								</div>
							</a>
						</div>-->
						<!-- <div class="col-lg-12"> -->
						<!--<div class="feature_property_home3_slider">


					@if(!empty($itemdetailsfav))
                	@foreach($itemdetailsfav as $itemdetailfav)

							<div class="item">
								<a href="{{ route('product.show', ['itemId' => $itemdetailfav['itemid']]) }}">
									<div class="feat_property home3">
										<div class="thumb">
											<img class="img-whp" src="{{url('/storage/app/public/products/thumb300/'.$itemdetailfav['itemimage'])}}" alt="{{$itemdetailfav['itemtitle']}}">

											<div class="thmb_cntnt">
												<ul class="tag mb0">
													<li class="color-white">{{ __('messages.Featured')}}</li>
												</ul>
											</div>

										</div>
										<div class="details">
									<div class="tc_content">
										<div class="d-flex justify-content-between flex-wrap align-items-center ">
											<p class="txt-truncate sec-color">  {{$itemdetailfav['itemdate']}}
											</p>
											<div class="txt-truncate mb-1">
											{{$itemdetailfav['itemtitle']}}</div>
											<div class="price-dis">
												<span class="dollor">{{$itemdetailfav['itemcurrency']}}</span>
												<span class="ml-1">{{$itemdetailfav['itemprice']}}</span>
											</div>
										</div>
									</div>
										</div>
									</div>
								</a>
							</div>
					 @endforeach
					 @endif
						</div>-->
						<!-- </div> -->
					<!--</div>
				</div>
		</section>-->


		<!-- Feature Properties -->
		<section class="sections zi-1 ">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="main-title">
							<!--<h2> {{ __('messages.Land properties')}}</h2>-->

							<!-- <a class="" href="#">
								<div class="d-flex align-items-center">
									<span class="w70">View All </span>
									<span class="flaticon-right-arrow-1"></span>
								</div>
							</a>
 -->
						</div>
					</div>
				</div>
				<div class="row" id="data-wrapper">
					@if(!empty($itemdetails))
                	@foreach($itemdetails as $itemdetail)
					<div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2">
						<a href="{{ route('product.show', ['itemId' => $itemdetail['itemid']]) }}">
							<div class="feat_property home3">
								<div class="thumb">
									<img class="img-whp" src="{{url('/storage/app/public/products/thumb300/'.$itemdetail['itemimage'])}}" alt="{{$itemdetail['itemtitle']}}">
									@if($itemdetail['itemfeatured'] == '1')
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
                 <div> {{ __('messages.No Result')}} </div>

                 @endif
					
		</section>

		<!-- more items  -->
		<section class="section" id="more-item">
			<div class="moreover ">
				<a id="load_more" class="d-flex justify-content-center ">
					<span class="flaticon-plus"></span>
					<span class="mx-2"> {{ __('messages.More Over')}}</span> </a>
			</div>
		</section>




	</div>
@endsection

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>

		var baseURL = "{{ url('/') }}";
        var page = 1;

		$(document).on('click', '#load_more', function(){
			page++;
            infinteLoadMore(page);
			})	

        function infinteLoadMore(page) {
            $.ajax({
                    url: baseURL + "/loadmoreitem?page=" + page,
                    datatype: "html",
                    type: "get",
                    beforeSend: function () {
                        $('.auto-load').show();
                    }
                })
                .done(function (response) {
                    if (response == "") {
                        $('#more-item').hide();
                        return;
                    }
                    $('.auto-load').hide();
                    $("#data-wrapper").append(response);
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
        }


    </script>

