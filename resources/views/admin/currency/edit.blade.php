@include('admin.layouts.sidebar')

@include('admin.layouts.flashmessage')


    <div class="main-panel">
          
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:18px;">Edit Currency</h4>
                    <form class="forms-sample" action="{{ route('currency.update',['currencyId' => $currencydetails->_id]) }}" method="POST"  enctype="multipart/form-data">
                    @csrf
                    	<div class="form-group">
                            <label for="exampleInputName1">Currency Details</label>
                            
                              <select  name="currency_details" class="form-control" id="currency-currencydetails" onchange="addCurrencyCode();" required>
                                <option value="">Select</option>
				    @foreach ($currencylist as $key=>$currency)
             <?php
                    if($currencydetails->currencycode == $currency){
                        $options = 'selected="selected"';
                    }else{
                        $options = '';
                    }
                ?>
					<option value="{{ $key }}" <?= $options; ?>> 
					    {{$currency}}
					</option>
				    @endforeach   
                              </select>
                            </div>
                    
                      <div class="form-group">
                        <label for="exampleInputName1">Currency Code</label>
        		<input type="text" class="form-control" id="currency-currencycode" name="currencycode" placeholder="" value="{{$currencydetails->currencycode}}" readonly>
            @if ($errors->has('currencycode'))<p class="text-danger">{{ $errors->first('currencycode') }}</p>@endif
                      </div>
                      
                      <div class="form-group">
                        <label for="exampleInputName1">Currency Symbol</label>
        		 <input type="text" class="form-control" id="currency-currencysymbol" name="currencysymbol" placeholder="" value="{{$currencydetails->currencysymbol}}" readonly>
             @if ($errors->has('currencysymbol'))<p class="text-danger">{{ $errors->first('currencysymbol') }}</p>@endif
                      </div>
                      
                      <div class="form-group">
                        <label for="exampleInputName1">Currency Name</label>
        		<input type="text" class="form-control" id="currency-currencyname" name="currencyname" placeholder="" value="{{$currencydetails->currencyname}}" readonly>
            @if ($errors->has('currencyname'))<p class="text-danger">{{ $errors->first('currencyname') }}</p>@endif
                      </div>
                      
                        
                          
                      <button type="submit" class="btn btn-success mr-2">Submit</button>
                      
                    </form>
                  </div>
                </div>
              </div>
</div>
</div>

@include('admin.layouts.footer')
