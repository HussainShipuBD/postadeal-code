@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')


    <div class="main-panel">
          
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Edit User</h4>
                    <form class="forms-sample" action="{{ route('users.update',['userId' => $userdetails->_id]) }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                      <div class="form-group">
                        <label for="exampleInputName1">User Name</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Name" name="name" value="{{$userdetails->name}}" required>
                        @if ($errors->has('name'))<p class="text-danger">{{ $errors->first('name') }}</p>@endif
                      </div>


                      <div class="form-group">

                        <label for="exampleInputName2">Email</label>
                        <input type="text" class="form-control" id="exampleInputName2" placeholder="Email" name="email" value="{{$userdetails->email}}" required>
                        @if ($errors->has('email'))<p class="text-danger">{{ $errors->first('email') }}</p>@endif

                        <input type="hidden" class="form-control" id="exampleInputName1" placeholder="Email" name="hiddenemail" value="{{$userdetails->email}}" required>

                      </div>
                      
                        <input type="hidden" class="form-control" id="exampleInputName1" placeholder="page" name="page" value="{{$page}}" required>

                        
                          
                      <button type="submit" class="btn btn-success mr-2">Submit</button>
                      
                    </form>
                  </div>
                </div>
              </div>
</div>
</div>

@include('admin.layouts.footer')
