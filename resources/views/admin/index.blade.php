
        <!-- partial:partials/_sidebar.html -->
       @include('admin.layouts.sidebar')
       
       <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <!-- Page Title Header Starts-->
            <div class="row page-title-header">
              <div class="col-12">
                <div class="page-header" style="border-bottom: none; padding-bottom: 0px; margin-bottom: 0px;">
                  <h4 class="page-title">Dashboard</h4>
                  
                </div>
              </div>
              

            </div>
            <!-- Page Title Header Ends-->
            <div class="row">
              <div class="col-md-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-3 col-md-6">
                        <div class="d-flex">
                          <div class="wrapper" style="text-align:center;width:100%;">
                            <h3 class="mb-0 font-weight-semibold" style="text-align: center;">{{$totalusers}}</h3>
                            <h5 class="mb-0 font-weight-medium text-primary">Total Users</h5>
                          </div>
                          <div class="wrapper my-auto ml-auto ml-lg-4">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                        <div class="d-flex">
                          <div class="wrapper" style="text-align:center;width:100%;">
                            <h3 class="mb-0 font-weight-semibold" style="text-align: center;">{{$totalapprovedusers}}</h3>
                            <h5 class="mb-0 font-weight-medium text-primary">Approved Users</h5>
                          </div>
                          <div class="wrapper my-auto ml-auto ml-lg-4">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                        <div class="d-flex">
                          <div class="wrapper" style="text-align:center;width:100%;">
                            <h3 class="mb-0 font-weight-semibold" style="text-align: center;">{{$totalproducts}}</h3>
                            <h5 class="mb-0 font-weight-medium text-primary">Total Products</h5>
                          </div>
                          <div class="wrapper my-auto ml-auto ml-lg-4">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                        <div class="d-flex">
                          <div class="wrapper" style="text-align:center; width:100%;">
                            <h3 class="mb-0 font-weight-semibold" style="text-align:center;">{{$totalapprovedproducts}}</h3>
                            <h5 class="mb-0 font-weight-medium text-primary">Approved Products</h5>
                          </div>
                          <div class="wrapper my-auto ml-auto ml-lg-4">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="d-flex align-items-center pb-2">
                              <div class="dot-indicator bg-danger mr-2"></div>
                              <p class="mb-0">Pending Users</p>
                            </div>
                            <h4 class="font-weight-semibold"><?php echo $totalpendingusers; ?></h4>
                            <div class="progress progress-md">
                              <div class="progress-bar bg-danger" role="progressbar" style="width: 78%" aria-valuenow="<?php echo $totalpendingusers; ?>" aria-valuemin="0" aria-valuemax="<?php echo $totalusers; ?>"></div>
                            </div>
                          </div>
                          <div class="col-md-6 mt-4 mt-md-0">
                            <div class="d-flex align-items-center pb-2">
                              <div class="dot-indicator bg-danger mr-2"></div>
                              <p class="mb-0">Pending Products</p>
                            </div>
                            <h4 class="font-weight-semibold"><?php echo $totalpendingproducts; ?></h4>
                            <div class="progress progress-md">
                              <div class="progress-bar bg-danger" role="progressbar" style="width: 45%" aria-valuenow="<?php echo $totalpendingproducts; ?>" aria-valuemin="0" aria-valuemax="<?php echo $totalproducts; ?>"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 grid-margin stretch-card average-price-card">
                    <div class="card text-white">
                      <div class="card-body">
                        <div class="d-flex justify-content-between pb-2 align-items-center">
                          <h2 class="font-weight-semibold mb-0"><?php echo $todayusers; ?></h2>
                          <div class="icon-holder">
                            <i class="mdi mdi-briefcase-outline"></i>
                          </div>
                        </div>
                        <div class="d-flex justify-content-between">
                          <h5 class="font-weight-semibold mb-0">Users</h5>
                          <p class="text-white mb-0">Today New Users</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>


            <div class="row">
              <div class="col-md-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-3 col-md-6">
                        <div class="d-flex">
                          <div class="wrapper" style="text-align:center;width:100%;">
                            <h3 class="mb-0 font-weight-semibold" style="text-align: center;">{{$neworders}}</h3>
                            <h5 class="mb-0 font-weight-medium text-primary">New Orders</h5>
                          </div>
                          <div class="wrapper my-auto ml-auto ml-lg-4">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                        <div class="d-flex">
                          <div class="wrapper" style="text-align:center;width:100%;">
                            <h3 class="mb-0 font-weight-semibold" style="text-align: center;">{{$deliveredorders}}</h3>
                            <h5 class="mb-0 font-weight-medium text-primary">Delivered Orders</h5>
                          </div>
                          <div class="wrapper my-auto ml-auto ml-lg-4">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                        <div class="d-flex">
                          <div class="wrapper" style="text-align:center;width:100%;">
                            <h3 class="mb-0 font-weight-semibold" style="text-align: center;">{{$cancelledorders}}</h3>
                            <h5 class="mb-0 font-weight-medium text-primary">Cancelled Orders</h5>
                          </div>
                          <div class="wrapper my-auto ml-auto ml-lg-4">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-6 mt-md-0 mt-4">
                        <div class="d-flex">
                          <div class="wrapper" style="text-align:center; width:100%;">
                            <h3 class="mb-0 font-weight-semibold" style="text-align:center;">{{$settledorders}}</h3>
                            <h5 class="mb-0 font-weight-medium text-primary">Settled Orders</h5>
                          </div>
                          <div class="wrapper my-auto ml-auto ml-lg-4">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            

                <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="d-flex align-items-center pb-2">
                              <div class="dot-indicator bg-danger mr-2"></div>
                              <p class="mb-0">Promotion Products</p>
                            </div>
                            <h4 class="font-weight-semibold"><?php echo $totalfeatureproducts; ?></h4>
                            <div class="progress progress-md">
                              <div class="progress-bar bg-danger" role="progressbar" style="width: 78%" aria-valuenow="<?php echo $totalfeatureproducts; ?>" aria-valuemin="0" aria-valuemax="<?php echo $totalproducts; ?>"></div>
                            </div>
                          </div>
                          <div class="col-md-6 mt-4 mt-md-0">
                            <div class="d-flex align-items-center pb-2">
                              <div class="dot-indicator bg-danger mr-2"></div>
                              <p class="mb-0">Report Products</p>
                            </div>
                            <h4 class="font-weight-semibold"><?php echo $totalreportproducts; ?></h4>
                            <div class="progress progress-md">
                              <div class="progress-bar bg-danger" role="progressbar" style="width: 45%" aria-valuenow="<?php echo $totalreportproducts; ?>" aria-valuemin="0" aria-valuemax="<?php echo $totalproducts; ?>"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 grid-margin stretch-card average-price-card">
                    <div class="card text-white">
                      <div class="card-body">
                        <div class="d-flex justify-content-between pb-2 align-items-center">
                          <h2 class="font-weight-semibold mb-0"><?php echo $todayorders; ?></h2>
                          <div class="icon-holder">
                            <i class="mdi mdi-briefcase-outline"></i>
                          </div>
                        </div>
                        <div class="d-flex justify-content-between">
                          <h5 class="font-weight-semibold mb-0">Orders</h5>
                          <p class="text-white mb-0">Today New Orders</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>



            <div class="row">
              <div class="col-lg-8 grid-margin stretch-card">
                <div class="card">
                  <div class="p-4 border-bottom bg-light">
                    <h4 class="card-title mb-0">User Details Chart</h4>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center pb-4">
                      <h4 class="card-title mb-0">Users Details</h4>
                      <div id="bar-traffic-legend"></div>
                          <input type="hidden" id="monthValue" value="<?php echo json_encode($usercount); ?>">

                    </div>
                    <canvas id="barChart" style="height:250px"></canvas>
                  </div>
                </div>
              </div>

              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body d-flex flex-column">
                    <div class="wrapper">
                      <h4 class="card-title mb-0">Push Notification</h4>
                                          <form class="forms-sample">

                      <div class="form-group">
                        <label for="exampleTextarea1" style="line-height: 4;">Send Push Notification to all users</label>
                        <textarea class="form-control" id="message" rows="2" style="height: 20em;"></textarea>
                      </div>
                      <button type="submit" return id="sendpushnot" class="btn btn-success mr-2">Submit</button>
                       <img src="{{url('/storage/app/public/admin_assets/loaderdot.gif/')}}" class="loader" style="display: none;">
                       <div id="successalert" style="display: none;">Successfully Sent</div>
                       <div id="erroralert" style="display:none;">Enter a message to Send</div>
                     </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
             
                  </div>
                </div>
              </div>
            </div>
          </div>



          <script type='text/javascript'>
          jQuery('#sendpushnot').live('click',function(e) {

            var msg = $('#message').val();

            var message =  msg.trim();

            var BaseURL=getBaseURL();


            if (message == ''){
                $('#erroralert').show();
                return false;
            } else {

                  $.ajax({
                      url: BaseURL+"admin/sendalert",
                      type: "POST",
                      dataType : "html",
                      data:{ message : message},
                      beforeSend: function(){
                        $('#erroralert').hide();
                        $('#successalert').hide();
                        $('.loader').show();
                      },
                      success: function (response) {
                          if(response.trim() == "success"){
                              $('#message').val('');
                              $('.loader').hide();
                              $('#successalert').show();
                              return false; 

                          }
                          else{
                              return false; 
                          }
                      },
                      });

                  return false;
                }

            });


          function getBaseURL(){
              var url = location.href;
              var baseURL = url.substring(0, url.indexOf('/', 14));
              if (baseURL.indexOf('http://localhost') != -1) {
                var url = location.href;
                var pathname = location.pathname;
                var index1 = url.indexOf(pathname);
                var index2 = url.indexOf("/", index1 + 1);
                var baseLocalUrl = url.substr(0, index2);
                return baseLocalUrl + "/";
              } else {

                return baseURL + "/";
              }

          }
          </script>

         
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
         @include('admin.layouts.footer')
          <!-- partial -->
       
