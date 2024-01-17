<!DOCTYPE html>
<html dir="ltr" lang="en">
   <!-- Mirrored from creativelayers.net/themes/findhouse-html/index2.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Aug 2021 12:45:48 GMT -->
   <head>
     <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="advanced custom search, agency, agent, business, clean, corporate, directory, google maps, homes, idx agent, listing properties, membership packages, property, real broker, real estate, real estate agent, real estate agency, realtor">
	<meta name="description" content="FindHouse - Real Estate HTML Template">
	<meta name="CreativeLayers" content="ATFN">
	<!-- css file -->
	<link rel="stylesheet" href="{{ URL::asset('public/front/css/bootstrap.min.css') }}">
	<!-- <link rel="stylesheet" href="css/style.css"> -->
	<link rel="stylesheet" href="{{ URL::asset('public/front/css/style.css') }}">
	<!-- Responsive stylesheet -->
	<link rel="stylesheet" href="{{ URL::asset('public/front/css/responsive.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('public/front/css/carousel.css') }}">


	<link rel="stylesheet" type="text/css" href="{{ URL::asset('puplic/css_root/flaticon.css') }}">
	<!-- Title -->
	<title>Classibuy </title>
	<!-- Favicon -->
	<link href="{{url('/storage/app/public/admin_assets/fav-icon')}}" sizes="70x70" rel="shortcut icon" type="image/x-icon" />
	<link href="{{url('/storage/app/public/admin_assets/fav-icon')}}" sizes="70x70" rel="shortcut icon" />
</head>
   <body>
   	@include('admin.layouts.flashmessage')
