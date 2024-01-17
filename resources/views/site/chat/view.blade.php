<?php
use App\Classes\MyClass;
$myClass = new MyClass();
?>


@extends('layouts.head')
@section('title', 'Home')
@section('content')  

<?php  
// echo "<pre>";
// print_r($chatdetail);
// die;

?>
  <div class="wrapper ovh position-relative">


        <section>
        <?php if(count($chatdetail) > 0) { ?>
            <input type="hidden" id="chat_exist" value="1"/>
            <div class="container-fluid">

                <div class="style2 mt-3 ml-1 ml-lg-3  back-opt ml-auto  d-lg-none my-3 justify-content-end ">
                    <button class="btn btn-thm2 d-flex align-items-center backtomove_cont ">
                        <i class="flaticon-left-arrow-1  fz18 mr-1 d-flex align-self-center"></i>
                        <span> Back </span>
                    </button>
                </div>
                <div class="row  my-4 message-con">
                    <div class="col-lg-12 wids">

                        <div class="row detail_common_row messages_height_div">
                            <div class="col-md-12 col-lg-3  mb-3 mb-md-0">
                                <div class="contact_sidebar contact_sidebar_div">
                                    <div class="message_container">

                                        <div class="inbox_user_list">
                                            <div class="iu_heading">
                                                <div class="candidate_revew_search_box">
                                                    
                                                        <input class="form-control" type="search" placeholder="Search"
                                                            aria-label="Search" id="searchchatuser">
                                                        <button class="btn" type="submit"><span
                                                                class="flaticon-loupe"></span></button>
                                                    
                                                </div>
                                            </div>
                                            <ul id="chat_search_user">
                                            <div id="chatuserlists">
                                            @foreach($chatdetail as $chatdetail)
                                                <li class="contact <?php echo $chatdetail['chatid']; ?>">
                                                    <a href="#" class="move_to-contact" onclick =" return userchat('{{$chatdetail['chatid']}}','{{$currentuserId}}');">
                                                        <div class="wrap">
                                                            <span class="contact-status online"></span>
                                                            <img class="img-fluid" src="{{$chatdetail['image']}}"
                                                                />
                                                            <div class="meta">
                                                                <h5 class="name">{{$chatdetail['name']}}</h5>
                                                                <p class="preview">
                                                    <?php if (strlen($chatdetail['lastmessage']) > 20) {

                                                            echo substr($chatdetail['lastmessage'], 0, 20) . "...";
                                                    } else {
                                                            echo $chatdetail['lastmessage'];
                                                    } ?>
                                                                        
                                                                    </p>
                                                            </div>
                                                            
                                                        </div>
                                                    </a>
                                                </li>
                                            @endforeach   
                                        </div>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-9">

                                <div class="message_container"  id="message_chat_users">
                                    <div id="user_chat_messages">
                                    <div class="user_heading">

                                        <div class="d-flex justify-content-between">
                                            <div class="wrap w-75">
                                                <span class="contact-status online"></span>
                                                <img class="img-fluid" src="{{$chatdetail['image']}}" alt="s5.jpg" />
                                                <div class="meta user_head ">
                                                    <h5 class="name">{{$chatdetail['name']}}</h5>
                                                    <?php if($chatdetail['onlinestatus'] == '1') { ?>
                                                        <p class="preview onlinestatus">$chatdetail['onlinestatus']</p>
                                                    <?php } else { ?>
                                                        <p class="preview onlinestatus"></p>

                                                    <?php } ?>
                                                </div>
                                            </div>


                                            <div class="user_setting ">
                                                <div class="dropdown">
                                                    <a class="btn dropdown-toggle" href="#" data-toggle="dropdown">
                                                        <div class="d-flex">
                                                            <div class=" dropdown_menubar">

                                                                <i class="flaticon-menu fz24"></i>

                                                            </div>
                                                        </div>
                                                    </a>

                                                    <div class="dropdown-menu">

                                                        <div class="user_setting_content ">
                                                            <a class="dropdown-item active" href="#">Block</a>
                                                            <a class="dropdown-item active" data-toggle="modal"
                                                                data-target=".bd-coupen-modal" href="#">
                                                                Create Coupen

                                                            </a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="inbox_chatting_box">
                                        <ul class="chatting_content">

                                        
                                          
                                        @foreach($chatMesssages as $chatMesssages)
                                        <?php if($chatMesssages['userId'] != $currentuserId) { ?>
                                            <div class="d-flex flex-column py-3 px-4">
                                                <div class="receivedSection">
                                                    <div class="date_time">{{Carbon\Carbon::parse($chatMesssages['createdAt'])->format('j M, Y, H:i')}}</div>
                                                    <div class="parent white-spaces">

                                                        <p>{{$chatMesssages['message']}}</p>
                                                    </div>
                                                </div>
                                        <?php } else { ?>
                                                <div class="sendingSection">
                                                    <div class="date_time">{{Carbon\Carbon::parse($chatMesssages['createdAt'])->format('j M, Y, H:i')}}</div>
                                                    <div class="parent white-spaces">

                                                        <p>{{$chatMesssages['message']}}</p>
                                                    </div>
                                                </div>
                                        <?php } ?>
                                                
                                        @endforeach  

                                              <!--  <div class="requestBox">
                                                    <div class="mb-2 text-gray-color fz17 text-center">Coupen is created
                                                    </div>

                                                    <div class="parent receiver cursorPointer">
                                                        <div class="fz17"> "First Sale"</div>
                                                        <div class="date_time fz17"> 1min ago </div>
                                                    </div>
                                                </div>-->



                                               <!--<div class="sendingSection">
                                                    <div class="date_time">Today, 10:40</div>
                                                    <div class="parent white-spaces">

                                                        <div class="msg_images">
                                                            <img src="./images/products/bike.jpg" />
                                                        </div>
                                                    </div>
                                                </div>






                                                <div class="receivedSection">
                                                    <div class="date_time">Today, 10:39</div>
                                                    <div class="parent white-spaces">
                                                        <div class="msg_images">
                                                            <img src="./images/products/car.jpg" />
                                                        </div>
                                                    </div>
                                                </div>-->

                                    



                                        </ul>
                                    </div>
                                    
                                </div>


                                </div>
                                <div class="mi_text">
                                        <div class="message_input">
                                            <form class="form-inline">
                                                <textarea onkeyup="typing_status();" class="form-control" type="search" id="msg_box"
                                                    placeholder="Enter text here..." aria-label="Search" cols="60"
                                                    rows="2" id="message"></textarea>
                                                <div class="mx-2 ml-auto d-flex align-items-center ">
                                                    <div class="messages_filetype ">
                                                        <input type="file" name="image1" id="image1" onchange="uplo();"
                                                            accept=".gif, .jpg, .png" />
                                                        <label for="image1" class="cursor-pointer">
                                                            <span>
                                                                <i class="fa fa-paperclip fz24 mx-3 "></i>
                                                            </span>
                                                        </label>
                                                    </div>



                                                    <!-- <div class="mx-2"><a href="#" data-toggle="modal"
                                                            data-target=".bd-example-modal-lg">
                                                            <i class="fa fa-map-marker fz24 mx-2"></i> </a> </div> -->

                                                </div>

                                                

                                                <!-- <i class="flaticon-pin fz24  ml-2" ></i> -->
                                                
                                           <button type="button" onclick="sendmessage();" class="btn  ml-0"><i class="flaticon-right-arrow d-flex"></i></button>
                                            </form>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php } else { ?>
            <input type="hidden" id="chat_exist" value="0"/>
            <div id="data-wrapper-search">
                <div class="noresult-item" id="noresult-item"> <img src="https://postadeal.com/storage/app/public/admin_assets/noresult.png" alt="noresult.png"> </div>
            </div>
        <?php } ?>
        </section>
    </div>

