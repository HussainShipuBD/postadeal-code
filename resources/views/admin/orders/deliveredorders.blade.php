@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')

<script src="https://js.stripe.com/v3/"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <div class="main-panel">
          
    <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Delivered Orders</h4>
                   
                    <table class="table table-bordered" style="text-align: center;">
                      <thead>
                        <tr>
                          <th> # </th>
                          <th> Order Id </th>
                          <th> Seller Name </th>
                          <!--<th> Buyer Name </th>-->
                          <th> Order Date </th>
                          <th> Order Cost </th>
                          <th> Admin Commission </th>
                          <th> Seller Amount </th>
                          <th> View </th>
                          <th> Action </th>

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
                                            <input type="hidden" value="<?php echo $user->stripePublicKey; ?>" id="stripekey_<?php echo $newordersrecords['_id']; ?>" >
                                        @endif
                                    @endforeach </td>
                          <!--<td> @foreach($users as $user)
                                        @if($user->_id == $newordersrecords['userId'])
                                            {{$user->name}}
                                        @endif
                                    @endforeach  </td>-->
                          <td> {{$newordersrecords['orderDate']->toDateTime()->format('d-m-Y')}} </td>
                          <?php 
                            if(isset($newordersrecords['totalprice'])) {
                                $totalprice = $newordersrecords['totalprice'];
                                $commission = $newordersrecords['commissionprice'];
                            } else {
                                $totalprice = $newordersrecords['price'];
                                $commission = "0";
                            }
                          ?>
                          <td> {{$newordersrecords['currency'].' '.$totalprice}} </td>
                          <td> {{$newordersrecords['currency'].' '.$commission}} </td>
                          <?php
                            $selleramount = floatval($totalprice) - floatval($commission);

                          ?>
                          <td> {{$newordersrecords['currency'].' '.$selleramount}} </td>

                          <td>
                            <div class="col-sm-6 col-md-4 col-lg-3" style="max-width: 100%;">
                        <a href="{{ route('orders.view', ['orderId' => $newordersrecords['_id'], 'page'=>'delivered']) }}"><button class="btn btn-info align-text-top border-0"><i class="fa fa-eye"></i></button></a>
                      </div>
                          </td>
                        
                            <td>
                             <div class="col-sm-6 col-md-4 col-lg-3" style="max-width: 100%;">
                        <button class="btn btn-info align-text-top border-0" data-toggle="modal" data-target="#userModalCenter{{$newordersrecords['_id']}}">Approve</button>


                      <div class="modal fade " id="userModalCenter{{$newordersrecords['_id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="width: 90%;">
                    <div class="modal-header" style="border:none; width:98%;">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{__('Are you sure to proceed this?')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-footer" style="display:block; padding:20px !important;">
                        
                       <input type="hidden" value="<?php echo $newordersrecords['sellerId']; ?>" id="sellerId_<?php echo $newordersrecords['_id']; ?>" >
                       
                        <input type="hidden" value="<?php echo $selleramount; ?>" id="amount_<?php echo $newordersrecords['_id']; ?>" >
                         <input type="hidden" value="<?php echo $newordersrecords['currencyCode']; ?>" id="currency_<?php echo $newordersrecords['_id']; ?>" >
                         
                        <input type="hidden" value="<?php echo $newordersrecords['_id']; ?>" id="orderid" >
                            <a href="{{ route('orders.stripesessioncreation', ['orderId' => $newordersrecords['_id']]) }}" style="cursor: pointer;" return id="ajax_url">
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

<script type='text/javascript'>
    jQuery('#ajax_url').live('click',function(e) {


            linkval = $(this).attr("href");
            if(linkval != "" && linkval != undefined)
            { 

                var fullData = $(this).attr('href').split('stripesessioncreation/');
                var orderId = fullData[1];
                var stripekey = $('#stripekey_'+''+orderId).val();

                var amount =  $('#amount_'+''+orderId).val();
                var sellerId =  $('#sellerId_'+''+orderId).val();
                var amt = $('#amount_'+''+orderId).val();
                var currency = $('#currency_'+''+orderId).val();
                var stripe = Stripe(stripekey);
                
                $.ajax({
                url: linkval,
                type: "POST",
                dataType : "json",
                data:{ orderId : orderId, amt : amt, currency : currency, sellerId:sellerId },
                success: function (res) {
                    if(res){
                       
                        if(res.session_id){
                            return stripe.redirectToCheckout({ sessionId: res.session_id });
                        }
                    }
                    else{
                        return false; 
                    }
                },
                });
                return false;
            }
        
    });
</script>

@include('admin.layouts.footer')