<?php
use App\Classes\MyClass;
$myClass = new MyClass();
$site_settings = $myClass->site_settings(); 
?>

     <!-- <div class="preloader"></div> -->

    <!-- Main Header Nav -->
    <div class="sticky-top ">
       <header class="header-nav menu_style_home_one style2 navbar-scrolltofixed stricky 
		headerresponse ">
			<div class="container-fluid p0">
				<!-- Ace Responsive Menu -->
				<nav class="d-xl-flex align-items-xl-center justify-content-xl-between h-md-0">

					<a href="{{ url('/') }}" class="navbar_brand">
						<img class="logo2 img-fluid" src="{{url('/storage/app/public/admin_assets/dark.png')}}" alt="web_logo.png">
						
					</a>

					<div class="d-flex w100 h-xl-25 flex-xl-row flex-column-reverse response-postions ">

						<div class="sasw_list style2 mb0 ml-xl-auto d-flex flex-wrap 
							flex-sm-nowrap align-items-center justify-content-center ">
							<div class="search_area locfield">
								<div class="d-flex">
									<!-- <label for="exampleInputEmail">
									<span class="flaticon-maps-and-flags"></span> </label> -->
									<label for="exampleInputEmail">
										<span class="flaticon-loupe"></span></label>
									<!-- <input id="contfilter" onfocus="get_autocomplete();"
										onfocusout="close_autocomplete()"
										onkeyup="change_ico(); filtersearch(this.value);" type="text"
										placeholder="{{ __('messages.Search Queries')}}" id="autocomplete" class="search-inputbox tagbox"
										placeholder="Location" autocomplete="off" /> -->

										<input type="text" name="autocomplete" id="autocomplete" value="<?php echo Session::get('locationname'); ?>" class="search-inputbox tagbox" placeholder="{{ __('messages.Enter Location') }}">

									<span class="locaend-icons">
										<span class="flaticon-down-arrow" id="rotate_arr" onclick="locationsearch();"> </span>
										
									</span>


									<!-- <input type="text" id="address"  class="form-control" /> -->


								</div>
							</div>


							<div class="d-flex border-none locationfield">
								<div class="search_area sercfield">
									<form method="GET"  action="{{ route('search', ['catId' => 'itemname']) }}" id="itemnamesearch-form">	
									<div class="d-flex">
										<!-- <label for="exampleInputEmail">
									<span class="flaticon-loupe"></span></label> -->
										<input type="text" name="itemnamesearch" class="form-control-item-search form-control" id="itemnamesearch"
											placeholder="{{ __('messages.keywords')}}">
									</div>

								</div>

								<span class="search_option_button">
									<button class="btn-thm gobtn" onclick="itemnamesearch();">
										<span class="flaticon-loupe"></span></button>
								</span>
							</form>
							</div>

						</div>
						<div class="d-flex align-items-center  ml-auto mb-sm-4 mb-xl-0">
							<ul class="d-flex align-items-center m-0 ">

								<!-- login register btn  -->
								@auth	
								
								<li class=" list_s">

									<div class="headernav-lastdivs">

										<a href="#" class="btn" href="#" data-toggle="dropdown">
										<i class="flaticon-bell"></i>
											
										</a>

										<div class="dropdown-menu">

											<ul class="top_bar_content">

												<li class="dropdown-item ">
													<div class="top_bar_dropdwn">
														<div class="w50 h50">
															<img class="rounded-circle hf100 w75 obj_cov"
																src="images/team/12.jpg" alt="fp1.jpg">
															<div class="thmb_cntnt">
																<ul class="tag mb0">
																	<li class="list-inline-item dn"></li>

																</ul>
															</div>
														</div>

														<div class="details">
															<div class="tc_content py-2">
																<h4>Renovated Apartment</h4>
																<p>Lorem ipsum dolor, sit amet consectetur
																	adipisicing elit. A, laboriosam.</p>
															</div>
														</div>
													</div>
												</li>
												<div class="custom_hr"></div>

												<li class="dropdown-item ">
													<div class="top_bar_dropdwn">
														<div class="w50 h50">
															<img class="rounded-circle hf100 w75 obj_cov"
																src="images/team/12.jpg" alt="fp1.jpg">
															<div class="thmb_cntnt">
																<ul class="tag mb0">
																	<li class="list-inline-item dn"></li>

																</ul>
															</div>
														</div>

														<div class="details">
															<div class="tc_content py-2">
																<h4>Renovated Apartment</h4>
																<p>Lorem ipsum dolor, sit amet consectetur
																	adipisicing elit. A, laboriosam.</p>
															</div>
														</div>
													</div>
												</li>
												<div class="custom_hr"></div>

												<li class="dropdown-item ">
													<div class="top_bar_dropdwn">
														<div class="w50 h50">
															<img class="rounded-circle hf100 w75 obj_cov"
																src="images/team/12.jpg" alt="fp1.jpg">
															<div class="thmb_cntnt">
																<ul class="tag mb0">
																	<li class="list-inline-item dn"></li>

																</ul>
															</div>
														</div>

														<div class="details ml-2">
															<div class="tc_content">
																<h4>Renovated Apartment</h4>
																<p>Lorem ipsum dolor, sit amet consectetur
																	adipisicing elit. A, laboriosam.</p>
															</div>
														</div>
													</div>
												</li>
												<div class="custom_hr"></div>
												<li class="seeall">
													<div class="fz16 text-center  my-2">
														<a href="#">See All </a>
													</div>
												</li>

											</ul>
										</div>
												
										<span class="classified-header-har-line"></span>


								<li class="">

									<a href="#" class="btn chat-icon " href="#" data-toggle="dropdown">
										<i class="flaticon-messenger"></i>
               
									</a>

									<div class="dropdown-menu">

										<ul class="top_bar_content">

											<li class="dropdown-item ">
												<div class="top_bar_dropdwn">
													<div class="w50 h50">
														<img class="rounded-circle hf100 w75 obj_cov"
															src="images/team/14.jpg" alt="fp1.jpg">
														<div class="thmb_cntnt">
															<ul class="tag mb0">
																<li class="list-inline-item dn"></li>

															</ul>
														</div>
													</div>

													<div class="details">
														<div class="tc_content py-2">
															<h4>Renovated Apartment</h4>
															<p>Lorem ipsum dolor, sit amet consectetur
																adipisicing elit. A, laboriosam.</p>
														</div>
													</div>
												</div>
											</li>

										</ul>
									</div>

								</li>

								<span class="classified-header-har-line"></span>

								<li class="user_setting">
									<div class="dropdown">
										<a class="btn dropdown-toggle" href="#" data-toggle="dropdown">
											<div class="d-flex  h45 w45">
												<?php $userimage = (isset(auth()->user()->image) && auth()->user()->image!='') ? auth()->user()->image : 'default.png'; 
												?>
												<img class="rounded-circle h100p w100 obj_cov" src="{{url('/storage/app/public/users/thumb100/'.$userimage)}}"
													alt="{{$userimage}}">
											</div>
										</a>
										<div class="dropdown-menu">

											<div class="user_setting_content">
												<a class="dropdown-item active" href="{{ route('site.profile.editprofile') }}">My Profile</a>
												<a class="dropdown-item" href="{{ route('site.chat.view') }}">Messages</a>
												<a class="dropdown-item" href="#">Purchase history</a>
												<a class="dropdown-item" href="#">Help</a>
												<a class="dropdown-item" href="{{ route('logout') }}">Log out</a>
											</div>
										</div>
									</div>
								</li>

								<div class="d-lg-block d-none">
									<div class="sellbtn ">
										<a href="{{ route('product.sell') }}"><span class="flaticon-plus"></span> {{ __('messages.Sell') }}</a>
									</div>

								</div>
						</div>

						</li>
						@else

						<li class="list-inline-item list_s">
									<div class="headernav-lastdivs">
										<div class="logindiv">
											<a href="{{ route('auth.login') }}" class="btn flaticon-user my-2">
												<span class="">{{ __('messages.Login / Register')}}</span></a></div>
	
									<div class="d-lg-block d-none">
												<div class="sellbtn ">
													<a href="{{ route('auth.login') }}"> <span class="flaticon-plus"></span> {{ __('messages.Sell') }}</a>
												</div>
											</div>
									</div>
									</li>

						@endauth

						</ul>
					</div>
			</div>
			</nav>
	</div>


	</header>

