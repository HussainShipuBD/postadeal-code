<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Product;
use App\Models\Currency;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Supercategory;
use App\Models\Location;
use App\Models\Productcondition;
use App\Models\Review;
use App\Classes\MyClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    
    public function show($chat_id = null)
    {
        $myClass = new MyClass();

        $user = Auth::user();
        $userId = Auth::id();

        $userChats = Chat::where("userId",$userId)->orWhere("sellerId",$userId)->orderBy('chatDate', 'desc')->get()->toArray();
        $chatdetail = array();
        $chatMesssages = array();
        $chatId = '';
        if(count($userChats) > 0) {
            foreach($userChats as $key => $userChat) {
                if($userId != $userChat['sellerId']) {
                    $chatuserId = $userChat['sellerId'];
                    $userdetail = User::find($chatuserId);
                    $chatdetail[$key]['chatid'] = $userChat['_id'];
                    $chatdetail[$key]['id'] = $userdetail['_id'];
                    $chatdetail[$key]['name'] = $userdetail['name'];
                    $chatdetail[$key]['onlinestatus'] = $userdetail['online_status'];
                    $chatdetail[$key]['lastActive'] = $userdetail['lastActive'];
                    if(!empty($userdetail['image']) && isset($userdetail['image'])) {
                        $chatdetail[$key]['image'] = url('/storage/app/public/users/thumb100/'.$userdetail['image']);
                    } else {
                        $chatdetail[$key]['image'] = url('/storage/app/public/users/thumb100/default.png');
                    }
                    $chatdetail[$key]['lastmessage'] = $userChat['lastMessageOn'];
                }
                if($userId != $userChat['userId']) {
                    $chatuserId = $userChat['userId'];
                    $userdetail = User::find($chatuserId);
                    $chatdetail[$key]['chatid'] = $userChat['_id'];
                    $chatdetail[$key]['id'] = $userdetail['_id'];
                    $chatdetail[$key]['name'] = $userdetail['name'];
                    $chatdetail[$key]['onlinestatus'] = $userdetail['online_status'];
                    $chatdetail[$key]['lastActive'] = $userdetail['lastActive'];
                    if(!empty($userdetail['image']) && isset($userdetail['image'])) {
                        $chatdetail[$key]['image'] = url('/storage/app/public/users/thumb100/'.$userdetail['image']);
                    } else {
                        $chatdetail[$key]['image'] = url('/storage/app/public/users/thumb100/default.png');
                    }
                    $chatdetail[$key]['lastmessage'] = $userChat['lastMessage'];
                }
            }
            if(!$chat_id) {
                $chatId = $userChats[0]['_id'];
            }
            else {
                $chatId = $chat_id;
            }
        }
        
        

        $chatMesssages = Message::where("chatId",$chatId)->orderBy('createdAt', 'asc')->get()->toArray();


        //$userdetails = $myclass->get_userdetails($userdetail);

       // $userdetails = User::where('_id', $userdetail)->get()->toArray();


        // echo "<pre>"; print_r($chatdetail);print_r($chatdetail); die;
        return view('site.chat.view' , ['chatdetail' => $chatdetail , 'chatMesssages' => $chatMesssages , 'currentuserId' => $userId , 'chatId' => $chatId]);

    }

    public function createchat() {
        // echo $today = Carbon::now()->format('Y-m-d H:i:s.z');
        // die;
        if($_POST['type'] == 'user') {
            $userId = $_POST['userId'];
            $sellerId = $_POST['sellerId'];
        }
        $today = Carbon::now()->format('Y-m-d H:i:s.z');
        $itemId = $_POST['itemId'];
        $chatExists = Chat::
          where('userId',$userId)
        ->where('sellerId',$sellerId)
        ->where('itemId',$itemId)
        ->count();
        // echo $chatExists;
        if($chatExists === 0) {
            if($_POST['type'] == 'user') {
                $userdetails = User::find($userId);
                if (!$userdetails) {
                    return response(['status'=>'false','message'=>'User Not Register'], 200);

                }
                if($userdetails['status'] == 0) {
                    return response(['status'=>'false','message'=>'Account Blocked By Admin'], 200);
                }
                $new_chat = new Chat;
                $new_chat->itemId = $itemId;
                $new_chat->sellerId = $sellerId;
                $new_chat->userId = $userId;
                $new_chat->chatDate = $today;
                $new_chat->chatBlockByUser = 'false';
                $new_chat->chatBlockBySeller = 'false';
                $new_chat->unread = 'true';
                $new_chat->lastMessageOn = $today;
                $new_chat->updated_at = $today;
                $new_chat->created_at = $today;
                $new_chat->chatClearUpdatedUser = 0;
                $new_chat->chatClearUpdatedSeller = 0;
                $new_chat->save();  
                $chat_id = $new_chat->id;
                return response(['status'=>'true','short_code'=>'new','message'=>'Chat Created Successfully','chat_id'=>$chat_id], 200);
            }
        }
        else {
            $chatInfo = Chat::
            where('userId',$userId)
            ->where('sellerId',$sellerId)
            ->where('itemId',$itemId)
            ->first();

            return response(['status'=>'true','short_code'=>'exist','message'=>'Chat Already Created Successfully','chat_id'=>$chatInfo['_id']], 200);
        }
        
    }
    public function postmessage()
    {
        $userId = $_POST['userId'];
        $chatId = $_POST['chatId'];
        $postmessage = $_POST['message'];
        $attachment = isset($_POST['attachment']) ? $_POST['attachment'] : '';
        $message = new Message();

        //$today = Carbon::today();

        $today = Carbon::now()->format('Y-m-d H:i:s.z');
        
        $message->chatId = $chatId;
        $message->userId = $userId;
        $message->message = $postmessage;
        $message->attachment = $attachment;
        $message->type = "text";
        if($attachment && $attachment != '') {
            $message->type = "attachment";
        }
        $message->initial_message = "false";
        $message->createdAt = $today;
        $message->save();

        $chatdetail = Chat::find($chatId);

        if($chatdetail['sellerId'] == $userId) {
            $receiverId = $chatdetail['userId'];
            $chatUpdatedSeller = 0;
            $chatUpdatedUser = $chatdetail['chatClearUpdatedUser'];
        } else {
            $receiverId = $chatdetail['sellerId'];
            $chatUpdatedSeller = $chatdetail['chatClearUpdatedSeller'];
            $chatUpdatedUser = 0;
        }
        $chatdetail->chatClearUpdatedUser = $chatUpdatedUser;
        $chatdetail->chatClearUpdatedSeller = $chatUpdatedSeller;
        $chatdetail->lastMessage = $postmessage;
        $chatdetail->lastMessageOn = $today;
        $chatdetail->lastMessageUser = $userId;
        $chatdetail->unread = "true";

        $chatdetail->save();

        echo $today; die;

        echo "<li class='media reply'>
              <div class='media-body text-right'>
              <div class='date_time'>".Carbon::parse($today)->format('j M, Y, H:i')."</div>
              <p>".$postmessage."</p>
              </div>
              </li>";

        die;
    }


    public function userchat()
    {
        $userId = $_POST['userId'];
        $chatId = $_POST['chatId'];

        $userChat = Chat::where("_id",$chatId)->orderBy('chatDate', 'asc')->first()->toArray();


        
            if($userId != $userChat['sellerId']) {
                $chatuserId = $userChat['sellerId'];
                $userdetail = User::find($chatuserId);
                $chatdetail['id'] = $userdetail['_id'];
                $chatdetail['name'] = $userdetail['name'];
                $chatdetail['onlinestatus'] = $userdetail['online_status'];
                $chatdetail['lastActive'] = $userdetail['lastActive'];
                if(!empty($userdetail['image']) && isset($userdetail['image'])) {
                    $chatdetail['image'] = url('/storage/app/public/users/thumb100/'.$userdetail['image']);
                } else {
                    $chatdetail['image'] = url('/storage/app/public/users/thumb100/default.png');
                }
                $chatdetail['lastmessage'] = $userChat['lastMessage'];
            }
            if($userId != $userChat['userId']) {
                $chatuserId = $userChat['userId'];
                $userdetail = User::find($chatuserId);
                $chatdetail['id'] = $userdetail['_id'];
                $chatdetail['name'] = $userdetail['name'];
                $chatdetail['onlinestatus'] = $userdetail['online_status'];
                $chatdetail['lastActive'] = $userdetail['lastActive'];
                if(!empty($userdetail['image']) && isset($userdetail['image'])) {
                    $chatdetail['image'] = url('/storage/app/public/users/thumb100/'.$userdetail['image']);
                } else {
                    $chatdetail['image'] = url('/storage/app/public/users/thumb100/default.png');
                }
                $chatdetail['lastmessage'] = $userChat['lastMessage'];
            }
        

        $chatId = $userChat['_id'];

        $chatMesssages = Message::where("chatId",$chatId)->orderBy('createdAt', 'asc')->get()->toArray();


        //$userdetails = $myclass->get_userdetails($userdetail);

       // $userdetails = User::where('_id', $userdetail)->get()->toArray();


        //echo "<pre>"; print_r($chatdetail); die;
        
        return view('site.chat.userchat' , ['chatdetail' => $chatdetail , 'chatMesssages' => $chatMesssages , 'currentuserId' => $userId , 'chatId' => $chatId]);

    }


    public function searchchatuser()
    {

        $userId = $_POST['userId'];
        $searchtxt = $_POST['searchtxt'];

        $myClass = new MyClass();


        $userChats = Chat::where("userId",$userId)->orWhere("sellerId",$userId)->orderBy('chatDate', 'asc')->get()->toArray();

        $chatdetail = [];


        foreach($userChats as $key => $userChat) {
            if($userId != $userChat['sellerId']) {
                $chatuserId = $userChat['sellerId'];
                $userdetail = User::find($chatuserId);

                $usersearch = 0;

                if(empty($searchtxt)) {
                    $usersearch = 1;
                } else {

                    $found = $myClass->searchdata($userdetail['name'], $searchtxt);

                    if($found) {
                        $usersearch = 1;
                    }
                }

                if($usersearch == 1){
                    $chatdetail[$key]['chatid'] = $userChat['_id'];
                    $chatdetail[$key]['id'] = $userdetail['_id'];
                    $chatdetail[$key]['name'] = $userdetail['name'];
                    $chatdetail[$key]['onlinestatus'] = $userdetail['online_status'];
                    $chatdetail[$key]['lastActive'] = $userdetail['lastActive'];
                    if(!empty($userdetail['image']) && isset($userdetail['image'])) {
                        $chatdetail[$key]['image'] = url('/storage/app/public/users/thumb100/'.$userdetail['image']);
                    } else {
                        $chatdetail[$key]['image'] = url('/storage/app/public/users/thumb100/default.png');
                    }
                    $chatdetail[$key]['lastmessage'] = $userChat['lastMessage'];

                }
            }
            if($userId != $userChat['userId']) {
                $chatuserId = $userChat['userId'];
                $userdetail = User::find($chatuserId);

                $usersearch = 0;

                if(empty($searchtxt)) {
                    $usersearch = 1;
                } else {

                    $found = $myClass->searchdata($userdetail['name'], $searchtxt);

                    if($found) {
                        $usersearch = 1;
                    }
                }

                if($usersearch == 1){
                    $chatdetail[$key]['chatid'] = $userChat['_id'];
                    $chatdetail[$key]['id'] = $userdetail['_id'];
                    $chatdetail[$key]['name'] = $userdetail['name'];
                    $chatdetail[$key]['onlinestatus'] = $userdetail['online_status'];
                    $chatdetail[$key]['lastActive'] = $userdetail['lastActive'];
                    if(!empty($userdetail['image']) && isset($userdetail['image'])) {
                        $chatdetail[$key]['image'] = url('/storage/app/public/users/thumb100/'.$userdetail['image']);
                    } else {
                        $chatdetail[$key]['image'] = url('/storage/app/public/users/thumb100/default.png');
                    }
                    $chatdetail[$key]['lastmessage'] = $userChat['lastMessage'];

                }
            }
        }

        $chatId = $userChats[0]['_id'];

        
        return view('site.chat.searchchatuser' , ['chatdetail' => $chatdetail , 'currentuserId' => $userId , 'chatId' => $chatId]);

    }


    

    
}
