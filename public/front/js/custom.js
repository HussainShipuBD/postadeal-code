var mapClick = 1;
var page = 1;
//var type = '';



// switch language
$( "#language-selector").change(function() {
  var lang = $("#language-selector").val();
  window.location = baseURL + "/switchlang/" + lang;
});

$(document).ready(function() {
  mapView();
});

  
  function initialize() {
      var input = document.getElementById('autocomplete');
      var autocomplete = new google.maps.places.Autocomplete(input);

      autocomplete.addListener('place_changed', function () {
          var place = autocomplete.getPlace();
          $('#search-latitude').val(place.geometry['location'].lat());
          $('#search-longitude').val(place.geometry['location'].lng());

          $('#searchpage-latitude').val(place.geometry['location'].lat());
          $('#searchpage-longitude').val(place.geometry['location'].lng());

          $("#latitudeArea").removeClass("d-none");
          $("#longtitudeArea").removeClass("d-none");
      });
  }


  function productinitialize() {
      var input = document.getElementById('productautocomplete');
      var autocomplete = new google.maps.places.Autocomplete(input);

      autocomplete.addListener('place_changed', function () {
          var place = autocomplete.getPlace();
          $('#products_lat').val(place.geometry['location'].lat());
          $('#products_lon').val(place.geometry['location'].lng());

          $("#latitudeArea").removeClass("d-none");
          $("#longtitudeArea").removeClass("d-none");
      });
  }


function mapView() {

  var location = $(".product-location-name").val();
  var latitude = $(".product-location-lat").val();
  var longitude = $(".product-location-long").val();
  //alert(location);
  $('#map_canvas').delay('700').fadeIn();
  $('#mobile_map_canvas').delay('700').fadeIn();

  if (mapClick == 1) {
    setTimeout(function () {
      showMap(location, latitude, longitude);
     }, 1000);
    mapClick = 0;
  }
}

