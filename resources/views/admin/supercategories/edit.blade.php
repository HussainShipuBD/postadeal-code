@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')


    <div class="main-panel">
          
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Edit Super Category</h4>
                    <form class="forms-sample" action="{{ route('supercategories.update',['categoryId' => $categorydetails->_id]) }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    	<input type="hidden" id="ajax_url" url="{{route('supercategories.ajaxsubcategories')}}" required/>
                      <div class="form-group">
                       <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" name="supercategory_name" value="{{$categorydetails->name}}" required>

                        <input type="hidden" class="form-control" id="exampleInputName1" placeholder="Name" name="supercategory_hiddenname" value="{{$categorydetails->name}}" required>
                        <input type="hidden" class="form-control" id="exampleInputName2" name="parentcategory_hiddenid" value="{{$categorydetails->parentCategory}}" required>
                        <input type="hidden" class="form-control" id="exampleInputName3" name="subcategory_hiddenid" value="{{$categorydetails->subCategory}}" required>
                         @if ($errors->has('category_name'))<p class="text-danger">{{ $errors->first('category_name') }}</p>@endif

                      </div>
                      
                          <div class="form-group">
                            <label for="exampleInputName1">Parent Category</label>
                            
                              <select class="form-control" id="maincategory-type" name="main_category_type" required>
                                <option value="">Select</option>

            @foreach ($maincategories as $eachcategory)
          <option value="{{ $eachcategory[0]->_id }}" @if(strval($categorydetails->parentCategory) === $eachcategory[0]->_id) selected @endif>   
              {{ $eachcategory[0]->name }}
          </option>
            @endforeach   
                              </select>
                              @if ($errors->has('main_category_type'))<p class="text-danger">{{ $errors->first('main_category_type') }}</p>@endif
                            </div>
                            
                            <div class="form-group" id="super_sub_category">
                            <label for="exampleInputName1">Sub Category</label>
                            
                              <select class="form-control" id="edit-sub-category-type" name="sub_category_type" required>
                                <option value="">Select</option>
            @foreach ($subcategoryList as $eachsubcategory)
          <option value="{{ $eachsubcategory->_id }}" @if(strval($categorydetails->subCategory) === $eachsubcategory->_id) selected @endif>    
              {{ $eachsubcategory->name }}
          </option>
            @endforeach   
            </select>
            @if ($errors->has('sub_category_type'))<p class="text-danger">{{ $errors->first('sub_category_type') }}</p>@endif
				</div>
                          
                      <button type="submit" class="btn btn-success mr-2">Submit</button>
                      
                    </form>
                  </div>
                </div>
              </div>
</div>
</div>
<script>
	window.onload = function (e) {
      document.getElementById("category-type").selectedIndex = 0;
    };
</script>
@include('admin.layouts.footer')
