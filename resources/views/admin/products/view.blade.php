@include('admin.layouts.sidebar')

    <div class="main-panel">
          
    <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="font-size:22px;">View Product Details</h4>
                    <?php if($page == "approved") { ?>
                    <a href="{{ route('products.approved') }}"><button type="button" class="btn btn-primary btn-fw">Back</button></a>
                  <?php } else if($page == "pending"){ ?>
                    <a style="float: right;" href="{{ route('products.pending') }}"><button type="button" class="btn btn-primary btn-fw">Back</button></a>
                  <?php } else { ?>
                    <a style="float: right;" href="{{ route('products.reports') }}"><button type="button" class="btn btn-primary btn-fw">Back</button></a>
                  <?php } ?>
                      <div class="form-group" style="font-size:14px;">
                        
                        <!--<input type="file" accept="image/image/gif,image/jpeg" id="wizard-itempicture" name="product_image" class="form-control m-b15 p-2 borderGrey w-100"><br>-->
                        <?php $images = json_decode($itemdetails->images, TRUE); 
                        $imgCount = count($images); ?>
                        <input type="hidden" value ="<?php echo $imgCount; ?>" id="imgCount">
                        <div id="ProductImageView"></div>
                        <?php foreach($images as $i=>$image) { ?>

                        <img src="{{url('/storage/app/public/products/thumb300/'.$image)}}" class="borderCurve borderGradient picture-src dnone" id="wizardPicturePreview"
              style="margin-top:20px;">
                           <input type = "hidden" name = "productImage[]" value="<?php echo $image; ?>">
                      <?php } ?>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Product Name : </label>
                        <label style="font-size:17px;">{{$itemdetails->itemTitle}}</label>
                       
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Product Description : </label>
                        <label style="font-size:17px;">{{$itemdetails->itemDesc}}</label>
                       
                      </div>

                       <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Price : </label>
                        <label style="font-size:17px;">{{$itemdetails->price}}  {{$currencydetail->currencycode}}</label>
                       
                      </div>

                      <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Main Category : </label>
                        <label style="font-size:17px;">{{$categorydetail->name}}</label>
                       
                      </div>

                      <?php if(!empty($subcategorydetail)) { ?>
                      <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Sub Category : </label>
                        <label style="font-size:17px;">{{$subcategorydetail->name}}</label>
                       
                      </div>
                    <?php } ?>

                    <?php if(!empty($supercategorydetail)) { ?>
                      <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Super Category : </label>
                        <label style="font-size:17px;">{{$supercategorydetail->name}}</label>
                       
                      </div>
                    <?php } ?>

                    <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Product Condition : </label>
                        <label style="font-size:17px;">{{$conditiondetail->name}}</label>
                       
                      </div>
                      
                    <?php if(!empty($locationdetail)) { ?>

                      <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Location : </label>
                        <label style="font-size:17px;">{{$locationdetail->name}}</label>
                       
                      </div>
                    <?php } ?>

                      <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Seller Name : </label>
                        <label style="font-size:17px;">{{$userdetail->name}}</label>
                       
                      </div>

                      <?php if($itemdetails->buynow == "true") { ?>

                        <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Instant Buy : </label>
                        <label style="font-size:17px;">Enabled</label>
                       
                        </div>

                        <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Shipping Price : </label>
                        <label style="font-size:17px;">{{$itemdetails->shippingprice}}  {{$currencydetail->currencycode}}</label>
                       
                        </div>

                      <?php } else { ?>

                        <div class="form-group">
                        <label for="exampleInputName1"  style="font-size:17px; font-weight:bold;">Instant Buy : </label>
                        <label style="font-size:17px;">Disabled</label>
                       
                        </div>

                      <?php } ?>
                      
                     
                          
                     
                  </div>
                </div>
              </div>
</div>
</div>

@include('admin.layouts.footer')