</div>

   <section class="stricky ovh respnse_bxshad">
      <div class=" h-md-60">
         <nav id="sn-bar" class="sn-bar sn-bar--transparent">
            <div id="sn-bar__outer-wrap" class="sn-bar__outer-wrap">
               <ul id="overallscroll_div" class="listclass sn-bar__inner-wraps ">
                  <li>
                     <div>
                        <a href="{{ route('search', ['catId' => 'allcat']) }}" class="dropdown-toggles bold classified-for-sale ">{{ __('messages.All categories')}} </a>
                     </div>
                  </li>

						<?php $get_maincategory = $myClass->get_maincategory(); ?>
						@if(!empty($get_maincategory))
	                	@foreach($get_maincategory as $key => $maincategory)	                
	                	<li>
                     <ul class="listul-fcls ">
                        <li>

                           <a class="dropdown-toggles bold classified-for-sale menu-trigger" href="{{ url('/search/cid-'.$maincategory['_id']) }}"
                              style="background:url({{url('/storage/app/public/categories/'.$maincategory['image'])}}) no-repeat scroll left center / 32px auto; ">

                              <div class="">
                                 <span> {{$maincategory['name']}}</span>
                                 <i id="sub-menu-ico_<?php echo $key+1; ?>"
                                    class="flaticon-down-arrow  d-block d-lg-none mx-2">

                                 </i>
                              </div>
                           </a>
                           <input type="checkbox" class="sub-menu-checkbox" id="sub-menu-checkbox_<?php echo $key+1; ?>"
                              onchange="get('<?php echo $key+1; ?>')" name="sub-menu-checkbox" />

                           <ul class=" ul-drop-down sub-menu-dropdown ">
                           	<?php $sub_category = $myClass->get_subcategory($maincategory['_id']); ?>
											@if(!empty($sub_category))
		            			    	@foreach($sub_category as $key => $subcategory)	

                             <li class="sec-li">
                                 <a href="{{ url('/search/subid-'.$subcategory['_id']) }}" class="d-flex justify-content-between"><span>{{$subcategory['name']}}</span>
                                    <span>
                                    	<?php $super_category_check = $myClass->get_supercategory_check($maincategory['_id'], $subcategory['_id']); ?>
                                    	@if($super_category_check == 1)
                                       <i class="fa fa-angle-right fz24 d-none d-lg-inline  "></i>
                                       <i class="fa fa-angle-down fz24 d-inline d-lg-none 	 "></i>
                                       @endif
                                    </span></a>
                                 <input type="checkbox" class="inside_sub-menu-checkbox"
                                    name="sub-menu-checkbox" />
                                 <ul class="subchild-menu-dropdown ">
                                 	<?php $super_category = $myClass->get_supercategory($maincategory['_id'], $subcategory['_id']); ?>
											@if(!empty($super_category))
		            			    	@foreach($super_category as $key => $supercategory)	
                                    <li class="last-li">
                                       <div><a href="{{ url('/search/superid-'.$supercategory['_id']) }}" class="a_link">{{$supercategory['name']}}</a> </div>
                                    </li>
                               @endforeach
						 				@endif
                                 </ul>
                              </li>

                              <!-- <li class="sec-li">
                                            <a href="#" class="d-flex justify-content-between"><span>Mobiles</span>
                                                <span>
                                                    <i class="fa fa-angle-right fz24 d-none d-lg-inline  "></i>
                                                    <i class="fa fa-angle-down fz24 d-inline d-lg-none 	 "></i>
                                                </span></a>
                                            <input type="checkbox" class="inside_sub-menu-checkbox"
                                                name="sub-menu-checkbox" />
                                            <ul class="subchild-menu-dropdown ">
                                                <li class="last-li">
                                                    <div><a href="#" class="a_link">Smartphones</a> </div>
                                                </li>
                                                <li class="last-li">
                                                    <div><a href="#">Normal Phones</a> </div>
                                                </li>
                                            </ul>
                                        </li> -->
                               @endforeach
						 				@endif
                          
                           </ul>
                          
                        </li>
                     </ul>
                  </li>
                @endforeach
			 				@endif
               </ul>
            </div>
         </nav>
      </div>
     </section>
    </div>

 <div class="wrapper ovh position-relative">


