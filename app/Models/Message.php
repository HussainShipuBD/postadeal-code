<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Message extends Eloquent
{
	
	protected $connection = 'mongodb';
	protected $collection = 'messages';
	protected $dates = ['createdAt'];
	protected $fillable = [
		'chatId', 
		'type', 
		'userId',
		'message',
		'attachment',
		'initial_message',
	];
	
}
