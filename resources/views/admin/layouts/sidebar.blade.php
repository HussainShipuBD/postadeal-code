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
    <link rel="stylesheet" href="{{ URL::asset('public/admin_assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/admin_assets/vendors/iconfonts/ionicons/dist/css/ionicons.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/admin_assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/admin_assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('public/admin_assets/vendors/css/vendor.bundle.addons.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="{{ URL::asset('public/admin_assets/vendors/iconfonts/font-awesome/css/font-awesome.min.css') }}" />
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ URL::asset('public/admin_assets/css/shared/style.css') }}">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ URL::asset('public/admin_assets/css/demo_1/style.css') }}">
    
    
    <!-- End Layout styles -->
    <link rel="shortcut icon" href="{{ URL::asset('storage/app/public/admin_assets/fav-icon') }}" />
  </head>
  <body>
    <div class="container-scroller">
    
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
    <a href="{{ route('index') }}"><!--<h5 style="color: #fff;
font-weight: bold;
padding: 15px;
font-size: 30px;"><?php echo $settings->siteName; ?></h5>-->
	<img src="{{ URL::asset('storage/app/public/admin_assets/logo.png') }}" class="admin-logo" alt="Logo">
	</a>
    
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center">
    <ul class="navbar-nav">
     
      <!--<li class="nav-item dropdown language-dropdown">
        <a class="nav-link dropdown-toggle px-2 d-flex align-items-center" id="LanguageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
       
          <span class="profile-text font-weight-medium d-none d-md-block">English</span>
        </a>
        <div class="dropdown-menu dropdown-menu-left navbar-dropdown py-2" aria-labelledby="LanguageDropdown">
          <a class="dropdown-item">
            <div class="flag-icon-holder">
              <i class="flag-icon flag-icon-us"></i>
            </div>English
          </a>
          <a class="dropdown-item">
            <div class="flag-icon-holder">
              <i class="flag-icon flag-icon-fr"></i>
            </div>French
          </a>
          <a class="dropdown-item">
            <div class="flag-icon-holder">
              <i class="flag-icon flag-icon-ae"></i>
            </div>Arabic
          </a>
          <a class="dropdown-item">
            <div class="flag-icon-holder">
              <i class="flag-icon flag-icon-ru"></i>
            </div>Russian
          </a>
        </div>
      </li>-->
    </ul>
  
    <ul class="navbar-nav ml-auto">
    
      <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
        <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
          <img class="img-xs rounded-circle" src="{{ URL::asset('storage/app/public/admin_assets/face8.png') }}" alt="Profile image"> </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown" style="min-width: 150px; padding-bottom: 10px;">
          
          <a href="{{ route('settings.editadmin') }}" class="dropdown-item" style="padding-left:35px; padding-top: 20px;">Edit Profile<i class="dropdown-item-icon ti-dashboard"></i></a>

          <a href="{{ route('settings.editpassword') }}" class="dropdown-item" style="padding-left:35px;">Change Password<i class="dropdown-item-icon ti-dashboard"></i></a>

          <a onclick="event.preventDefault();document.getElementById('logout-form').submit();" href="javascript:void(0)" class="dropdown-item" style="padding-left:35px;">Sign Out<i class="dropdown-item-icon ti-power-off"></i></a>
          <form id="logout-form" action="{{ route('adminlogout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>

<div class="container-fluid page-body-wrapper">

<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <!--<li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        <div class="profile-image">
          <img class="img-xs rounded-circle" src="assets/images/faces/face8.jpg" alt="profile image">
          <div class="dot-indicator bg-success"></div>
        </div>
        <div class="text-wrapper">
          <p class="profile-name">Allen Moreno</p>
          <p class="designation">Premium user</p>
        </div>
      </a>
    </li>
    <li class="nav-item nav-category">Main Menu</li>-->
    <li class="nav-item">
      <a class="nav-link" href="{{ route('index') }}">
        <i class="mdi mdi-view-dashboard nav-side-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <!--Category Section -->

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#user-basic" aria-expanded="false" aria-controls="user-basic">
        <i class="mdi mdi-account-multiple nav-side-icon"></i>
        <span class="menu-title">Manage Users</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="user-basic">
        <ul class="nav flex-column sub-menu">
         <li class="nav-item">
            <a class="nav-link" href="{{ route('users.approved') }}">Approved Users</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('users.pending') }}">Pending Users</a>
          </li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#product-basic" aria-expanded="false" aria-controls="product-basic">
        <i class="mdi mdi-account-multiple nav-side-icon"></i>
        <span class="menu-title">Manage Products</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="product-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('products.approved') }}">Approved Items</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('products.pending') }}">Pending Items</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('products.reports') }}">Report Items</a>
          </li>
        </ul>
      </div>
    </li>
    
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#promotion-basic" aria-expanded="false" aria-controls="promotion-basic">
        <i class="mdi mdi-camera-enhance nav-side-icon"></i>
        <span class="menu-title">Manage Promotions</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="promotion-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('promotions.index') }}">Promotion Lists</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('promotions.create') }}">Add Promotion</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('promotions.currency') }}">Promotion Currency</a>
          </li>
        </ul>
      </div>
    </li>

     <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#category-basic" aria-expanded="false" aria-controls="category-basic">
        <i class="mdi mdi-view-grid nav-side-icon"></i>
        <span class="menu-title">Categories</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="category-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('category.index') }}">Main Category</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('subcategories.index') }}">Sub Category</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('supercategories.index') }}">Super Category</a>
          </li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#properties-basic" aria-expanded="false" aria-controls="properties-basic">
        <i class="mdi mdi-archive nav-side-icon"></i>
        <span class="menu-title">Product Properties</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="properties-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('productconditions.index') }}">Product Conditions</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('currency.index') }}">Manage Currency</a>
          </li>
          <!--<li class="nav-item">
            <a class="nav-link" href="{{ route('locations.index') }}">Manage Location</a>
          </li>-->
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#commission-basic" aria-expanded="false" aria-controls="commission-basic">
        <i class="mdi mdi-camera-enhance nav-side-icon"></i>
        <span class="menu-title">Manage Commission</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="commission-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('commissions.index') }}">Commission Lists</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('commissions.create') }}">Add Commission</a>
          </li>
        </ul>
      </div>
    </li>
    
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#orders-basic" aria-expanded="false" aria-controls="orders-basic">
        <i class="mdi mdi-truck nav-side-icon"></i>
        <span class="menu-title">Manage Orders</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="orders-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('orders.neworders') }}">New Orders</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('orders.delivered') }}">Delivered Orders</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('orders.settled') }}">Settled Orders</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('orders.cancelled') }}">Cancelled Orders</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('orders.refundedorders') }}">Refund Orders</a>
          </li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#site-basic" aria-expanded="false" aria-controls="site-basic">
        <i class="mdi mdi-settings nav-side-icon"></i>
        <span class="menu-title">Site Management</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="site-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('banner.index') }}">Banner Management</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('settings.logo') }}">Logo Management</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('settings.default') }}">Default Settings</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('settings.smtp') }}">SMTP Settings</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('settings.stripe') }}">Stripe Settings</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('settings.notification') }}">Notification Settings</a>
          </li>
        </ul>
      </div>
    </li>

     <li class="nav-item">
      <a class="nav-link" href="{{ route('helps.index') }}">
        <i class="mdi mdi-lightbulb-on nav-side-icon"></i>
        <span class="menu-title">Help Management</span>
      </a>
    </li>
    
    
    
    
  </ul>
</nav>