@yield('content')

</div>
	<!-- Our Footer -->
	<section class="foo_bottom-div clearfix">
		<div class="footer_one">
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-md-6 col-lg-4 col-xl-4 ">
						<div class="footer_about_widget">
							<h4>{{ __('messages.About Site')}}</h4>
							<p>{{$site_settings['siteDesc']}}</p>

						</div>

						<div class="d-flex justify-content-start align-items-center  my-3 my-md-3">
							<div class="ml-0 ml-lg-0">
								<a href="{{$site_settings['playstoreLink']}}" target="_blank"><img src="{{url('/public/front/images/playstoreicons.png')}}" height="35px" /></a>
							</div>
							<div class="mx-2">
								<a href="{{$site_settings['appstoreLink']}}" target="_blank"><img src="{{url('/public/front/images/playstoreicons.png')}}" height="35px" /></a>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
						<div class="">
							<div class="footer-centimg dn-575">
								<!-- <img src="./images/icons/mobile-phone.png" class="imgfluid" /> -->
							</div>
						</div>
					</div>

					<div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
						<div class="footer_social_widget">
							<h4>{{ __('messages.Follow us')}}</h4>
							<ul class="mb30">
								<li class="list-inline-item"><a href="{{$site_settings['facebookURL']}}"><i class="fa fa-facebook f-28 fb-color"></i></a></li>
								<li class="list-inline-item"><a href="{{$site_settings['twitterURL']}}"><i class="fa fa-twitter f-28 tw-color"></i></a></li>
								<li class="list-inline-item"><a href="{{$site_settings['linkedinURL']}}"><i class="fa fa-google f-28 go-color"></i></a></li>
							</ul>

							<h4>{{ __('messages.Language')}}</h4>
							<div class="candidate_revew_select">
				              <select id="language-selector" class="selectpicker w75 show-tick" onChange="switchlang()">
				                <option value="en"<?php if (Session::get('locale') === "en") {echo "selected";}?>>{{ __('messages.English') }}</option>
				                <option value="fr"<?php if (Session::get('locale') === "fr") {echo "selected";}?>>{{ __('messages.French') }}</option>
				              </select>
							</div>


						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Our Footer Bottom Area -->
		<div class="footer_middle_area footabsol">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-xl-6">
						<div class="footer_menu_widget">
							<ul>
								<li class="list-inline-item"><a href="#">Terms and Policy </a></li>
								<li class="list-inline-item"><a href="#">Tos</a></li>
								<li class="list-inline-item"><a href="#">Safety Tips</a></li>
								<li class="list-inline-item"><a href="#">Reach</a></li>

							</ul>
						</div>
					</div>
					<div class="col-lg-6 col-xl-6">
						<div class="copyright-widget text-right">
							<!-- <p>© 2020 Find House. Made with love.</p> -->
							<!-- <a class="scrollToHome" href="#"> <i class="flaticon-up-arrow"></i></a><i class="flaticon-right-arrow-1-1"></i></a> -->

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<a class="scrollToHome" href="#"> <i class="flaticon-up-arrow"></i></a>
		
	<!-- Wrapper End -->
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- 	<script type="text/javascript" src="{{ URL::asset('public/front/js/jquery-3.3.1.js') }}"></script>
 -->	
 <script type="text/javascript" src="{{ URL::asset('public/front/js/jquery-migrate-3.0.0.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('public/front/js/popper.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('public/front/js/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('public/front/js/jquery.mmenu.all.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('public/front/js/ace-responsive-menu.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('public/front/js/bootstrap-select.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('public/front/js/isotop.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('public/front/js/snackbar.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('public/front/js/simplebar.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('public/front/js/scrollto.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('public/front/js/jquery-scrolltofixed-min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('public/front/js/jquery.counterup.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('public/front/js/wow.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('public/front/js/slider.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('public/front/js/pricing-slider.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('public/front/js/timepicker.js') }}"></script>

	<!-- Custom script for all pages -->
    <script type="text/javascript"> var baseURL= '<?php echo URL::to('/'); ?>'; </script>
	<script type="text/javascript" src="{{ URL::asset('public/front/js/script.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('public/front/js/custom.js') }}"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDrjtoIPgvVT7oQ8IQ_ZLLbjKEatmCFyBI&libraries=places&callback=initMap&language=en"></script>


	<!-- skelton loaders script  -->
