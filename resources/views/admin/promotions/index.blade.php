@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')

    <div class="main-panel">
          
    <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Manage Promotions</h4>
                     <a href="{{ route('promotions.create') }}"><button type="button" class="btn btn-primary btn-fw">Add Promotion</button></a>
                   
                    <table class="table table-bordered" style="text-align: center; margin-top:20px;">
                      <thead>
                        <tr>
                          <th> # </th>
                          <th> Promotion name </th>
                          <th> Promotion Duration </th>
                          <th> Promotion Price </th>
                          <th> Edit </th>
                          <th> Delete </th>
                          
                        </tr>
                      </thead>
                      <tbody>
                      @php $index =1; @endphp
            @if(!empty($promotionrecords))
                @foreach($promotionrecords as $promotionrecords)
                        <tr>
                          <td> {{$index}} </td>
                          <td> {{$promotionrecords['name']}} </td>
                          <td> {{$promotionrecords['duration']}} days </td>
                          <td> {{$settings['promotioncurrencysymbol'].' '.$promotionrecords['price']}} </td>
                          <td>
                            <div class="col-sm-6 col-md-4 col-lg-3" style="max-width: 100%;">
                        <a href="{{ route('promotions.edit', ['promotionId' => $promotionrecords['_id'], ]) }}"><button class="btn btn-info align-text-top border-0"><i class="fa fa-edit"></i></button></a>
                      </div>
                          </td>
                          <td>
                             <div class="col-sm-6 col-md-4 col-lg-3" style="max-width: 100%;">
                        <a href="{{ route('promotions.delete', ['promotionId' => $promotionrecords['_id'], ]) }}">
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
