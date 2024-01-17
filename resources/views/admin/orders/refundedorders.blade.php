@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')

    <div class="main-panel">
          
    <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">New Orders</h4>
                   
                    <table class="table table-bordered" style="text-align: center;">
                      <thead>
                        <tr>
                          <th> # </th>
                          <th> Order Id </th>
                          <th> Seller Name </th>
                          <th> Buyer Name </th>
                          <th> Order Date </th>
                          <th> Order Cost </th>
                          <th> View </th>

                        </tr>
                      </thead>
                      <tbody>
                      @php $index =1; @endphp
            @if(!empty($newordersrecords))
                @foreach($newordersrecords as $newordersrecords)
                        <tr>
                          <td> {{$index}} </td>
                          <td> {{$newordersrecords['_id']}} </td>
                          <td> @foreach($users as $user)
                                        @if($user->_id == $newordersrecords['sellerId'])
                                            {{$user->name}}
                                        @endif
                                    @endforeach </td>
                          <td> @foreach($users as $user)
                                        @if($user->_id == $newordersrecords['userId'])
                                            {{$user->name}}
                                        @endif
                                    @endforeach  </td>
                          <td> {{$newordersrecords['orderDate']->toDateTime()->format('d-m-Y')}} </td>
                          <?php 
                            if(isset($newordersrecords['totalprice'])) {
                                $totalprice = $newordersrecords['totalprice'];
                            } else {
                                $totalprice = $newordersrecords['price'];
                            }
                          ?>
                          <td> {{$newordersrecords['currency'].' '.$totalprice}} </td>

                          <td>
                            <div class="col-sm-6 col-md-4 col-lg-3" style="max-width: 100%;">
                        <a href="{{ route('orders.view', ['orderId' => $newordersrecords['_id'], 'page'=>'neworders']) }}"><button class="btn btn-info align-text-top border-0"><i class="fa fa-eye"></i></button></a>
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
