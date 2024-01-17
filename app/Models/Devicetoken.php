<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Devicetoken extends Eloquent
{
    
    protected $connection = 'mongodb';
    protected $collection = 'devicetokens';
    protected $fillable = [
        'userId',
        "deviceId",
        "deviceToken",
        'buildType',
        "platform",
        "langCode",
        "deviceOS",
        "deviceModel".
        "deviceName".
        "lastActive"
    ];


    
}
