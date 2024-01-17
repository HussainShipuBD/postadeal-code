<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Address extends Eloquent
{
    
    protected $connection = 'mongodb';
    protected $collection = 'addresses';
    protected $fillable = [
        'userId',
        "phone",
        "name",
        'addressOne',
        "addressTwo",
        "country",
        "pincode",
        'addressDate',
    ];
    
}
