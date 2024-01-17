@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')


    <div class="main-panel">
          
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Stripe Settings Management</h4>
                    <form class="forms-sample" action="{{ route('settings.stripesettingsupdate') }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label radio-label">Stripe Type</label>
                            <div class="col-sm-4">
                              <div class="form-radio">
                                <label class="form-check-label">
                                  <input type="radio" class="form-check-input" name="stripetype" id="membershipRadios1" value="live" <?php if($settings->stripeType == 'live')echo 'checked'?>> Live </label>
                              </div>
                            </div>
                            <div class="col-sm-5">
                              <div class="form-radio">
                                <label class="form-check-label">
                                  <input type="radio" class="form-check-input" name="stripetype" id="membershipRadios2" value="sandbox" <?php if($settings->stripeType == 'sandbox')echo 'checked'?>> Sandbox </label>
                              </div>
                            </div>
                          </div>
                        </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Stripe Public Key</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Stripe Public Key" name="publickey" value="{{$settings->publickey}}" required>
                         @if ($errors->has('publickey'))<p class="text-danger">{{ $errors->first('publickey') }}</p>@endif
                      </div>

                       <div class="form-group">

                        <label for="exampleInputName2">Stripe Private Key</label>
                        <input type="text" class="form-control" id="exampleInputName2" placeholder="Stripe Private Key" name="privatekey" value="{{$settings->privatekey}}" required>
                         @if ($errors->has('privatekey'))<p class="text-danger">{{ $errors->first('privatekey') }}</p>@endif
                      </div>
                          
                      <button type="submit" class="btn btn-success mr-2">Submit</button>
                      
                    </form>
                  </div>
                </div>
              </div>
</div>
</div>

@include('admin.layouts.footer')
