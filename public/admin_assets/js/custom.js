 /*$(document).ready(function(){
    // Prepare the preview for profile picture
    $("#wizard-itempicture").change(function(){
    if (this.files && this.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
        var count = $('#imgCount').val();
        var newcount = parseInt(count) + parseInt(1);
        alert(newcount);
        var data = "<div id='imageView+newcount'>
        <img src='/storage/app/public/products/thumb300/'+this.files[0].name class='borderCurve borderGradient picture-src dnone' id='wizardPicturePreview'
        style='width:100px;height:100px;object-fit: cover; margin-top:20px;'>
                           <span class='close' onclick='delete_image(newcount)'></span></br>
                           <input type = 'hidden' name = 'productImage[]' value='+this.files[0].name+'>
                         </div>";
$("#ProductImageView").html(data);

      $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
    }
    reader.readAsDataURL(this.files[0]);
    }

      });
  
  });*/



 // profile upload start
 $(document).ready(function(){
    // Prepare the preview for profile picture
    $("#wizard-picture").change(function(){
      readURL(this);
    });
  });

 function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
    }
    reader.readAsDataURL(input.files[0]);
  }
}

$(document).ready(function(){
    // Prepare the preview for profile picture
    $("#wizard-picture-add").change(function(){
      readURLADD(this);
    });
  });

$(document).ready(function(){
    // Prepare the preview for profile picture
    $("#wizard-picture-dark").change(function(){
      readURLDARK(this);
    });
  });


$(document).ready(function(){
  $("#cityChange").hide();
  $("#CountryChange").hide();
  $("#countryId").click(function(){
    $("#CountryEdit").hide();
    $("#CountryChange").show();
  });
  $("#countryId").change(function(){
    $("#cityEdit").attr('disabled', true).trigger("liszt:updated");
    $("#cityEdit").hide();
    $("#cityChange").show();
  });
});


function readURLADD(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $('#wizardPicturePreviewAdd').attr('src', e.target.result).fadeIn('slow');
    }
    reader.readAsDataURL(input.files[0]);
  }
}

function readURLDARK(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $('#wizardPicturePreviewDark').attr('src', e.target.result).fadeIn('slow');
    }
    reader.readAsDataURL(input.files[0]);
  }
}

$(document).ready(function () {
  $('#sidebarCollapse').on('click', function () {
    $('#sidebar').toggleClass('active');
  });
});

// Booking status
$("select[name='status']").change(function(){
  var statusId = $(this).val();
  var token = $("input[name='_token']").val();
  var ajaxURL = $("#ajax_url").attr('url');
  $("#element").hide();
  if(statusId){
    $.ajax({
      url: ajaxURL,
      method: 'GET',
      data: {statusId:statusId, _token:token},
      success: function(data) {
        $(".status_sorting").html('');
        $(".status_sorting").html(data.html);
      }
    }); 
  }
});

// add service
$("select[name='service_category_parent']").change(function(){
  var categoryId = $(this).val();
  var token = $("input[name='_token']").val();
  var ajaxURL = $("#ajax_url").attr('url');
  $("#element").hide();
  if(categoryId){
    $.ajax({
      url: ajaxURL,
      method: 'POST',
      data: {category_id:categoryId, _token:token},
      success: function(data) {
        $(".advanced_service_sec").html('');
        $(".advanced_service_sec").html(data.html);
      }
    }); 
  }
});

$("select[name='main_category_type']").change(function(){
  var categoryId = $(this).val();
  var ajaxURL = $("#ajax_url").attr('url');
  $("#element").hide();
  if(categoryId){
    $.ajax({
      url: ajaxURL,
      method: 'POST',
      data: {category_id:categoryId},
      success: function(data) {
        $("#super_sub_category").html('');
        $("#super_sub_category").html(data.html);
      }
    }); 
  }
});

$(document).on('click', '.toggle-password', function() {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $(".pass_log_id");
  input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
});


// category document details
$(document).ready(function () {
  $("#details").hide();
  $("#more").click(function(){
    $("#details").slideToggle(250);
  });
});

  // image validations
  $( "#wizard-picture").change(function() {
    var fileInput =  
    document.getElementById('wizard-picture'); 
    var filePath = fileInput.value; 
    // Allowing file type 
    var allowedExtensions =  
    /(\.jpg|\.jpeg|\.png)$/i; 
    if (!allowedExtensions.exec(filePath)) { 
      alert('Please upload an Image');  
      fileInput.value = ''; 
      return false; 
    }  
  });
  
  
  function addCurrencyCode(){
	  var countryDetails = $('#currency-currencydetails').val();
	  var details = countryDetails.split("-");
	  $('#currency-currencysymbol').val(details[0]);
	  $('#currency-currencyname').val(details[1]);
	  $('#currency-currencycode').val(details[2]);
  }

// switch language
$( "#language-selector" ).change(function() {
  var lang = $("#language-selector").val();
  window.location = baseURL + "/switchlang/" + lang;
});

$(document).ready(function() {
  $("input[type=number]").on("focus", function() {
    $(this).on("keydown", function(event) {
      if (event.keyCode === 38 || event.keyCode === 40) {
        event.preventDefault();
      }
    });
  });
});

// ck multiple editors
if( $('#editor1').length )  {

  ClassicEditor
  .create(document.querySelector('#editor1'), {
    toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
  })
  .then(editor => {
    window.editor = editor;
  })
  .catch(err => {
      // console.error(err.stack);
    });
}

if($('#editor2').length )  {

  ClassicEditor
  .create(document.querySelector('#editor2'), {
    toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
  })
  .then(editor => {
    window.editor = editor;
  })
  .catch(err => {
      // console.error(err.stack);
    });

}

if($('#editor3').length )  {

  ClassicEditor
  .create(document.querySelector('#editor3'), {
    toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
  })
  .then(editor => {
    window.editor = editor;
  })
  .catch(err => {
      // console.error(err.stack);
    });
}
