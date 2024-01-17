@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')

    <div class="main-panel">
          
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Edit Promotion</h4>
                    <form class="forms-sample" action="{{ route('promotions.update',['promotionId' => $promotiondetails->_id]) }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                      <div class="form-group">
                        <label for="exampleInputName1">Promotion Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" name="promotion_name" value="{{$promotiondetails->name}}" required>
                         @if ($errors->has('promotion_name'))<p class="text-danger">{{ $errors->first('promotion_name') }}</p>@endif
                         <input type="hidden" class="form-control" id="exampleInputName1" placeholder="Name" name="promotion_hiddenname" value="{{$promotiondetails->name}}" required>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Promotion Duration - Days</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Duration" name="promotion_duration" value="{{$promotiondetails->duration}}" required>
                         @if ($errors->has('promotion_duration'))<p class="text-danger">{{ $errors->first('promotion_duration') }}</p>@endif
                         <input type="hidden" class="form-control" id="exampleInputName1" placeholder="Name" name="promotion_hiddenduration" value="{{$promotiondetails->duration}}" required>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Promotion Price</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Price" name="promotion_price" value="{{$promotiondetails->price}}" required>
                         @if ($errors->has('promotion_price'))<p class="text-danger">{{ $errors->first('promotion_price') }}</p>@endif
                         <input type="hidden" class="form-control" id="exampleInputName1" placeholder="Name" name="promotion_hiddenprice" value="{{$promotiondetails->price}}" required>
                      </div>
                      
                        
                          
                      <button type="submit" class="btn btn-success mr-2">Submit</button>
                      
                    </form>
                  </div>
                </div>
              </div>
</div>
</div>

@include('admin.layouts.footer')
