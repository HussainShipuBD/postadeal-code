@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')

    <div class="main-panel">
          
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Edit Commission</h4>
                    <form class="forms-sample" action="{{ route('commissions.update',['commissionId' => $commissiondetails->_id]) }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                      <div class="form-group">
                        <label for="exampleInputName1">Commission Percentage</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Percentage" name="percentage" value="{{$commissiondetails->percentage}}" required>
                         @if ($errors->has('percentage'))<p class="text-danger">{{ $errors->first('percentage') }}</p>@endif
                         <input type="hidden" class="form-control" id="exampleInputName1" placeholder="Percentage" name="hiddenpercentage" value="{{$commissiondetails->percentage}}" required>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Minimum Range</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Min Range" name="minrange" value="{{$commissiondetails->minrange}}" required>
                         @if ($errors->has('minrange'))<p class="text-danger">{{ $errors->first('minrange') }}</p>@endif
                         <input type="hidden" class="form-control" id="exampleInputName1" placeholder="Min Range" name="hiddenminrange" value="{{$commissiondetails->minrange}}" required>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1">Maximum Range</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Max Range" name="maxrange" value="{{$commissiondetails->maxrange}}" required>
                         @if ($errors->has('maxrange'))<p class="text-danger">{{ $errors->first('maxrange') }}</p>@endif
                         <input type="hidden" class="form-control" id="exampleInputName1" placeholder="Max Range" name="hiddenmaxrange" value="{{$commissiondetails->maxrange}}" required>
                      </div>
                      
                        
                          
                      <button type="submit" class="btn btn-success mr-2">Submit</button>
                      
                    </form>
                  </div>
                </div>
              </div>
</div>
</div>

@include('admin.layouts.footer')