@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<script>
    var baseURL = "{{ url('/') }}";
    // var socket = io.connect('https://localhost:8081', {secure: false});
    // var socket_url = '<?php //echo env('APP_SOCKETURL'); ?>';
    var socket_url = 'https://postadeal.com:8081';
    const socket = io.connect(socket_url, {reconnect: true});
    console.log(socket);

    $( document ).ready(function() {

        var chat_exist = $('#chat_exist').val();
        // alert(chat_exist);
        if(chat_exist == '1') {
            var logged_user_id = '<?php echo $currentuserId; ?>';
            var curren_chat_id = '<?php echo $chatId; ?>';
            userchat(curren_chat_id, logged_user_id);
        }
        
    });
    
    

    socket.on('message', (data)=> { 
        var userId = $('#loginuserId').val();

        if(data.sender_id != userId) {
            console.log('received message',data);
            var attachment = data.attachment;
            var message = data.message;
            var message_time = data.message_time;
            var formatted_time = time_format(message_time);
            if(attachment.trim() == '') {
                $('.chatting_content_app').append('<div class="receivedSection"><div class="date_time">'+formatted_time+'</div><div class="parent white-spaces"><p>'+message+'</p></div></div>');
                scrollSmoothToBottom('msg_box_chatting_id');
            }
            else {
                $('.chatting_content_app').append('<div class="receivedSection"><div class="date_time">'+formatted_time+'</div><div class="parent white-spaces"><div class="msg_images"><img src="'+attachment+'" /></div></div></div>');
                scrollSmoothToBottom('msg_box_chatting_id');
            }
        }
        
        
    });

    socket.on('typing', (data)=> { 
        var userId = $('#loginuserId').val();
        if(data.sender_id != userId) {
            console.log('received message',data);
            if(data.typing == 'true'){
                $('.onlinestatus').html('typing..');
                setTimeout(function(){ $('.onlinestatus').html('online'); }, 3000);
            }
            else {
                $('.onlinestatus').html('online');
            }
        }
    });

    socket.on('online', (data)=> { 
        var receiverId = $('#receiverId').val();
        console.log('onlinestatus',data);
        if(data.user_id == receiverId) {
            if(data.status != 'offline'){
                $('.onlinestatus').html(data.status);
            }
            else {
                var lastactive = $('#lastactive').val();
                console.log(lastactive);
                var obj_date = new Date(parseInt(lastactive));
                console.log(obj_date);
                var formatted_date = obj_date.toLocaleString(); // '23/01/2019, 17:23:42'
                $('.onlinestatus').html('Last seen at '+formatted_date);
            }
        }
    });
    function online_status () {
        var userId = $('#loginuserId').val();
        var chatId = $('#source').val();
        var receiverId = $('#receiverId').val();
        var obj = {};
        obj.sender_id = userId;
        obj.receiver_id = receiverId;
        obj.chat_id = chatId;
        socket.emit("online",obj);
    }
    function typing_status() {
        var userId = $('#loginuserId').val();
        var chatId = $('#source').val();
        var receiverId = $('#receiverId').val();
        var obj = {};
        obj.sender_id = userId;
        obj.receiver_id = receiverId;
        obj.chat_id = chatId;
        obj.typing = 'true';
        socket.emit("typing",obj);

    }
    function time_format(date) {
        var date_format = '12'; /* FORMAT CAN BE 12 hour (12) OR 24 hour (24)*/
 
 
        var d = new Date(date);
        console.log(d);
        var hour    = d.getHours();  /* Returns the hour (from 0-23) */
        var minutes     = d.getMinutes();  /* Returns the minutes (from 0-59) */
        var result  = hour;
        var ext     = '';
        
        if(date_format == '12'){
            if(hour > 12){
                ext = 'PM';
                hour = (hour - 12);
                result = hour;

                if(hour < 10){
                    result = "0" + hour;
                }else if(hour == 12){
                    hour = "00";
                    ext = 'AM';
                }
            }
            else if(hour < 12){
                result = ((hour < 10) ? "0" + hour : hour);
                ext = 'AM';
            }else if(hour == 12){
                ext = 'PM';
            }
        }
        
        if(minutes < 10){
            minutes = "0" + minutes; 
        }
        
        result = result + ":" + minutes + ' ' + ext; 
        
        return result;
    }
