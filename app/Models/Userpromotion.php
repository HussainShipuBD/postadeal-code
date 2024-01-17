<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Userpromotion extends Eloquent
{
    
    protected $connection = 'mongodb';
    protected $collection = 'userpromotions';
    protected $fillable = [
        'userId',
        "itemId",
        "promotionId",
        'currencySymbol',
        "currencyCode",
        "activeOn",
        'expireOn',
    ];
    
}
