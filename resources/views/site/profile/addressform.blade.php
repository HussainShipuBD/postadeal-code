<div class="payment_modal  modal fade bd-address-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="features_text_heading w-100">
                        Address
                    </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="flaticon-close"></i> </button>
                </div>

                <div class="modal-body container">
                    <div class="modal_insidebody_scroll">
                        <div class="mbp_comment_form style2">

                            <form class="comments_form" method="POST" action="{{ route('site.profile.saveaddress') }}">

                                <div class="row">

                                    <input type="hidden" value="" id="addressId" name="addressId">

                                    <div class="col-lg-6 col-xl-6">
                                        <div class="my_profile_setting_input form-group">
                                            <label for="formGroupExampleInput1">Name</label>
                                            <input type="text" class="form-control" id="name"
                                                placeholder="" name="name">
                                                <span class="address-error" id="name-error" style="display:none;">Please enter the name</span>
                                        </div>
                                    </div>
                                    <!--<div class="col-lg-6 col-xl-6">
                                        <div class="my_profile_setting_input form-group">
                                            <label for="formGroupExampleEmail">Email</label>
                                            <input type="email" class="form-control" id="formGroupExampleEmail"
                                                placeholder="creativelayers@gmail.com">
                                        </div>
                                    </div>-->

                                    <div class="col-lg-6 col-xl-6">
                                        <div class="my_profile_setting_input form-group">
                                            <label for="formGroupExampleInput4">Address 1</label>
                                            <input type="text" class="form-control" id="address1" name="address1">
                                            <span class="address-error" id="address1-error" style="display:none;">Please enter the Address1</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-6">
                                        <div class="my_profile_setting_input form-group">
                                            <label for="formGroupExampleInput5">Address 2</label>
                                            <input type="text" class="form-control" id="address2" name="address2">
                                            <span class="address-error" id="address2-error" style="display:none;">Please enter the Address2</span>
                                        </div>
                                    </div>
                                   <!-- <div class="col-lg-6 col-xl-6">
                                        <div class="my_profile_setting_input form-group">
                                            <div class="my_profile_setting_input ui_kit_select_search form-group">
                                                <label>Country</label>
                                                <select class="selectpicker" data-live-search="true" data-width="100%">
                                                    <option data-tokens="Turkey">Turkey</option>
                                                    <option data-tokens="Iran">Iran</option>
                                                    <option data-tokens="Iraq">Iraq</option>
                                                    <option data-tokens="Spain">Spain</option>
                                                    <option data-tokens="Greece">Greece</option>
                                                    <option data-tokens="Portugal">Portugal</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>-->
                                    <div class="col-lg-6 col-xl-6">
                                        <div class="my_profile_setting_input form-group">
                                            <label for="formGroupExampleInput6"> Country </label>
                                            <input type="text" class="form-control" id="country" name="country">
                                            <span class="address-error" id="country-error" style="display:none;">Please enter the country</span>
                                        </div>
                                    </div>

                                    <!--<div class="col-lg-6 col-xl-6">
                                        <div class="my_profile_setting_input form-group">
                                            <label for="formGroupExampleInput8">State</label>
                                            <input type="text" class="form-control" id="formGroupExampleInput8">
                                        </div>
                                    </div>-->

                                    <div class="col-lg-6 col-xl-6">
                                        <div class="my_profile_setting_input form-group">
                                            <label for="formGroupExampleInput10">Zip code</label>
                                            <input type="text" class="form-control" id="zipcode" name="zipcode">
                                            <span class="address-error" id="zipcode-error" style="display:none;">Please enter the zipcode</span>
                                        </div>
                                    </div>


                                    <div class="col-lg-6 col-xl-6">
                                        <div class="my_profile_setting_input form-group">
                                            <label for="formGroupExampleInput13">Phone</label>
                                            <input type="text" class="form-control" id="phone" name="phone">
                                            <span class="address-error" id="phone-error" style="display:none;">Please enter the phone</span>
                                        </div>
                                    </div>

                                    <div class="col-xl-12 text-right">
                                        <div class="my_profile_setting_input">
                                            <!-- <button class="btn btn1">View Public Profile</button> -->
                                            <button class="btn btn2" onclick="return validateaddress();">Save Address</button>
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

    <style>
    .address-error {
        color:  red;
    }
    </style>