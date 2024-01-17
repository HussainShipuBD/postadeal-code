                                    <div id="chatuserlists">
                                        <?php if(!empty($chatdetail)) { ?>
                                            @foreach($chatdetail as $chatdetail)
                                                <li class="contact">
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
                                        <?php } else { ?>
                                                <li class="contact">
                                                    <div class="wrap">
                                                        No Users Found
                                                    </div>
                                                </li>
                                        <?php } ?>
                                        </div>