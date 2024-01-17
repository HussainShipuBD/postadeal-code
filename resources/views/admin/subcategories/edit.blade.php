@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')


    <div class="main-panel">
          
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Edit Sub Category</h4>
                    <form class="forms-sample" action="{{ route('subcategories.update',['categoryId' => $categorydetails->_id]) }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                      <div class="form-group">
                        <label for="exampleInputName1">Sub Category Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" name="category_name" value="{{$categorydetails->name}}" required>
                          @if ($errors->has('category_name'))<p class="text-danger">{{ $errors->first('category_name') }}</p>@endif

                        <input type="hidden" class="form-control" id="exampleInputName1" name="category_hiddenname" value="{{$categorydetails->name}}" required>
                        <input type="hidden" class="form-control" id="exampleInputName2" name="parentcategory_hiddenid" value="{{$categorydetails->parentCategory}}" required>


                      </div>
                      
                          <div class="form-group">
                            <label for="exampleInputName1">Category</label>
                            
                              <select class="form-control" name="category_parent" id="category-type" required>
                                <option value="">Select</option>
				    @foreach ($maincategories as $eachcategory)
					<option value="{{ $eachcategory->_id }}" @if(strval($categorydetails->parentCategory) === $eachcategory->_id) selected @endif>  
					    {{ $eachcategory->name }}
					</option>
				    @endforeach   
                              </select>
                                 @if ($errors->has('category_parent'))<p class="text-danger">{{ $errors->first('category_parent') }}</p>@endif
                            </div>
                          
                      <button type="submit" class="btn btn-success mr-2">Submit</button>
                      
                    </form>
                  </div>
                </div>
              </div>
</div>
</div>
@include('admin.layouts.footer')
