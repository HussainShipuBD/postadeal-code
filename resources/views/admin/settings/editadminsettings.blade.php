@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')


    <div class="main-panel">
          
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Edit Admin Settings</h4>
                    <form class="forms-sample" action="{{ route('settings.adminsettingsupdate') }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                      <div class="form-group">
                        <label for="exampleInputName1">Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Admin Name" name="name" value="{{$settings->name}}" required>
                      @if ($errors->has('name'))<p class="text-danger">{{ $errors->first('name') }}</p>@endif
                      </div>


                      <div class="form-group">

                        <label for="exampleInputName2">Email</label>
                        <input type="text" class="form-control" id="exampleInputName2" placeholder="Admin Mail ID" name="email" value="{{$settings->email}}" required>
                      @if ($errors->has('email'))<p class="text-danger">{{ $errors->first('email') }}</p>@endif

                      </div>


                      
                        
                          
                      <button type="submit" class="btn btn-success mr-2">Submit</button>
                      
                    </form>
                  </div>
                </div>
              </div>
</div>
</div>

@include('admin.layouts.footer')
