@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')

    <div class="main-panel">
          
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Add Commission</h4>
                    <form class="forms-sample" action="{{ route('commissions.store') }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                      <div class="form-group">
                        <label for="exampleInputName1">Commission Percentage</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Percentage" name="percentage" required>
                         @if ($errors->has('percentage'))<p class="text-danger">{{ $errors->first('percentage') }}</p>@endif
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Minimum Range</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Min Range" name="minrange" required>
                         @if ($errors->has('minrange'))<p class="text-danger">{{ $errors->first('minrange') }}</p>@endif
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Maximum Range</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Max Range" name="maxrange" required>
                         @if ($errors->has('maxrange'))<p class="text-danger">{{ $errors->first('maxrange') }}</p>@endif
                      </div>
                      
                        
                          
                      <button type="submit" class="btn btn-success mr-2">Submit</button>
                      
                    </form>
                  </div>
                </div>
              </div>
</div>
</div>

@include('admin.layouts.footer')
