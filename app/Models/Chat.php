<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Chat extends Eloquent
{
	
	protected $connection = 'mongodb';
	protected $collection = 'chats';
	protected $fillable = [
		'userId', 
		'itemId', 
		'sellerId',
		'chatBlockByUser',
		'chatBlockBySeller',
		'unread',
		'lastMessage',
		'lastMessageUser',
		'lastMessageOn',
		'chatClearByUser',
		'chatClearBySeller',
		'chatClearUpdatedUser',
		'chatClearUpdatedSeller',
		'chatDate'
	];
	
}
