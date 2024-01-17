@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')

    <div class="main-panel">
          
    <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Manage Product Conditions</h4>
                     <a href="{{ route('productconditions.create') }}"><button type="button" class="btn btn-primary btn-fw">Add Product Condition</button></a>
                    <form class="ml-auto search-form d-md-block" style="margin: 10px 0px;" action="{{ route('productconditions.search') }}">
			    <div class="form-group">
			      <input type="search" class="form-control" placeholder="Search Product Conditions" value="{{$search}}" name="search">
			    </div>
          		</form>

                    <table class="table table-bordered" style="text-align: center;">
                      <thead>
                        <tr>
                          <th> # </th>
                          <th> Product Condition name </th>
                          <th> Edit </th>
                          <th> Delete </th>
                          
                        </tr>
                      </thead>
                      <tbody>
                      @php $index =1; @endphp
            @if(!empty($prtconditionrecords))
                @foreach($prtconditionrecords as $prtconditions)
                        <tr>
                          <td> {{$index}} </td>
                          <td> {{$prtconditions['name']}} </td>
                          <td>
                            <div class="col-sm-6 col-md-4 col-lg-3" style="max-width: 100%;">
                        <a href="{{ route('productconditions.edit', ['conditionId' => $prtconditions['_id'], ]) }}"><button class="btn btn-info align-text-top border-0"><i class="fa fa-edit"></i></button></a>
                      </div>
                          </td>
                          <td>
                             <div class="col-sm-6 col-md-4 col-lg-3" style="max-width: 100%;">
                         <a href="{{ route('productconditions.delete', ['conditionId' => $prtconditions['_id'], ]) }}">
                        <button class="btn btn-info align-text-top border-0"><i class="fa fa-trash-o"></i></button>
                      </a>
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
