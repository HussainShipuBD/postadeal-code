@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')


    <div class="main-panel">
          
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Add Super Category</h4>
                    <form class="forms-sample" action="{{ route('supercategories.store') }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    	<input type="hidden" id="ajax_url" url="{{route('supercategories.ajaxsubcategories')}}" required/>
                      <div class="form-group">
                        <label for="exampleInputName1">Super Category Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" name="category_name" required>
                          @if ($errors->has('category_name'))<p class="text-danger">{{ $errors->first('category_name') }}</p>@endif
                      </div>
                      
                          <div class="form-group">
                            <label for="exampleInputName1">Parent Category</label>
                            
                              <select class="form-control" id="category-type" name="main_category_type" required>
                                <option value="">Select</option>
				    @foreach ($maincategories as $eachcategory)
					<option value="{{ $eachcategory->_id }}"> 
					    {{ $eachcategory->name }}
					</option>
				    @endforeach   
                              </select>
                               @if ($errors->has('main_category_type'))<p class="text-danger">{{ $errors->first('main_category_type') }}</p>@endif
                            </div>
                            
                            <div class="form-group" id="super_sub_category">

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
