@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')

    <div class="main-panel">
          
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Logo Management</h4>
                    
                    <form class="forms-sample" action="{{ route('settings.logoupdate') }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                      
                     
                      <div class="form-group">
                        <label for="exampleInputFile1"><b>Site Icon</b></label>
                        <input type="file" accept="image/png" id="wizard-picture" name="site_icon" class="form-control m-b15 p-2 borderGrey w-100"><br>
                        
                        <img src="{{url('/storage/app/public/admin_assets/fav-icon')}}" class="borderCurve borderGradient picture-src dnone" id="wizardPicturePreview"
              style="width:100px;height:100px;object-fit: cover; margin-top:20px;">
              @if ($errors->has('site_icon'))<p class="text-danger">{{ $errors->first('site_icon') }}</p>@endif
                      </div>

                      <div class="form-group">
                        <label for="exampleInputFile1"><b>Site Lite Logo</b></label></br>
                         <label for="exampleInputFile1">Note: It's using for Landing Page and Admin Side Menu</label>
                        <input type="file" accept="image/image/gif,image/jpeg" id="wizard-picture-add" name="site_logo" class="form-control m-b15 p-2 borderGrey w-100"><br>
                        
                        <img src="{{url('/storage/app/public/admin_assets/logo.png')}}" class="borderCurve borderGradient picture-src dnone" id="wizardPicturePreviewAdd"
              style="width:100px;height:100px;object-fit: cover; margin-top:20px;">
                            @if ($errors->has('site_logo'))<p class="text-danger">{{ $errors->first('site_logo') }}</p>@endif
                       


                      </div>

                      <div class="form-group">
                        <label for="exampleInputFile1"><b>Site Dark Logo</b></label></br>
                        <label for="exampleInputFile1">Note: It's using for Mail Template and Admin Login Page</label>

                        <input type="file" accept="image/image/gif,image/jpeg" id="wizard-picture-dark" name="site_dark" class="form-control m-b15 p-2 borderGrey w-100"><br>
                        
                        <img src="{{url('/storage/app/public/admin_assets/dark.png')}}" class="borderCurve borderGradient picture-src dnone" id="wizardPicturePreviewDark"
              style="width:100px;height:100px;object-fit: cover; margin-top:20px;">
                            @if ($errors->has('site_dark'))<p class="text-danger">{{ $errors->first('site_dark') }}</p>@endif

                      </div>
                      
                      <button type="submit" class="btn btn-success mr-2">Submit</button>
                      
                    </form>
                  </div>
                </div>
              </div>
</div>
</div>
@include('admin.layouts.footer')
