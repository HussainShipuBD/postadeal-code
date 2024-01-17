<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Product extends Eloquent
{

    
    protected $connection = 'mongodb';
    protected $collection = 'products';

   const CREATED_AT = 'createdAt';
   const UPDATED_AT = 'updatedAt';

    protected $fillable = [
        'itemTitle',
        "itemDesc",
        "itemType",
        'userId',
        "images",
        "price",
        "shippingprice",
        'mainCategory',
        "subCategory",
        "superCategory",
        'CurrencyID',
        "locationID",
        "productCondition",
        'status',
        "featured",
        "reportCount",
        "itemType",
        "location",
        "buynow",
        "featureDuration",
        "productAvailability",
        "loc",
        "latitude",
        "longitude",
        "locationName",
        "postingDate",
        "reportDate",
        "featureDuration",
        "featureactiveOn",
        "featureexpireOn"
    ];
    
}
