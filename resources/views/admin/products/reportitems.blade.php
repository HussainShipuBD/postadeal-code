@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')


    <div class="main-panel">
          
    <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Manage Report Products</h4>
                     
                    <form class="ml-auto search-form d-none d-md-block" style="width:40%;" action="{{ route('products.reportitemsearch') }}">
                <div class="form-group">
                  <input type="search" class="form-control" placeholder="Search Products" value="{{$search}}" name="search">
                </div>
                </form>

                    <table class="table table-bordered" style="text-align: center;">
                      <thead>
                        <tr>
                          <th> # </th>
                          <th> Product Name </th>
                          <th> Report Count </th>
                          <th> View </th>
                          <th> Action </th>
                          
                        </tr>
                      </thead>
                      <tbody>
                      @php $index =1; @endphp
            @if(!empty($reportitemsrecords)) 
                @foreach($reportitemsrecords as $reportitemsrecords)
                @if(isset($reportitemsrecords['reportCount']))
                        <tr>
                          <td> {{$index}} </td>
                          <td> {{$reportitemsrecords['itemTitle']}} </td>
                          <td> {{$reportitemsrecords['reportCount']}} </td>
                          <td>
                            <div class="col-sm-6 col-md-4 col-lg-3" style="max-width: 100%;">
                        <a href="{{ route('products.view', ['itemId' => $reportitemsrecords['_id'], 'page'=>'report']) }}"><button class="btn btn-info align-text-top border-0"><i class="fa fa-eye"></i></button></a>
                      </div>
                          </td>
                          <td>
                             <div class="col-sm-6 col-md-4 col-lg-3" style="max-width: 100%;">
                        <button class="btn btn-info align-text-top border-0" data-toggle="modal" data-target="#userModalCenter{{$reportitemsrecords['_id']}}">Disable</button>


                      <div class="modal fade " id="userModalCenter{{$reportitemsrecords['_id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="width: 90%;">
                    <div class="modal-header" style="border:none; width:98%;">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{__('Do you want to disable this product?')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-footer" style="display:block; padding:20px !important;">
                        
                       
                            <a href="{{ route('products.changestatus', ['itemId' => $reportitemsrecords['_id'], 'itemStatus' => 0 ]) }}" style="cursor: pointer;">
                                <button type="button" style="background-color: #8862e0; border-color: #8862e0" class="btn btn-danger">{{__('Confirm')}}</button>
                            </a>
                        
                    </div>
                </div>
            </div>
        </div>
                      </div>
                         

                        </tr>
                        @php $index++; @endphp
                        @endif
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
