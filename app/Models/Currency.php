<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Currency extends Eloquent
{
    
    protected $connection = 'mongodb';
    protected $collection = 'currencies';
    protected $fillable = [
        'currencycode',
        "currencysymbol",
        "currencyname"
    ];
    
}
