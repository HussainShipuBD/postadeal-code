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
  </head>
  <body>
    <div class="container-scroller">
      <div class="page-body-wrapper ">
        <div class="content-wrapper d-flex align-items-center help theme-one">
          <div class="row w-100 ">
            <div class="col-lg-8 mx-auto help_wap">
			<div class="landing_logo">
				<a href="/" class="ama-site-logo-wrap">
				<img src="{{ URL::asset('storage/app/public/admin_assets/logo.png') }}" class="img-fluid" alt="Logo">
				</a>
			</div>
			<div class="help_txt">
			<h1 class="help_h1"><?php echo $helpdetail->name; ?></h1>
			<p class="help_txt_style">
				<?php echo $helpdetail->description; ?>
			</p>
			
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
    
  </body>
</html>
