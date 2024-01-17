<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Log extends Eloquent
{
    
    protected $connection = 'mongodb';
    protected $collection = 'logs';
    protected $dates = ['createdAt'];
    protected $fillable = [
        'senderId',
        "receiverId",
        "messageTxt",
        'messageType',
        "sourceId",
        "isAdmin",
        "chatId",
        "createdAt"
    ];


    
}
