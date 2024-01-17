<?php

use App\Classes\MyClass;
use Illuminate\Routing\Route;

$myClass = new MyClass();

$settings = $myClass->site_settings();

$helpdetails = $myClass->helps();



?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $settings->siteName; ?></title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ URL::asset('public/admin_assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/admin_assets/vendors/iconfonts/ionicons/dist/css/ionicons.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/admin_assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/admin_assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/admin_assets/vendors/css/vendor.bundle.addons.css') }}">
    
    <link rel="stylesheet" href="{{ URL::asset('public/admin_assets/css/shared/style.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/admin_assets/css/shared/landing-style.css') }}">

    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
	
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ URL::asset('storage/app/public/admin_assets/fav-icon') }}" />
    <style>
.info_popup{
    background: #ffffff;
    border-radius: 5px;
    height: auto;
    padding: 10px;
    position: absolute;
    top: 10px;
    right: 10px;
    max-width: 500px;
   -webkit-box-shadow: -2px 1px 20px -1px rgba(209,209,209,0.41);
  -moz-box-shadow: -2px 1px 20px -1px rgba(209,209,209,0.41);
  box-shadow: -2px 1px 20px -1px rgba(209,209,209,0.41);
}
</style>
  </head>
  <body>
@if(Session::has('notification') && $message = Session::get('notification.message')) 
<div class="info_popup alert alert-dismissible fade show">
           {{ $message }}
               <button type="button" onclick="myFunction()" class="close" style="padding:0 0 0 12px; position: relative;">
                 <span aria-hidden="true">×</span>
               </button>
             </div>
@endif  
<?php
 Session::forget('notification'); 
 
 ?> 
    <div class="container-scroller">
      <div class="page-body-wrapper ">
        <div class="content-wrapper d-flex align-items-center landing theme-one">
          <div class="row w-100 ">
            <div class="col-lg-5 mx-auto frame_wap">
			<div class="landing_logo">
				<a href="/" class="ama-site-logo-wrap">
				<img src="{{ URL::asset('storage/app/public/admin_assets/logo.png') }}" class="img-fluid" alt="Logo">
				</a>
			</div>
			<div class="des_txt">
				<h1 class="des_txt_style"><?php echo $settings->siteDesc; ?>
				</h1>
			</div>
			<div class="demo_icon">
              <div class="store_icon">
			   <a href="<?php echo $settings->playstoreLink; ?>" target="_blank">
              <img src="{{ URL::asset('storage/app/public/admin_assets/playstore.png') }}" class="img-fluid" alt="Play store"></a>
			  </div>
           <div class="store_icon">
		   <a href="<?php echo $settings->appstoreLink; ?>" target="_blank">
              <img src="{{ URL::asset('storage/app/public/admin_assets/appstore.png') }}" class="img-fluid" alt="App store"></a>
			  </div>
          
				</div>
              
             
            </div>
          </div>
		  
		  
        </div>
        <!-- content-wrapper ends -->
      </div>
	  <div class="help_footer">
      <ul class="landing-footer">
      
      <?php foreach($helpdetails as $helpdetails) { ?>
                <li>
                  <a href="{{ route('helps.front', ['helpId' => $helpdetails->_id ]) }}"><?php echo $helpdetails->name; ?></a>
                </li>
                
                
                <?php } ?>
              </ul>
              <p class="footer-text text-center"><?php echo $settings->copyrightText; ?></p>
    
    </div>
      <!-- page-body-wrapper ends -->
    </div>

	 <script>
      function myFunction() {
        document.getElementsByClassName('info_popup')[0].style.visibility = 'hidden';
      }
  </script>


  </body>

</html>
