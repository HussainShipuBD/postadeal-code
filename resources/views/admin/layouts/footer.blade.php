<?php

use App\Classes\MyClass;
use Illuminate\Routing\Route;

$myClass = new MyClass();

$settings = $myClass->site_settings();

?>



 </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->

    <script src="{{ URL::asset('public/admin_assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ URL::asset('public/admin_assets/vendors/js/vendor.bundle.addons.js') }}"></script>
        <script src="{{ URL::asset('public/admin_assets/js/custom.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="{{ URL::asset('public/admin_assets/js/shared/off-canvas.js') }}"></script>
    <script src="{{ URL::asset('public/admin_assets/js/shared/misc.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ URL::asset('public/admin_assets/js/demo_1/dashboard.js') }}"></script>
        <script src="{{ URL::asset('public/admin_assets/js/shared/chart.js') }}"></script>


    <!-- End custom js for this page-->
    <script src="{{ URL::asset('public/admin_assets/js/shared/jquery.cookie.js') }}" type="text/javascript"></script>
  </body>
</html>
