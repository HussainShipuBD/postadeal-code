@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')


    <div class="main-panel">
          
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Default Settings Management</h4>
                    <form class="forms-sample" action="{{ route('settings.defaultsettingsupdate') }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                      <div class="form-group">
                        <label for="exampleInputName1">Site Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Site Name" name="site_name" value="{{$settings->siteName}}" required>
                        @if ($errors->has('site_name'))<p class="text-danger">{{ $errors->first('site_name') }}</p>@endif

                      </div>

                      <div class="form-group">
                        <label for="exampleTextarea1">Site Description</label>
  <textarea class="form-control" id="exampleTextarea1" rows="2" name="site_desc" required>{{$settings->siteDesc}}</textarea>
                        @if ($errors->has('site_desc'))<p class="text-danger">{{ $errors->first('site_desc') }}</p>@endif

                      </div>


                      <div class="form-group">

                        <label for="exampleInputName2">Contact Mail ID</label>
                        <input type="text" class="form-control" id="exampleInputName2" placeholder="Contact Email" name="contact_email" value="{{$settings->contactEmail}}" required>
                        @if ($errors->has('contact_email'))<p class="text-danger">{{ $errors->first('contact_email') }}</p>@endif

                      </div>

                      <div class="form-group">

                        <label for="exampleInputName2">Copyright Text</label>
                        <input type="text" class="form-control" id="exampleInputName2" placeholder="Copyright" name="copyright" value="{{$settings->copyrightText}}" required>
                        @if ($errors->has('copyright'))<p class="text-danger">{{ $errors->first('copyright') }}</p>@endif

                      </div>

                      <div class="form-group">

                        <label for="exampleInputName2">Playstore URL</label>
                        <input type="text" class="form-control" id="exampleInputName2" placeholder="Playstore URL" name="playstore" value="{{$settings->playstoreLink}}" required>
                        @if ($errors->has('playstore'))<p class="text-danger">{{ $errors->first('playstore') }}</p>@endif

                      </div>

                      <div class="form-group">

                        <label for="exampleInputName2">Appstore URL</label>
                        <input type="text" class="form-control" id="exampleInputName2" placeholder="Appstore URL" name="appstore" value="{{$settings->appstoreLink}}" required>
                          @if ($errors->has('appstore'))<p class="text-danger">{{ $errors->first('appstore') }}</p>@endif

                      </div>

                      <div class="form-group">

                        <label for="exampleInputName2">Facebook URL</label>
                        <input type="text" class="form-control" id="exampleInputName2" placeholder="Facebook URL" name="facebook" value="{{$settings->facebookURL}}" required>
                          @if ($errors->has('facebook'))<p class="text-danger">{{ $errors->first('facebook') }}</p>@endif

                      </div>

                      <div class="form-group">

                        <label for="exampleInputName2">Twitter URL</label>
                        <input type="text" class="form-control" id="exampleInputName2" placeholder="Twitter URL" name="twitter" value="{{$settings->twitterURL}}" required>
                          @if ($errors->has('twitter'))<p class="text-danger">{{ $errors->first('twitter') }}</p>@endif

                      </div>

                      <div class="form-group">

                        <label for="exampleInputName2">Linkedin URL</label>
                        <input type="text" class="form-control" id="exampleInputName2" placeholder="Linkedin URL" name="linkedin" value="{{$settings->linkedinURL}}" required>
                          @if ($errors->has('linkedin'))<p class="text-danger">{{ $errors->first('linkedin') }}</p>@endif

                      </div>
                      

                        
                          
                      <button type="submit" class="btn btn-success mr-2">Submit</button>
                      
                    </form>
                  </div>
                </div>
              </div>
</div>
</div>

@include('admin.layouts.footer')
