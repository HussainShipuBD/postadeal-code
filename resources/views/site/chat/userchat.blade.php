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
                                <p class="preview onlinestatus">was online today at 11:43</p>

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
            <div id="msg_box_chatting_id" class="inbox_chatting_box">
                <ul class="chatting_content">
                <div class="d-flex flex-column py-3 px-4 chatting_content_app">
                
                    
                <?php
                foreach($chatMesssages as $chatMesssages) {
                if(array_key_exists('attachment', $chatMesssages) && $chatMesssages['attachment'] != '') {
                    if($chatMesssages['userId'] != $currentuserId) { ?>
                        <div class="receivedSection">
                            <div class="date_time">{{Carbon\Carbon::parse($chatMesssages['createdAt'])->format('j M, Y, H:i')}}</div>
                            <div class="parent white-spaces">

                                <div class="msg_images">
                                    <img src="<?php echo URL::to('/storage/app/public/chats/')."/"; ?>{{$chatMesssages['attachment']}}" />
                                </div>
                            </div>
                        </div>
                        
                    <?php } else { ?>
                        
                        <div class="sendingSection">
                            <div class="date_time">{{Carbon\Carbon::parse($chatMesssages['createdAt'])->format('j M, Y, H:i')}}</div>
                            <div class="parent white-spaces">

                                <div class="msg_images">
                                    <img src="<?php echo URL::to('/storage/app/public/chats')."/"; ?>{{$chatMesssages['attachment']}}" />
                                </div>
                            </div>
                        </div>
                <?php } 
                } else {
                    if($chatMesssages['userId'] != $currentuserId) {
                ?>
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
                <?php } } } ?>
                 

                        <!--  <div class="requestBox">
                            <div class="mb-2 text-gray-color fz17 text-center">Coupen is created
                            </div>

                            <div class="parent receiver cursorPointer">
                                <div class="fz17"> "First Sale"</div>
                                <div class="date_time fz17"> 1min ago </div>
                            </div>
                        </div>-->



                       

                <div id="sendermessage<?php echo $chatMesssages['chatId'].$currentuserId;?>"></div>


                </div>
                </ul>
                <input id="source" name="sourcce" type="hidden" value="{{$chatId}}" />
                <input id="receiverId" name="receiverId" type="hidden" value="{{$chatdetail['id']}}" />
                <input id="loginuserId" name="loginuser" type="hidden" value="{{$currentuserId}}" />
                <input id="lastactive" name="lastactive" type="hidden" value="{{$chatdetail['lastActive']}}" />
            </div>
        </div>
        