</script>
<script>
        $('.radioboxstyle input.custom-control-input').on('change', function () {
            $(' .radioboxstyle input.custom-control-input ').not(this).prop('checked', false);
        });

</script>   

<script>


            

$(document).on('keyup', '#searchchatuser', function () {
                
    var searchtxt = $(this).val();
    var userId = $('#loginuserId').val();


  //  if(searchtxt.length > 2) {


        $.ajax({
                url: baseURL +"/chat/searchchatuser",
                type: "POST",
                data:{ userId : userId, searchtxt : searchtxt },
                success: function (res) {
                    if(res){
                       
                        $('#chatuserlists').remove();
                       $('#chat_search_user').append(res);

                       return false;
                    }
                    else{
                        return false; 
                    }
                }
            });
        return false;
        
    //}

    return false;
});
function uplo() {
    var media_url = '<?php echo env('APP_URL'); ?>';
    var userId = $('#loginuserId').val();
    var chatId = $('#source').val();
    var receiverId = $('#receiverId').val();
    const fileInput = document.querySelector("#image1");
    const validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];
    if (validImageTypes.includes(fileInput.files[0].type)) {
        if(fileInput.files[0].size <= 2001000) {
            const formData = new FormData();
            formData.append("image", fileInput.files[0]);
            formData.append("type", 'chat');
            formData.append("lang_code","en");
            var url = `${media_url}api/imageupload`;
            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                success: function (res) {
                    // var response = JSON.parse(res);
                    console.log(res);
                    if(res.status === 'true') {
                        $.ajax({
                            url: baseURL + "/chat/postmessage",
                            type: "POST",
                            dataType : "html",
                            data:{ userId : userId, chatId : chatId, message : '', attachment : res.image_name },
                            success: function (res1) {
                                if(res1){
                                    var date = new Date();
                                    var formatted_date = date.toISOString();
                                    var chat_formatter = time_format(formatted_date);
                                    var obj = {};
                                    obj.sender_id = userId;
                                    obj.receiver_id = receiverId;
                                    obj.chat_id = chatId;
                                    obj.message = '';
                                    obj.message_time = formatted_date;
                                    obj.attachment = res.original_image;
                                    console.log(obj);
                                    socket.emit("message",obj);
                                    $('.chatting_content_app').append('<div class="sendingSection"><div class="date_time">'+chat_formatter+'</div><div class="parent white-spaces"><div class="msg_images"><img src="'+res.original_image+'" /></div></div></div>');
                                    $('#msg_box').val('');
                                    scrollSmoothToBottom('msg_box_chatting_id');
                                    return false; 
                                }
                                else{
                                    return false; 
                                }
                            }
                        });
                        
                    } 
                    else {
                        alert('Image fail to upload!');
                    }
                }
                
            });
        }
        else {
            
            alert('Upload file size should be less than 2MB!');
        }
    }
    else {
        alert('Upload only Images!');
    }

}
function sendmessage() {
    var userId = $('#loginuserId').val();
    var chatId = $('#source').val();
    var message = $('#msg_box').val();
    var receiverId = $('#receiverId').val();
    if(message.trim() != '') {
        $.ajax({
            url: baseURL + "/chat/postmessage",
            type: "POST",
            dataType : "html",
            data:{ userId : userId, chatId : chatId, message : message },
            success: function (res1) {
                if(res1){
                    var date = new Date();
                    var formatted_date = date.toISOString();
                    var chat_formatter = time_format(formatted_date);
                    var obj = {};
                    obj.sender_id = userId;
                    obj.receiver_id = receiverId;
                    obj.chat_id = chatId;
                    obj.message = message;
                    obj.message_time = formatted_date;
                    obj.attachment = '';
                    console.log(obj);
                    socket.emit("message",obj);
                    $('.chatting_content_app').append('<div class="sendingSection"><div class="date_time">'+chat_formatter+'</div><div class="parent white-spaces"><p>'+message+'</p></div></div>');
                    $('#msg_box').val('');
                    scrollSmoothToBottom('msg_box_chatting_id');
                    return false; 
                }
                else{
                    return false; 
                }
            }
        });
    }
    else {
        alert('Enter Message');
    }
}







function userchat(chatId , userId) {
            $.ajax({
                url: baseURL + "/chat/userchat",
                type: "POST",
                dataType : "html",
                data:{ userId : userId, chatId : chatId },
                success: function (res) {
                    if(res){
                       $('.contact').removeClass('active');
                       $('.'+chatId).addClass('active');
                       $('#user_chat_messages').remove();
                       $('#message_chat_users').append(res);
                       var liveme_userId = $('#loginuserId').val();
                        var join_chatId = $('#source').val();
                        socket.emit("liveMe",{"user_id":liveme_userId});
                        socket.emit("join",join_chatId);
                       setInterval(online_status, 1000);
                       return false;
                    }
                    else{
                        return false; 
                    }
                }
            });
                return false;

}

function scroll_to_end() {
    // var element = $('.inbox_chatting_box');
    // element.scrollTop + element.clientHeight == element.scrollHeight;
    var elem = document.getElementsByClassName('inbox_chatting_box');
    elem.scrollTop = elem.scrollHeight;
}
function scrollSmoothToBottom (id) {
   var div = document.getElementById(id);
   $('#' + id).animate({
      scrollTop: div.scrollHeight - div.clientHeight
   }, 500);
}

</script>  
