@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')


    <div class="main-panel">
          
    <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Banner Management</h4>
                     <a href="{{ route('banner.create') }}"><button type="button" class="btn btn-primary btn-fw">Add Banner</button></a>
                    <form class="ml-auto search-form d-md-block" style="margin: 10px 0px;" action="{{ route('banner.search') }}">
			    <div class="form-group">
			      <input type="search" class="form-control" placeholder="Search Banner Name" value="{{$search}}" name="search">
			    </div>
          		</form>

                    <table class="table table-bordered" style="text-align: center;">
                      <thead>
                        <tr>
                          <th> # </th>
                          <th> Banner Name </th>
                          <th> Banner URL </th>
                          <th> Edit </th>
                          <th> Delete </th>
                          
                        </tr>
                      </thead>
                      <tbody>
                      @php $index =1; @endphp
            @if(!empty($bannerrecords))
                @foreach($bannerrecords as $banner)
                        <tr>
                          <td> {{$index}} </td>
                          <td> {{$banner['name']}} </td>
                          <td> {{$banner['url']}} </td>
                          <td>
                            <div class="col-sm-6 col-md-4 col-lg-3" style="max-width: 100%;">
                        <a href="{{ route('banners.edit', ['bannerId' => $banner['_id'], ]) }}"><button class="btn btn-info align-text-top border-0"><i class="fa fa-edit"></i></button></a>
                      </div>
                          </td>
                          <td>
                             <div class="col-sm-6 col-md-4 col-lg-3" style="max-width: 100%;">
                        <a href="{{ route('banners.delete', ['bannerId' => $banner['_id'], ]) }}">
                        <button class="btn btn-info align-text-top border-0"><i class="fa fa-trash-o"></i></button>
                      </a>
                      </div>
                          </td>
                        </tr>
                        @php $index++; @endphp
                @endforeach
                            @endif
                      </tbody>
                    </table>
                        <div class="pagination-wrapper justify-content-center" style="display:grid; margin-top:25px;"> {!! $pagination->render() !!} </div>
                  </div>
                </div>
              </div>
</div>
</div>
@include('admin.layouts.footer')
