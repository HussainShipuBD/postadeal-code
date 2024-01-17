@if(Session::has('notification') && $message = Session::get('notification.message')) 
<div class="info_popup alert alert-dismissible fade show" role="alert">
           {{ $message }}
               <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="padding:0 0 0 12px; position: relative;">
                 <span aria-hidden="true">×</span>
               </button>
             </div>
@endif  
<?php
 Session::forget('notification'); 
 
 ?>  
<style>
.info_popup{
    background: #1c45ef;
    border-radius: 5px;
    height: auto;
    padding: 10px;
    position: absolute;
    top: 80px;
    right: 10px;
    max-width: 400px;
   -webkit-box-shadow: -2px 1px 20px -1px rgba(209,209,209,0.41);
    -moz-box-shadow: -2px 1px 20px -1px rgba(209,209,209,0.41);
    box-shadow: -2px 1px 20px -1px rgba(209,209,209,0.41);
    z-index: 999;
    color: #ffffff;

}
</style>
