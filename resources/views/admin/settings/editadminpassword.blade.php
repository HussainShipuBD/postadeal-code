@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')


    <div class="main-panel">
          
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Change Password</h4>
                    <form class="forms-sample" action="{{ route('settings.adminpasswordupdate') }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                      <div class="form-group">
                        <label for="exampleInputName1">Old Password</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Old Password" name="admin_old_password" value="" required>

                         @if ($errors->has('admin_old_password'))<p class="text-danger">{{ $errors->first('admin_old_password') }}</p>@endif

                      </div>


                      <div class="form-group">

                        <label for="exampleInputName2">New Password</label>
                        <input type="text" class="form-control" id="exampleInputName2" placeholder="New Password" name="admin_new_password" value="" required>

                        @if ($errors->has('admin_new_password'))<p class="text-danger">{{ $errors->first('admin_new_password') }}</p>@endif

                      </div>

                       <div class="form-group">

                        <label for="exampleInputName2">Confirm Password</label>
                        <input type="text" class="form-control" id="exampleInputName2" placeholder="Confirm Password" name="admin_confirm_password" value="" required>

                         @if ($errors->has('admin_confirm_password'))<p class="text-danger">{{ $errors->first('admin_confirm_password') }}</p>@endif

                      </div>


                      
                        
                          
                      <button type="submit" class="btn btn-success mr-2">Submit</button>
                      
                    </form>
                  </div>
                </div>
              </div>
</div>
</div>

@include('admin.layouts.footer')
