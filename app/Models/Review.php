<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Review extends Eloquent
{
    
    protected $connection = 'mongodb';
    protected $collection = 'reviews';
    protected $fillable = [
        'reviewDate', 
        'userId', 
        'sellerId',
        "itemId",
        "orderId",
        "rating",
        "message",
        "createdAt"
    ];
    
}
