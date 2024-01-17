<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Like extends Eloquent
{
    
    protected $connection = 'mongodb';
    protected $collection = 'likes';
    protected $fillable = [
        'userId',
        "itemId"
    ];
    
}