function showMap(loc, lat, long) {
  var cityCircle;
  var location = loc;
  var myLatlng = new google.maps.LatLng(lat, long);
  var myOptions = {
    zoom: 15,
    center: myLatlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

  var marker = new google.maps.Marker({
    position: myLatlng,
    title: location,
  });

  var circleOptions = {
    strokeColor: '#2FDAB8',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#2FDAB8',
    fillOpacity: 0.35,
    map: map,
    center: myLatlng,
    radius: 300
  };
  cityCircle = new google.maps.Circle(circleOptions);
  marker.setMap(map);
}


function locationsearch() {
  var longitude = $("#search-longitude").val();
  var latitude = $("#search-latitude").val();
   var autocomplete = $("#autocomplete").val();
   var check = '';
    if(autocomplete == '')
     {
             check = "clear";   
             $.ajax({
                    url: baseURL + "/setcurrentlocation",
                    datatype: "html",
                    data: {"check": check},
                    type: "post",
                })
                .done(function (response) {
             //     console.log(response);
                   window.location = baseURL;

                })

     } else {
                   check = "unclear";   
             $.ajax({
                    url: baseURL + "/setcurrentlocation",
                    datatype: "html",
                    data: {"check": check, "locationname": autocomplete, "latitude": latitude, "longitude": longitude },
                    type: "post",
                })
                .done(function (response) {
                  var locationform = document.getElementById("locationsearch-page");
                  locationform.submit();
                })
  
     }
}

function itemnamesearch() {
      var itemnamesearch = document.getElementById("itemnamesearch-form");
      itemnamesearch.submit();
}

function selleridsearch() {
      var sellersearchpage = document.getElementById("sellersearch-page");
      sellersearchpage.submit();
}


    $(document).on('click', '#homeload_more', function(){
      page++;
            infinteLoadMore(page);
      })  

        function infinteLoadMore(page) {

            $.ajax({
                    url: baseURL + "/loadmoreitem?page=" + page,
                    datatype: "html",
                    type: "get",
                    beforeSend: function () {
                        $('.auto-load').show();
                    }
                })
                .done(function (response) {
                    if (response == "") {
                        $('#more-item').hide();
                        return;
                    }
                    $('.auto-load').hide();
                    $("#data-wrapper").append(response);
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
        }


    $(document).on('click', '#searchload_more', function(){
            infinteLoadMoresearch();
      })  


    $(document).on('click', '#complete-search', function(){

         const rbs = document.querySelectorAll('input[name="orderby"]');
            let selectedValue;
            for (const rb of rbs) {
                if (rb.checked) {
                    selectedValue = rb.value;
                    break;
                }
            }

         const rbsp = document.querySelectorAll('input[name="productcondition"]');
            let selectedValueproduct;
            for (const rbp of rbsp) {
                if (rbp.checked) {
                    selectedValueproduct = rbp.value;
                    break;
                }
            }

          //  alert(selectedValueproduct);
            $("#search-orderby").val(selectedValue);  
            $("#search-productcondition").val(selectedValueproduct);  
            $("#search-offset").val('');  
          var contentToRemove = document.querySelectorAll("#item-check");
          $(contentToRemove).remove(); 
          infinteLoadMoresearch();
      })  



     $(document).on('click', '#search_priceload', function(){
          var searchmin = $("#search-min").val();
          var searchmax = $("#search-max").val();

          if(searchmin == '' || searchmin == 0)
          {
         $("#Products_search_price").show();
        $('#Products_search_price').text('Please Select Minimum price');
        $('#Products_search_price').focus();
       setTimeout(function () {
            $("#Products_search_price").fadeOut();
        }, 3000);
        return false;            
          }
          else if(searchmax == '' || searchmax == 0)
          {
         $("#Products_search_price").show();
        $('#Products_search_price').text('Please Select Maximum price');
        $('#Products_search_price').focus();
       setTimeout(function () {
            $("#Products_search_price").fadeOut();
        }, 3000);
        return false;            
            
          } else {
          $("#search-offset").val('');  
          var contentToRemove = document.querySelectorAll("#item-check");
          $(contentToRemove).remove(); 
          infinteLoadMoresearch();
          }  
      })  

 $(document).on('click', '#slider', function(){
   var getkm = document.getElementById("slider-range-value2").innerText;
   var checkkm = getkm.replace('km ','');
   $("#search-offset").val('');
   $("#search-locationkm").val(checkkm);

 var contentToRemove = document.querySelectorAll("#item-check");
          $(contentToRemove).remove(); 
       infinteLoadMoresearch();
 })


        function infinteLoadMoresearch() {

          var searchmin = $("#search-min").val();
          var searchmax = $("#search-max").val();
          var productcondition = $("#search-productcondition").val();
          var orderby = $("#search-orderby").val();
          var offset = $("#search-offset").val();
          var limit = $("#search-limit").val();
          var type = $("#search-type").val();
          var longitude = $("#searchpage-longitude").val();
          var latitude = $("#searchpage-latitude").val();
          var itemnamesearch = $("#search-itemname").val();
          var itemsellerid = $("#search-selleruserId").val();
          var categoryId = $("#search-categoryId").val();
          var subcategoryId = $("#search-subcategoryId").val();
          var supercategoryId = $("#search-supercategoryId").val();
          var locationkm = $("#search-locationkm").val();

             $.ajax({
                    url: baseURL + "/searchloadmoreitem",
                    datatype: "html",
                    data: {"type": type, "categoryId": categoryId, "subcategoryId": subcategoryId, "supercategoryId" : supercategoryId, "searchmin": searchmin, "searchmax": searchmax, "itemsellerid": itemsellerid, "orderby": orderby, "productcondition": productcondition, "itemnamesearch": itemnamesearch, "longitude": longitude, "latitude": latitude, "locationkm": locationkm, "offset": offset, "limit": limit },
                    type: "post",
                    beforeSend: function () {
                        $('.auto-load').show();
                    }
                })
                .done(function (response) {
                  //console.log(response);
                    $('.auto-load').hide();
                    $("#data-wrapper-search").append(response.items);
                    $("#search-offset").val(response.itemcount);
                     $("#noresult-item").css("display", "none");

                    var count = response.itemcount;

                    if (offset >= count) {
                        $('#more-item-search').hide();
                        //return;
                    }

                    if (count == 0) {
                        $("#noresult-item").css("display", "block");
                    }


                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
        }



    $(document).on('click', '#loadMoreReview', function(){
      page++;
            infinteLoadMorereview(page);
      })  

        function infinteLoadMorereview(page) {
             var reviewsellerid = $(".product-sellerid-review").val();

            $.ajax({
                    url: baseURL + "/loadmorereview?page=" + page +"&reviewsellerid=" + reviewsellerid,
                    datatype: "html",
                    type: "get",
                    beforeSend: function () {
                        $('.auto-load').show();
                    }
                })
                .done(function (response) {
                //  console.log(response);
                    if (response == "") {
                        $('.review-load').hide();
                        return;
                    }
                    $('.auto-load').hide();
                    $("#data-loadreview").append(response);
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
        }


function start_image_upload() {
    var inp = document.getElementById('image1');
    uploadedfiles = $("#uploadedfiles").val();
    var maxsize = (inp.files[0].size);
    //alert(inp);
    if (maxsize > 2000000) {
        $("#image_error").show();
        $("#image_error").html("Image size doesn't exceed 2MB.");
        setTimeout(function () {
            $("#image_error").slideUp();
            $('#image_error').html('');
        }, 5000);
        return false;
    };
    if (uploadedfiles != "") {
        uploaded = jQuery.parseJSON(uploadedfiles);
        uploadedlen = uploaded.length;
    } else {
        uploadedlen = 0;
    }
    imagesarr = [];
    var i = 0,
        len = parseInt(inp.files.length, 10),
        img, reader, file;
    j = parseInt(document.getElementById('count').value, 10);
    var filePath = inp.value;
    var allowedExtensions = /(\.jpeg|\.jpg|\.png)$/i;
    if (!allowedExtensions.exec(filePath)) {
        $("#Products_image_em").show();
        $('#Products_image_em').text('Upload only image file');
        $('#Products_image_em').focus();
       setTimeout(function () {
            $("#Products_image_em").fadeOut();
        }, 3000);
        return false;
    }
    remainfiles = parseInt(10) - parseInt(uploadedlen);
    if (len == 0) {
        $("#Products_image_em").show();
        $('#Products_image_em').text('Please select image');
        $('#Products_image_em').focus();
       setTimeout(function () {
            $("#Products_image_em").fadeOut();
        }, 3000);
        return false;
    }
    let uploadfiles = j + len;
    if (uploadfiles > 5) {

        $("#Products_image_em").show();
        $('#Products_image_em').text('You can upload 5 images only..');
        $('#Products_image_em').focus();
       setTimeout(function () {
            $("#Products_image_em").fadeOut();
        }, 3000);
        return false;

    }
    formdata = new FormData();
    for (; i < len; i++) {
        file = inp.files[i];
        if (!!file.type.match(/image.*/)) {
            document.getElementById('count').value = (j + len);
            if (window.FileReader) {
                reader = new FileReader();
                reader.onloadend = function (e) { };
                reader.readAsDataURL(file);
            }
            if (formdata) {
                formdata.append("images[]", file);
            }
        }
    }
    var d = parseInt(document.getElementById('count').value, 10);
    if (formdata) {
          $.ajax({
                    url: baseURL + '/startfileupload',
                    type: "POST",
                    data: formdata,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                       $("#loadingimg").show();
                    }
                })
                .done(function (response) {
                  console.log(response);
                  resultupload = response.uploadedfiles;
                  viewimage = response.viewimage;
                  $("#new-uploadimage").append(viewimage);
                  inputfiles = $("#uploadedfiles").val();
                  if (inputfiles == "")
                        $("#uploadedfiles").val(resultupload);
                    else {
                        newfiles = resultupload.replace('[', '');
                        existfiles = $("#uploadedfiles").val();
                        existfiles = existfiles.replace(']', '');
                        $("#uploadedfiles").val(existfiles + ',' + newfiles);
                    }
                    
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log(thrownError);
                });

    }
}


$(document).on('change', '#products_category', function () {
    var productCategory = document.getElementById("products_category").value;
    var contentToRemove = document.querySelectorAll("#subcatvalue");
          $(contentToRemove).remove(); 
    var contentToRemovesuper = document.querySelectorAll("#supercatvalue");
          $(contentToRemovesuper).remove(); 

  $.ajax({
                    url: baseURL + "/selectcategory",
                    datatype: "html",
                    type: "POST",
                    data: {'catid': productCategory},
                    beforeSend: function () {
                        $('.auto-load').show();
                    }
                })
                .done(function (response) {
                 // console.log(response);
                    $("#select-maincat").val(productCategory);
                    $("#products_subcategory").append(response).selectpicker('refresh');
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
})


$(document).on('change', '#products_subcategory', function () {
    var maincat = document.getElementById("select-maincat").value;
    var subcat = document.getElementById("products_subcategory").value;
    var contentToRemove = document.querySelectorAll("#supercatvalue");
          $(contentToRemove).remove(); 

  $.ajax({
                    url: baseURL + "/selectsupercategory",
                    datatype: "html",
                    type: "POST",
                    data: {'maincat': maincat, 'subcat': subcat },
                    beforeSend: function () {
                        $('.auto-load').show();
                    }
                })
                .done(function (response) {
                    $("#select-subcat").val(subcat);
                    $("#products_supercategory").append(response).selectpicker('refresh');
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
})


$(document).on('change', '#products_supercategory', function () {
    var supercat = document.getElementById("products_supercategory").value;
    $("#select-supercat").val(supercat);
})

$(document).on('change', '#products_currency', function () {
    var productscurrency = document.getElementById("products_currency").value;
    $("#select-currency").val(productscurrency);
})


$(document).on('change', '#products_condition', function () {
    var productscondition = document.getElementById("products_condition").value;
    $("#select-productscondition").val(productscondition);
})

function validateaddress() {
      var name = $("#name").val();
      var address1 = $("#address1").val();
      var address2 = $("#address2").val();
      var country = $("#country").val();
      var phone = $("#phone").val();
      var zipcode = $("#zipcode").val();

      if (name == "") {
        $("#name-error").show();
        $('#name-error').focus();
       setTimeout(function () {
            $("#name-error").fadeOut();
        }, 3000);
        return false;
      }
      if (address1 == "") {
        $("#address1-error").show();
        $('#address1-error').focus();
       setTimeout(function () {
            $("#address1-error").fadeOut();
        }, 3000);
        return false;
      }
      if (address2 == "") {
        $("#address2-error").show();
        $('#address2-error').focus();
       setTimeout(function () {
            $("#address2-error").fadeOut();
        }, 3000);
        return false;
      }
      if (country == "") {
        $("#country-error").show();
        $('#country-error').focus();
       setTimeout(function () {
            $("#country-error").fadeOut();
        }, 3000);
        return false;
      }
      if (zipcode == "") {
        $("#zipcode-error").show();
        $('#zipcode-error').focus();
       setTimeout(function () {
            $("#zipcode-error").fadeOut();
        }, 3000);
        return false;
      }
      if (phone == "") {
        $("#phone-error").show();
        $('#phone-error').focus();
       setTimeout(function () {
            $("#phone-error").fadeOut();
        }, 3000);
        return false;
      }
      
}

function editaddress(addressId) {

    var name = $('#name'+addressId).val();
    var addressOne = $('#addressOne'+addressId).val();
    var addressTwo = $('#addressTwo'+addressId).val();
    var country = $('#country'+addressId).val();
    var zipcode = $('#zipcode'+addressId).val();
    var phone = $('#phone'+addressId).val();

    $('#addressId').val(addressId)
    $('#name').val(name);
    $('#address1').val(addressOne);
    $('#address2').val(addressTwo);
    $('#country').val(country);
    $('#zipcode').val(zipcode);
    $('#phone').val(phone);


}

function addaddress() {
    $('#addressId').val('')
    $('#name').val('');
    $('#address1').val('');
    $('#address2').val('');
    $('#country').val('');
    $('#zipcode').val('');
    $('#phone').val('');
}


function validateproduct() {

  var uploadedfiles = $("#uploadedfiles").val();
  var productImage = parseInt(document.getElementById('count').value, 10);
  var productname = $("#products_name").val();
  var maincat = $("#select-maincat").val();
  var subCatelength = $('#products_subcategory').children('option').length;
  var subCatevalue = $('#products_subcategory').val();
  var superCatelength = $('#products_supercategory').children('option').length;
  var superCatevalue = $('#products_supercategory').val();
  var productdesc = $(".products_desc").val();
  var productprice = $("#products_price").val();
  var productscondition = $("#products_condition").val();
  var location = $("#productautocomplete").val();
  var latitude = $("#products_lat").val();
  var longitude = $("#products_lon").val();
  var productbuynow = $("#products_buynow").val();
  var productshippingprice = $("#products_shipping_price").val();


  if (uploadedfiles == "") {
        $("#Products_image_em").show();
        $('#Products_image_em').text('Image Required');
        $('#Products_image_em').focus();
       setTimeout(function () {
            $("#Products_image_em").fadeOut();
        }, 3000);
        return false;
    }

  if (productImage == 0) {
        $("#Products_image_em").show();
        $('#Products_image_em').text('Upload atleast a single product image');
        $('#Products_image_em').focus();
       setTimeout(function () {
            $("#Products_image_em").fadeOut();
        }, 3000);
        return false;
    }

  if (productImage > 5) {
        $("#Products_image_em").show();
        $('#Products_image_em').text('You can upload 5 images only..');
        $('#Products_image_em').focus();
       setTimeout(function () {
            $("#Products_image_em").fadeOut();
        }, 3000);
        return false;
    }

  if (productname == "") {
        $("#Products_name_em").show();
        $('#Products_name_em').text('Product Name cannot be blank');
        $('#Products_name_em').focus();
       setTimeout(function () {
            $("#Products_name_em").fadeOut();
        }, 3000);
        return false;
    }

  if (maincat == "") {
        $("#Products_maincat_em").show();
        $('#Products_maincat_em').text('Product Category cannot be blank');
        $('#Products_maincat_em').focus();
       setTimeout(function () {
            $("#Products_maincat_em").fadeOut();
        }, 3000);
        return false;
    } 

      if (subCatelength > 1 && subCatevalue == '') {
        $("#Products_subcat_em").show();
        $('#Products_subcat_em').text('Product Sub Category cannot be blank');
        $('#Products_subcat_em').focus();
       setTimeout(function () {
            $("#Products_subcat_em").fadeOut();
        }, 3000);
        return false;
    }

   if (superCatelength > 1 && superCatevalue == '') {
        $("#Products_supercat_em").show();
        $('#Products_supercat_em').text('Product Super Category cannot be blank');
        $('#Products_supercat_em').focus();
       setTimeout(function () {
            $("#Products_supercat_em").fadeOut();
        }, 3000);
        return false;
         }

     if (productdesc == "" || productdesc.length == 0) {
            $("#Products_desc_em").show();
            $('#Products_desc_em').text('Product Description cannot be blank');
            $('#Products_desc_em').focus();
           setTimeout(function () {
                $("#Products_desc_em").fadeOut();
            }, 3000);
            return false;
        }

        if (productprice == "") {
                $("#Products_price_em").show();
                $('#Products_price_em').text('Product Price cannot be blank');
                $('#Products_price_em').focus();
               setTimeout(function () {
                    $("#Products_price_em").fadeOut();
                }, 3000);
                return false;

            }

    if (productscondition == "") {
            $("#Products_productcondition_em").show();
            $('#Products_productcondition_em').text('Product Condition cannot be blank');
            $('#Products_productcondition_em').focus();
           setTimeout(function () {
                $("#Products_productcondition_em").fadeOut();
            }, 3000);
            return false;
        }


    if(productbuynow == '1' && (productshippingprice == "" || productshippingprice == "0"))
    { 
            $("#Products_shippingprice_em").show();
            $('#Products_shippingprice_em').text('Product shipping price cannot be blank');
            $('#Products_shippingprice_em').focus();
           setTimeout(function () {
                $("#Products_shippingprice_em").fadeOut();
            }, 3000);
            return false;
    }        


     if (location == "") {

            $("#Products_location_em").show();
            $('#Products_location_em').text('Location Required');
            $('#Products_location_em').focus();
            $('#Products_location_em').keydown(function () {
                $('#Products_location_em').hide();
            });
            return false;
        }


    if (latitude == "" || longitude == "" || latitude == "0" || longitude == "0") {
        $("#Products_location_em").show();
        $('#Products_location_em').text('Invalid Location.Select Location From Drop Down.');
        $('#productautocomplete').focus();
        $('#productautocomplete').text('');
        $('#productautocomplete').keydown(function () {
            $('#Products_location_em').hide();
        });
        return false;
    } else {
        $('#Products_location_em').hide();
    }    

}


$(document).on('keyup', '#products_price', function (evt) {
    var $th = $(this);
    var before_decimal = $('#before_decimal').val();
    var after_decimal = $('#after_decimal').val();
    if (isNaN($th.val())) {
        $("#Products_price_em").show();
        $('#Products_price_em').text('Product Price invalid format');
        $('#Products_price_em').focus();
       setTimeout(function () {
            $("#Products_price_em").fadeOut();
        }, 3000);
        return false;
    } else {
        $("#Products_price_em").hide();
    }
    var number = ($(this).val().split('.'));
    if (number[0].length > before_decimal) {
        var res = $th.val().substr(0, before_decimal);
        $th.val(res);
        $("#Products_price_em").show();
        $('#Products_price_em').text('Invalid format (only ' + before_decimal + ' digit allowed before decimal point and ' + after_decimal + ' digit after decimal point)');
        $("#Products_price_em").fadeIn();
        setTimeout(function () {
            $("#Products_price_em").fadeOut();
        }, 3000);
        return false;
    }
    var length_before_decimal = number[0].length;
    var add_decimal_point = Number(length_before_decimal) + 1;
    var total_length;
    if (number[1].length > after_decimal) {
        total_length = Number(add_decimal_point) + Number(after_decimal);
        var res = $th.val().substr(0, total_length);
        $th.val(res);
        $("#Products_price_em").show();
        $('#Products_price_em').text('Invalid format (only ' + before_decimal + ' digit allowed before decimal point and ' + after_decimal + ' digit after decimal point)');
        $("#Products_price_em").fadeIn();
        setTimeout(function () {
            $("#Products_price_em").fadeOut();
        }, 3000);
        return false;
    }
});


$(document).on('keyup', '#products_shipping_price', function (evt) {
    var $th = $(this);
    var before_decimal = $('#before_decimal').val();
    var after_decimal = $('#after_decimal').val();
    if (isNaN($th.val())) {
        $("#Products_shippingprice_em").show();
        $('#Products_shippingprice_em').text('Product Shipping Price invalid format');
        $('#Products_shippingprice_em').focus();
       setTimeout(function () {
            $("#Products_price_em").fadeOut();
        }, 3000);
        return false;
    } else {
        $("#Products_price_em").hide();
    }
    var number = ($(this).val().split('.'));
    if (number[0].length > before_decimal) {
        var res = $th.val().substr(0, before_decimal);
        $th.val(res);
        $("#Products_shippingprice_em").show();
        $('#Products_shippingprice_em').text('Invalid format (only ' + before_decimal + ' digit allowed before decimal point and ' + after_decimal + ' digit after decimal point)');
        $("#Products_shippingprice_em").fadeIn();
        setTimeout(function () {
            $("#Products_shippingprice_em").fadeOut();
        }, 3000);
        return false;
    }
    var length_before_decimal = number[0].length;
    var add_decimal_point = Number(length_before_decimal) + 1;
    var total_length;
    if (number[1].length > after_decimal) {
        total_length = Number(add_decimal_point) + Number(after_decimal);
        var res = $th.val().substr(0, total_length);
        $th.val(res);
        $("#Products_shippingprice_em").show();
        $('#Products_shippingprice_em').text('Invalid format (only ' + before_decimal + ' digit allowed before decimal point and ' + after_decimal + ' digit after decimal point)');
        $("#Products_shippingprice_em").fadeIn();
        setTimeout(function () {
            $("#Products_shippingprice_em").fadeOut();
        }, 3000);
        return false;
    }
});


    $(document).on('click', '#listingload_more', function(){
      page++;
            infinteLoadMorelisting(page);
      })  

        function infinteLoadMorelisting(page) {

            $.ajax({
                    url: baseURL + "/loadmoreitemlisting?page=" + page,
                    datatype: "html",
                    type: "get",
                    beforeSend: function () {
                        $('.auto-load').show();
                    }
                })
                .done(function (response) {
                    if (response == "") {
                        $('#more-item-listing').hide();
                        return;
                    }
                    $("#data-wrapper-listing").append(response);
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });
        }


$(document).ready(function(){
  
  /* 1. Visualizing things on Hover - See next part for action on click */
  $('#stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
   
    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });
    
  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });
  
  
  /* 2. Action to perform on click */
  $('#stars li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    
    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
    var msg = "";
    if (ratingValue > 1) {
        msg = "Thanks! You rated this " + ratingValue + " stars.";
    }
    else {
        msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
    }

    $("#review_rating").val(ratingValue);
    responseMessage(msg);
    
  });
  
  
});


function responseMessage(msg) {
  $('.success-box').fadeIn(200);  
  $('.success-box div.text-message').html("<span>" + msg + "</span>");
}


$(document).on('click', '#buynow_check', function () {
    var products_buynow = document.getElementById("products_buynow").value;
//    alert(products_buynow);
    if(products_buynow == '0')
    { 
    $("#products_buynow").val('1');
    $('#shipping_check').show();
    } else {
    $("#products_buynow").val('0');
    $('#shipping_check').hide();
    }    

})

$(document).on('click', '#productstatus_change', function () {
    var products_aval = document.getElementById("product_availability").value;
    var itemId = document.getElementById("itemId").value;
    var cname = '';
    if(products_aval == 'available')
    {
      cname = 'sold';  
    } else {
      cname = 'available';  
    }    

    if (confirm('Are you sure product status change the '+cname)) {

                $.ajax({
                    url: baseURL + "/changeproductstatus",
                    datatype: "html",
                    data: {"cname": cname, "itemId": itemId},
                    type: "post",
                })
                .done(function (response) {
                  window.location = baseURL + "/editsell/" + itemId;
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });    

    } else 
    {
    return false;
    }    

})

$(document).on('click', '#productstatus_delete', function () {
    var itemId = document.getElementById("itemId").value;

 if (confirm('Are you sure delete the product')) {

                $.ajax({
                    url: baseURL + "/deleteproduct",
                    datatype: "html",
                    data: {"itemId": itemId},
                    type: "post",
                })
                .done(function (response) {
                  window.location = baseURL;
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                });    

    } else 
    {
    return false;
    }    
})



function validatereview() {

  var reviewdesc = $(".review_desc").val();
  var reviewrating = $("#review_rating").val();

  if (reviewdesc == "") {
        $("#seller_review_em").show();
        $('#seller_review_em').text('Please fill the review message');
        $('#seller_review_em').focus();
       setTimeout(function () {
            $("#seller_review_em").fadeOut();
        }, 5000);
        return false;
    }

  if (reviewrating == "0") {
        $("#seller_review_em").show();
        $('#seller_review_em').text('Please fill the Rating');
        $('#seller_review_em').focus();
       setTimeout(function () {
            $("#seller_review_em").fadeOut();
        }, 5000);
        return false;
    }

}
