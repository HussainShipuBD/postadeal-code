<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Order extends Eloquent
{
    
    protected $connection = 'mongodb';
    protected $collection = 'orders';
    protected $fillable = [
        'userId',
        "sellerId",
        "itemId",
        'otp',
        "price",
        "shippingprice",
        "totalprice",
        "commissionprice",
        "currency",
        "currencyCode",
        'status',
        'pay_token',
        'orderDate',
        'deliveredDate',
    ];
    
}
