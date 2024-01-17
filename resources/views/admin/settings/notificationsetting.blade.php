@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')


    <div class="main-panel">
          
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Notification Settings Management</h4>
                    <form class="forms-sample" action="{{ route('settings.notificationsettingsupdate') }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    

                      <div class="form-group">
                        <label for="exampleInputName1">API Key for Push Notification</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Push Notification Key" name="notificationkey" value="{{$settings->notificationkey}}" required>
                         @if ($errors->has('notificationkey'))<p class="text-danger">{{ $errors->first('notificationkey') }}</p>@endif
                      </div>

                      <button type="submit" class="btn btn-success mr-2">Submit</button>
                      
                    </form>
                  </div>
                </div>
              </div>
</div>
</div>

@include('admin.layouts.footer')
