@include('admin.layouts.sidebar')

    <div class="main-panel">
          
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:22px; width:40%;">View Order Details</h4>
                    <?php if($page == "neworders") { ?>
                    <a style="float: right;" href="{{ route('orders.neworders') }}"><button type="button" class="btn btn-primary btn-fw">Back</button></a>
                  <?php } else if($page == "delivered") { ?>
                    <a style="float: right;" href="{{ route('orders.delivered') }}"><button type="button" class="btn btn-primary btn-fw">Back</button></a>
                  <?php } else { ?>
                    <a style="float: right;" href="{{ route('orders.settled') }}"><button type="button" class="btn btn-primary btn-fw">Back</button></a>
                  <?php } ?>
                      <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Order Id : </label>
                        <label style="font-size:17px;">{{$orderdetail->_id}}</label>
                       
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Pay Token : </label>
                        <label style="font-size:17px;">{{$orderdetail->pay_token}}</label>
                       
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Order Status : </label>
                        <label style="font-size:17px;">{{ucfirst($orderdetail->status)}}</label>
                       
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Order Date : </label>
                        <label style="font-size:17px;">{{$orderdetail->orderDate->toDateTime()->format('d-m-Y')}}</label>
                       
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Buyer Name : </label>
                        <label style="font-size:17px;">{{$userdetail->name}}</label>
                       
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Seller Name : </label>
                        <label style="font-size:17px;">{{$sellerdetail->name}}</label>
                       
                      </div>

                      <?php if(isset($itemdetails)) { ?>
                      <div class="form-group" style="font-size:14px;">
                        
                        <!--<input type="file" accept="image/image/gif,image/jpeg" id="wizard-itempicture" name="product_image" class="form-control m-b15 p-2 borderGrey w-100"><br>-->
                        <?php $images = json_decode($itemdetails->images, TRUE); 
                        $imgCount = count($images); ?>
                        <input type="hidden" value ="<?php echo $imgCount; ?>" id="imgCount">
                        <div id="ProductImageView"></div>
                        <?php foreach($images as $i=>$image) { ?>

                        <img src="{{url('/storage/app/public/products/thumb300/'.$image)}}" class="borderCurve borderGradient picture-src dnone" id="wizardPicturePreview">
                           <input type = "hidden" name = "productImage[]" value="<?php echo $image; ?>">
                      <?php } ?>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Product Name : </label>
                        <label style="font-size:17px;">{{$itemdetails->itemTitle}}</label>
                       
                      </div>
                    <?php } else { ?>

                      <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Product is not available now</label>
                        
                       
                      </div>
                    <?php } ?>

                       <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Product Price : </label>
                        <label style="font-size:17px;">{{$orderdetail->currency}}  {{$orderdetail->price}}</label>
                       
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Shipping Price : </label>
                        <label style="font-size:17px;">{{$orderdetail->currency}}  {{$orderdetail->shippingprice}}</label>
                       
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Total Price : </label>
                        <label style="font-size:17px;">{{$orderdetail->currency}}  {{$orderdetail->totalprice}}</label>
                       
                      </div>

                      <?php if(isset($addressdetails)) { ?>
                      <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Shipping Address : </label>
                      </div>

                      <div>
                        <label for="exampleInputName1"  style="font-size:17px;">Name : </label>

                        <label style="font-size:17px;">{{$addressdetails->name}}</label>

                      </div>

                      <div>
                        <label for="exampleInputName1"  style="font-size:17px;">Phone Number : </label>

                        <label style="font-size:17px;">{{$addressdetails->phone}}</label>

                      </div>

                      <div>
                        <label for="exampleInputName1"  style="font-size:17px;">Address Line 1 : </label>

                        <label style="font-size:17px;">{{$addressdetails->addressOne}}</label>

                      </div>

                      <div>
                        <label for="exampleInputName1"  style="font-size:17px;">Address Line 2 : </label>

                        <label style="font-size:17px;">{{$addressdetails->addressTwo}}</label>

                      </div>

                      <div>
                        <label for="exampleInputName1"  style="font-size:17px;">Country : </label>

                        <label style="font-size:17px;">{{$addressdetails->country}}</label>

                      </div>

                      <div>
                        <label for="exampleInputName1"  style="font-size:17px;">Pincode : </label>

                        <label style="font-size:17px;">{{$addressdetails->pincode}}</label>

                      </div>
                       
                       <?php } ?>

                      
                     
                  </div>
                </div>
              </div>
</div>
</div>

@include('admin.layouts.footer')
