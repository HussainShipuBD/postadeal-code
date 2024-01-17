@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')


    <div class="main-panel">
          
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">SMTP Settings Management</h4>
                    <form class="forms-sample" action="{{ route('settings.smtpsettingsupdate') }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                      <div class="form-group">
                        <label for="exampleInputName1">SMTP Port</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="SMTP Port" name="port" value="{{$settings->port}}" required>
                         @if ($errors->has('port'))<p class="text-danger">{{ $errors->first('port') }}</p>@endif
                      </div>

                       <div class="form-group">

                        <label for="exampleInputName2">SMTP Host</label>
                        <input type="text" class="form-control" id="exampleInputName2" placeholder="SMTP Host" name="host" value="{{$settings->host}}" required>
                         @if ($errors->has('host'))<p class="text-danger">{{ $errors->first('host') }}</p>@endif
                      </div>
                      


                      <div class="form-group">

                        <label for="exampleInputName2">SMTP Email</label>
                        <input type="text" class="form-control" id="exampleInputName2" placeholder="SMTP Email" name="email" value="{{$settings->email}}" required>
                         @if ($errors->has('email'))<p class="text-danger">{{ $errors->first('email') }}</p>@endif
                      </div>


                      <div class="form-group">

                        <label for="exampleInputName2">SMTP Password</label>
                        <input type="password" class="form-control" id="exampleInputName2" placeholder="Password" name="password" value="{{$settings->password}}" required>
                         @if ($errors->has('password'))<p class="text-danger">{{ $errors->first('password') }}</p>@endif
                      </div>



                        
                          
                      <button type="submit" class="btn btn-success mr-2">Submit</button>
                      
                    </form>
                  </div>
                </div>
              </div>
</div>
</div>

@include('admin.layouts.footer')
