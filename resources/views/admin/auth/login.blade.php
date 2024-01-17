<?php

use App\Classes\MyClass;
use Illuminate\Routing\Route;

$myClass = new MyClass();

$settings = $myClass->site_settings();

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
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ URL::asset('public/admin_assets/css/shared/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ URL::asset('storage/app/public/admin_assets/fav-icon') }}" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
          <div class="row w-100">
            <div class="col-lg-4 mx-auto">
              <div class="auto-form-wrapper">
			  
			  <div class="admin-text"><img src="{{ URL::asset('storage/app/public/admin_assets/dark.png') }}" class="admin-logo" alt="Logo"></div>
               <form method="POST" action="{{ route('admin.authentication') }}">
                                    @csrf
                  <div class="form-group">
                    <label class="label">Email</label>
                    <div class="input-group">
                      <input type="text" required class="form-control" name="email" placeholder="email" >
                      <div class="input-group-append">
                        
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="label">Password</label>
                    <div class="input-group">
                      <input type="password" required class="form-control" name="password" placeholder="*********">
                      <div class="input-group-append">
                       
                      </div>
                    </div>
                  </div>
                  @if ($errors->has('email'))<p class="text-danger">{{ $errors->first('email') }}</p>@endif
                  <div class="form-group">
                    <button class="btn btn-primary submit-btn btn-block">Login</button>
                  </div>
                  <!--<div class="form-group d-flex justify-content-between">
                    <div class="form-check form-check-flat mt-0">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" checked> Keep me signed in </label>
                    </div>
                    <a href="#" class="text-small forgot-password text-black">Forgot Password</a>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-block g-login">
                      <img class="mr-3" src="{{ URL::asset('public/admin_assets/images/file-icons/icon-google.svg') }}" alt="">Log in with Google</button>
                  </div>
                  <div class="text-block text-center my-3">
                    <span class="text-small font-weight-semibold">Not a member ?</span>
                    <a href="register.html" class="text-black text-small">Create new account</a>
                  </div>-->
                </form>
              </div>
              <!-- <ul class="auth-footer">
                <li>
                  <a href="#">Conditions</a>
                </li>
                <li>
                  <a href="#">Help</a>
                </li>
                <li>
                  <a href="#">Terms</a>
                </li>
              </ul>
             <p class="footer-text text-center">copyright © 2020 Bootstrapdash. All rights reserved.</p>
              <p class="footer-text text-center text-center"><a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank"> Free Bootstrap template </a> from BootstrapDash templates</p> -->
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    

    <script src="{{ URL::asset('public/admin_assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ URL::asset('public/admin_assets/vendors/js/vendor.bundle.addons.js') }}"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="{{ URL::asset('public/admin_assets/js/shared/off-canvas.js') }}"></script>
    <!--<script src="{{ URL::asset('public/admin_assets/js/shared/misc.js') }}"></script>-->
    <!-- endinject -->
    <script src="{{ URL::asset('public/admin_assets/js/shared/jquery.cookie.js') }}" type="text/javascript"></script>
  </body>
</html>

