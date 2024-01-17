<div class="payment_modal modal fade bd-Delet-modal-lg{{$userAddress['_id']}}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="flaticon-close"></i> </button>
                </div>

                <div class="modal-body container pb20">
                    <div class=" mb-4">
                        <h4 class="text-center fz20">Are you want to Delete ?</h4>
                    </div>

                    <div class="my_profile_setting_input d-flex justify-content-center">
                        <a href="{{route('site.profile.deleteaddress' , ['addressId' => $userAddress['_id']])}}"><button class="btn btn2 m-0">Yes</button></a>
                        <button class="btn btn1" data-dismiss="modal" aria-label="Close">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>