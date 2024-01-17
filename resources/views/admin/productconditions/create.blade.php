@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')


    <div class="main-panel">
          
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Add Product Condition</h4>
                    <form class="forms-sample" action="{{ route('productconditions.store') }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                      <div class="form-group">
                        <label for="exampleInputName1">Product Condition Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" name="productcondition_name" required>
                        @if ($errors->has('productcondition_name'))<p class="text-danger">{{ $errors->first('productcondition_name') }}</p>@endif
                      </div>
                      
                        
                          
                      <button type="submit" class="btn btn-success mr-2">Submit</button>
                      
                    </form>
                  </div>
                </div>
              </div>
</div>
</div>

@include('admin.layouts.footer')
