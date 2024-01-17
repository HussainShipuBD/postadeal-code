<div class="col-md-12 col-lg-3">
                        <div class="dashboard_navigationbar ">
                            <div class="dropdown position-relative">
                                <div class="dn db-992">
                                    <button onclick="myFunction()" class="dropbtn ">
                                        <i class="fa fa-bars pr10"></i>
                                        Dashboard Navigation </button>
                                </div>

                      <div class="dashboard_sidebar_menu " id="myDropdown">
                                    <ul class="sidebar-menu">
                                        <li class="">
                                            <div class="sidebar_prof-detail p-3">

                                            <div class=" style2 
                                         d-flex align-items-center justify-content-start  
                                          justify-content-lg-center justify-content-xl-start  
                                          flex-wrap">
                                                <div class="text-center position-relative">
                                            <?php 
                                                if(!empty($userdetail['image']) && isset(($userdetail['image']))) {
                                                     $imageurl = url('/storage/app/public/users/thumb100/'.$userdetail['image']);
                                                     $imagename = $userdetail['image']; 
                                                } else {
                                                      $imageurl = url('/storage/app/public/users/thumb100/default.png');
                                                     $imagename = 'default.png'; 
                                                }
                                                 ?> 
                                                    <img class="h80 w80 obj_cov rounded-circle"
                                                        src="{{$imageurl}}" alt="{{$imagename}}"/>

                                                        <!--<div class="prime_tag">
                                                            <img src="images/prime.png" alt="prime.png">
                                                         </div>-->
                                                </div>

                                                <div class=" ml-2 mx-sm-3 mt-xl-0 mt-lg-4">
                                                    <h3 class="white-color ">{{$userdetail->name}}</h3>
                                                    <!--<p class="wel_text">Welcome to you !</p>-->

                                                    <div class="d-flex  align-items-center mt-2">

                                                        <div class="star-review">
                                                           <i class="flaticon-star white-color fz11 "></i>
                                                           <span class="ml-1 white-color">{{$reviewratingtotal}}</span>
                                                        </div>
                 
                                                        <div class="mx-2">{{$reviewdetailcount}} reviews </div>
                 
                                                     </div>
                                                </div>


                                            </div>

                                            <!--<span href="#" data-toggle="modal"
                                            data-target=".bd-example-modal-lg">
                                                <button type="button" 
                                                class="btn btn-log btn-block btn-thm2 bdrs8 mt-5">
                                                   Become a Prime User</button> 
                                                </span>-->
                                        </div>

                                        </li>
                                        <!--<li class="title"><span>Main</span></li>-->
									<?php //if(isset($loginuserId)) { ?>
                                        <li class="treeview  @if($view == 'mylisting') active @endif">
                                            <a href="{{ route('site.profile.mylistings', ['userId' => $userId]) }}"><i class="flaticon-file icon-show"></i>
                                                <span>My Listing</span></a>
                                        </li>
                                    <?php //} else { ?>
                                        <!--<li class="treeview  @if($view == 'mylisting') active @endif">
                                            <a href="{{ route('site.profile.mylistings', ['userId' => $userId]) }}"><i class="flaticon-file"></i>
                                                <span>Listings</span></a>
                                        </li>-->

                                    <?php //} ?>
										<li class="treeview @if($view == 'favourites') active @endif">
                                            <a href="{{ route('site.profile.favourites')}}"><i class="flaticon-heart icon-show"></i>
                                                <span>Favourites</span></a>
                                        </li>

                                    <?php //if($loginuserId == $userId) { ?>
                                        <li class="treeview @if($view == 'editprofile') active @endif">
                                            <a href="{{ route('site.profile.editprofile')}}">
                                                <i class="flaticon-user icon-show"></i><span>
                                                    Edit Profile</span></a>
                                        </li>
										 <li class="treeview ">
                                            <a href="setting.html">
                                                <i class="flaticon-settings icon-show"></i><span>
                                                    Settings</span></a>
                                        </li>

                                        <li class="treeview @if($view == 'myaddress') active @endif">
                                            <a href="{{ route('site.profile.myaddress')}}">
                                                <i class="flaticon-newspaper icon-show"></i>
                                                <span>My Address </span></a>
                                        </li>

                                        <li class="treeview @if($view == 'myorders') active @endif">
                                            <a href="{{ route('site.order.myorders')}}">
                                                <i class="flaticon-online-shopping icon-show"></i>
                                                <span>My Orders </span></a>
                                        </li>

                                        <li class="treeview @if($view == 'mysales') active @endif">
                                            <a href="{{ route('site.order.mysales')}}">
                                                <i class="flaticon-received icon-show"></i>
                                                <span>My Sales </span></a>
                                        </li>

                                        <li class="treeview"><a href="messages.html">
                                                <i class="flaticon-messenger icon-show"></i><span>
                                                       Message</span></a></li>

                                        <li class="treeview @if($view == 'activepromotion' || $view == 'expirepromotions' || $view == 'promotiondetails') active @endif"><a href="{{ route('site.profile.activepromotions')}}">
                                                <i class="flaticon-megaphone icon-show"></i><span>
                                                    Featured ads</span></a></li>
													
												<li class="treeview"><a href="notification.html"><i class="flaticon-bell icon-show"></i>
                                                <span>Notifications</span></a></li>
												
                                        <li class="treeview "><a href="review.html"> 
                                            <i class="flaticon-star-of-favorites-outline icon-show"></i>
                                            <span>Ratings and  Reviews</span></a></li>
                                    <?php //} ?>
                                    </ul>
                                </div>
                              </div>
                          </div>
                    </div>
