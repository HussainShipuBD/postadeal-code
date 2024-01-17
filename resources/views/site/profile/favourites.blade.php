<?php
use App\Classes\MyClass;
$myClass = new MyClass();
?>


@extends('layouts.head')
@section('title', 'Favourites')
@section('content')  





<div class="wrapper ovh position-relative">


        <section>

            <div class="container">

                <div class="breadcrumb_content style2 mt-3 ml-0 d-flex justify-content-between ">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active text-thm" aria-current="page">Favourites</li>
                    </ol>




                </div>

                <div class="row mt-3  mb-5 detail_common_row">

                	@include('site.profile.profilemenu')


                <div class="col-md-12 col-lg-9">

                        <section>
                            <div class="row ">
                                <div class="col-lg-12">
                                    <div class="my_dashboard_review mb40">
                                        <div class="row">
                                            <div class="col-xl-6 ml-0 my-3">

                                                <h3 class="white-nowrap h3">Favourites</h3>

                                            </div>
                                        </div>

                                        <div class="favorite_item_list">

                                       <?php if(!empty($useritems)) { ?>
                                       @foreach($useritems as $useritems)

                                            <div class="feat_property list favorite_page position-relative ">
                                                <a href="{{ route('product.show', ['itemId' => $useritems['itemid']]) }}" class="overlaylink"></a>
                                                <div class="thumb">
                                                    <img class="img-whp" src="{{url('/storage/app/public/products/thumb300/'.$useritems['itemimage'])}}" alt="{{$useritems['itemtitle']}}">
                                                    <div class="thmb_cntnt">
                                                        <ul class="tag mb0">
                                                            <li class="list-inline-item dn"></li>

                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="details">
                                                    <div class="tc_content">
                                                        <p class="txt-truncate sec-color">{{$useritems['itemdate']}}</p>
                                                        <div class="text-gray-color mb-1">
                                                            <span>ID :</span>
                                                            <span class="txt-truncate ">{{$useritems['itemid']}}</span>
                                                        </div>
                                                        <h4>{{$useritems['itemtitle']}}</h4>
                                                        {{$useritems['itemcurrency']}}{{$useritems['itemprice']}}
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            @endforeach

                                            <?php } else { ?>

                                                <div class="feat_property list favorite_page">
                                                                <h3>No products found.</h3>
                                                            </div>

                                            <?php } ?>





                                            @if($itemscount > 5)
                                            <div class="mbp_pagination">
                                                <ul class="page_navigation">
                                                    <li class="page-item @if($page == 1) disabled @endif">
                                                    <a class="page-link" href="{{ route('site.profile.favourites', ['page' => $pageLeft]) }}" tabindex="-1"
                                                            aria-disabled="true">
                                                            <span class="flaticon-left-arrow"></span></a>
                                                    </li>
                                                    <?php
                                                    $pagecount  = $itemscount / 5;
                                                    $pageremain = $itemscount % 5;

                                                    if($pageremain > 0) {
                                                    	$pagecount =  (int)$pagecount + 1;
                                                    }

                                                    for($i = 1; $i <= $pagecount; $i++) { ?>
                                                    <li class="page-item @if($page == $i) active @endif">

                                                    	<a class="page-link" href="{{ route('site.profile.favourites', ['page' => $i]) }}">{{$i}}

                                                    	@if($page == $i)
                                                    		<span class="sr-only">(current)</span>
                                                    	@endif
                                                    	</a>

                                                    </li>

                                                	<?php } ?>
                                                   
                                                    
                                                    <li class="page-item @if($page == $pagecount) disabled @endif">
                                                        <a class="page-link" href="{{ route('site.profile.favourites', ['page' => $pageRight]) }}"><span
                                                                class="flaticon-right-arrow-1"></span></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            @endif

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

