@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')

    <div class="main-panel">
          
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Edit Main Category</h4>
                    
                    <form class="forms-sample" action="{{ route('category.update',['categoryId' => $categorydetails->_id]) }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                      <div class="form-group">
                        <label for="exampleInputName1">Category Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" name="category_name" value="{{$categorydetails->name}}" required>
                        @if ($errors->has('category_name'))<p class="text-danger">{{ $errors->first('category_name') }}</p>@endif
                        <input type="hidden" class="form-control" id="exampleInputName1" placeholder="Name" name="category_hiddenname" value="{{$categorydetails->name}}" required>

                      </div>
                      <!--<div class="form-group">
                        <label for="exampleInputTitle">Meta Title</label>
                        <input type="text" class="form-control" id="exampleInputTitle" placeholder="Meta Title" name="title">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputDesc">Meta Description</label>
                        <input type="text" class="form-control" id="exampleInputDesc" placeholder="Mest Description" name="desc">
                      </div>-->
                      <div class="form-group">
                        <label for="exampleInputFile1">Image upload(jpg, png, jpeg)</label>
                        <input type="file" accept="image/image/gif,image/jpeg" id="wizard-picture" name="category_image" class="form-control m-b15 p-2 borderGrey w-100"><br>
                        
                        <img src="{{url('/storage/app/public/categories/'.$categorydetails->image)}}" class="borderCurve borderGradient picture-src dnone" id="wizardPicturePreview"
              style="width:100px;height:100px;object-fit: cover; margin-top:20px;">
                        @if ($errors->has('category_image'))<p class="text-danger">{{ $errors->first('category_image') }}</p>@endif
                      </div>
                      
                      <button type="submit" class="btn btn-success mr-2">Submit</button>
                      
                    </form>
                  </div>
                </div>
              </div>
</div>
</div>
@include('admin.layouts.footer')