<form method="GET"  action="{{ route('search', ['catId' => 'location']) }}" id="locationsearch-page">	
<input type="hidden" id="search-latitude" name="searchlatitude" value="<?php echo Session::get('locationlat'); ?>" class="form-control">
<input type="hidden" id="search-longitude" name="searchlongitude" value="<?php echo Session::get('locationlon'); ?>" class="form-control">
<!-- <input type="hidden" id="search-fulladdress" name="searchfulladdress" class="form-control">
 --></form>

<script>
	
google.maps.event.addDomListener(window, 'load', initialize);

google.maps.event.addDomListener(window, 'load', productinitialize);
      
    </script>

	<script>

		setTimeout(() => {
			fetchData()
		}, 3000)

		function fetchData() {
			const img = document.querySelector('.cardimg')
			const heading = document.querySelector('.heading')
			const tag = document.querySelector('.tag')
			const address = document.querySelector('.address')
			const cardtitle = document.querySelector('.cardtit')

			img.innerHTML = "<img  src='images/agency/1.jpg '/>"
			img.classList.remove('loading')

			heading.innerHTML = "8000 $"
			heading.classList.remove('loading')

			tag.innerHTML = "Featured"
			tag.classList.remove('loading')

			cardtitle.innerHTML = "Renovated Apartment"
			cardtitle.classList.remove('loading')

			address.innerHTML =
				"<span class='flaticon-placeholder m-1'></span>1421 San Pedro St, Los	Angeles, CA 90015"
			address.classList.remove('loading')
		}
	</script>

</body>

</html>
