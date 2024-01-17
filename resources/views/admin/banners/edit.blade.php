@include('admin.layouts.sidebar')

    <div class="main-panel">
          
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Edit Banner</h4>
                    
                    <form class="forms-sample" action="{{ route('banners.update',['bannerId' => $bannerdetails->_id]) }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                      <div class="form-group">
                        <label for="exampleInputName1">Banner Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Banner Name" name="banner_name" value="{{$bannerdetails->name}}" required>
                        @if ($errors->has('banner_name'))<p class="text-danger">{{ $errors->first('banner_name') }}</p>@endif
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Banner Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Banner URL" name="banner_url" value="{{$bannerdetails->url}}" required>
                        @if ($errors->has('banner_url'))<p class="text-danger">{{ $errors->first('banner_url') }}</p>@endif
                      </div>
                      <div class="form-group">
                        <label for="exampleInputFile1">Banner Image upload (1086 * 390) </label>
                        <input type="file" accept="image/image/gif,image/jpeg" id="wizard-picture" name="banner_image" class="form-control m-b15 p-2 borderGrey w-100"><br>
                        
                        <img src="{{url('/storage/app/public/banners/'.$bannerdetails->image)}}" class="borderCurve borderGradient picture-src dnone" id="wizardPicturePreview"
              style="width:100px;height:100px;object-fit: cover; margin-top:20px;">
                      @if ($errors->has('banner_image'))<p class="text-danger">{{ $errors->first('banner_image') }}</p>@endif
                      </div>
                      
                      <button type="submit" class="btn btn-success mr-2">Submit</button>
                      
                    </form>
                  </div>
                </div>
              </div>
</div>
</div>
@include('admin.layouts.footer')
