<div class="payment_modal modal fade bd-promote-modal-lg px-3" id="promotion_popup" tabindex="-1" role="dialog" aria-hidden="true">
    <input type="hidden" id="promotion_item" value="">
    <input type="hidden" id="userId" value="{{$loginuserId}}">
    <input type="hidden" id="promotioncurrency" value="{{$myClass->site_settings()->promotioncurrencycode}}">
    <input type="hidden" id="stripepublickey" value="{{$myClass->site_settings()->publickey}}">

        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom">

                    <div class="features_text_heading w-100">
                        Promote your listing
                    </div>

                <?php if(Session::has('notification') && Session::get('notification.product-type') == "success") { ?>

                    <a href="{{ route('site.profile.promotionreturn') }}"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="flaticon-close"></i> </button></a>

                    <?php } else { ?>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="flaticon-close"></i> </button>

                    <?php } ?>
                </div>

                <div class="modal-body container pb20 px-0 pt-0">

                    <div class="modal_insidebody_scroll">
                        <div class=" modal_radiobox mb-2">
                            <div class="ui_kit_checkbox style2 radioboxstyle">

                                @foreach($promotiondetails as $key => $promotiondetails)
                                <div class="custom-control custom-checkbox   ">
                                    <input type="checkbox" class="custom-control-input" value="{{$promotiondetails['_id']}}"
                                        id="customCheck80">
                                    <label id="checkbox_labid{{$key}}" class="custom-control-label 
                              checkbox_labid{{$key}} d-flex justify-content-between " for="customCheck80">
                                        <span>{{$promotiondetails['duration']}} days</span>

                                        <div class="amount w60">
                                            <span>{{$myClass->site_settings()->promotioncurrencysymbol}}</span> <span>{{$promotiondetails['price']}}</span>
                                        <input type="hidden" id="promotionamount{{$promotiondetails['_id']}}" value="{{$promotiondetails['price']}}">

                                        </div>
                                    </label>

                                </div>
                                @endforeach
                                
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
                            <h4 class="p-3">See Below Example</h4>
                            <div class="d-flex align-items-center justify-content-around flex-nowrap mb-3">

                                    <div class="dummycard_feat_property feat_property home3">
                                       


                                        <div class="featured_thumb-bg ">
                                    
                                               
                                            <div class="thmb_cntnt">
                                               
                                                <ul class="tag mb0 featured_tag-bg">
													Featured
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
                           
                            
                                    <div class="dummycard_feat_property feat_property home3">


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

                    <a href="{{ route('promotion.stripepaycreation') }}" return id="submitpromotion">
                        <div class=" pay_btn btn-thm white-color mx-3
                          d-flex justify-content-center align-items-center h45 ">
                            Confrim
                        </div>
                    </a>
                    <div class="promotion-alert">Please select any one promotion plan</span>



                </div>
            </div>
        </div>
    </div>

<script src="https://js.stripe.com/v3/"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script type='text/javascript'>

    var baseURL = "{{ url('/') }}";

    jQuery('#submitpromotion').live('click',function(e) {

        var promotionId = $("input:checkbox:checked").val();

        //var check = $('#customCheck80:checkbox:checked').length;

        //alert(check);

        if(typeof promotionId == 'undefined'){
            $('.promotion-alert').show();
            return false;
        } else {

            $('.promotion-alert').hide();

            var promotionId = $("input:checkbox:checked").val();

            var itemId = $('#promotion_item').val();

            var userId = $('#userId').val();

            var amount = $('#promotionamount'+promotionId).val();

            var currency = $('#promotioncurrency').val();

            var stripekey = $('#stripepublickey').val();

            var stripe = Stripe(stripekey);


            $.ajax({
                url: baseURL + "/promotion/stripepaycreation",
                type: "POST",
                dataType : "json",
                data:{ promotionId : promotionId, amount : amount, itemId : itemId, userId : userId, currency : currency },
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
    .promotion-alert {
        color:red; 
        display:none; 
        text-align: center;
    }
</style>