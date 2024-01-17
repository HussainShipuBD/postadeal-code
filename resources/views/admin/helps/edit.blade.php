@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')

<style>
textarea#CKEditor1 { display: none;}

</style>
<script src="{{ URL::asset('public/admin_assets/js/ckeditor.js') }}"></script>

    <div class="main-panel">
          
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Edit Help Page</h4>
                    <form class="forms-sample" action="{{ route('helps.update',['helpId' => $helpdetails->_id]) }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                      <div class="form-group">
                        <label for="exampleInputName1">Title</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Title" name="title" value="{{$helpdetails->name}}" required>
                         @if ($errors->has('title'))<p class="text-danger">{{ $errors->first('title') }}</p>@endif
                      </div>
                      

                      <div class="form-group">
                        <label for="exampleInputName1">Description</label>
                      <textarea id="editor1" name="description" required>{{$helpdetails->description}}</textarea>
                         @if ($errors->has('description'))<p class="text-danger">{{ $errors->first('description') }}</p>@endif
                      </div>
                        
                          
                      <button type="submit" class="btn btn-success mr-2">Submit</button>
                      
                    </form>
                  </div>
                </div>
              </div>
</div>
</div>

@include('admin.layouts.footer')
