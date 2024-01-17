@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')


    <div class="main-panel">
          
    <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Manage Pending Users</h4>
                     
                    <form class="ml-auto search-form d-none d-md-block" style="width:40%;" action="{{ route('users.pendingusersearch') }}">
			    <div class="form-group">
			      <input type="search" class="form-control" placeholder="Search Users" value="{{$search}}" name="search">
			    </div>
          		</form>

                    <table class="table table-bordered" style="text-align: center;">
                      <thead>
                        <tr>
                          <th> # </th>
                          <th> Username </th>
                          <th> Email </th>
                          <th> Edit </th>
                          <th> Action </th>
                          
                        </tr>
                      </thead>
                      <tbody>
                      @php $index =1; @endphp
            @if(!empty($pendingusersrecords))
                @foreach($pendingusersrecords as $pendingusersrecords)
                        <tr>
                          <td> {{$index}} </td>
                          <td> {{$pendingusersrecords['name']}} </td>
                          <td> {{$pendingusersrecords['email']}} </td>
                          <td>
                            <div class="col-sm-6 col-md-4 col-lg-3" style="max-width: 100%;">
                        <a href="{{ route('users.edit', ['userId' => $pendingusersrecords['_id'], 'page'=>'pending']) }}"><button class="btn btn-info align-text-top border-0"><i class="fa fa-edit"></i></button></a>
                      </div>
                          </td>
                          <td>
                             <div class="col-sm-6 col-md-4 col-lg-3" style="max-width: 100%;">
                        <button class="btn btn-info align-text-top border-0" data-toggle="modal" data-target="#userModalCenter{{$pendingusersrecords['_id']}}">Enable</button>


                      <div class="modal fade " id="userModalCenter{{$pendingusersrecords['_id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="width: 90%;">
                    <div class="modal-header" style="border:none; width:98%;">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{__('Do you want to enable this account?')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-footer" style="display:block; padding:20px !important;">
                        
                       
                            <a href="{{ route('users.changestatus', ['userId' => $pendingusersrecords['_id'], 'userStatus' => 1 ]) }}" style="cursor: pointer;">
                                <button type="button" style="background-color: #8862e0; border-color: #8862e0" class="btn btn-danger">{{__('Confirm')}}</button>
                            </a>
                        
                    </div>
                </div>
            </div>
        </div>
                      </div>
                          </td>
                        </tr>
                        @php $index++; @endphp
                @endforeach
                         @else
                        <tr>
                            <td colspan="8">No records found</td>
                        </tr>
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
