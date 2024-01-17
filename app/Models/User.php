<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Maklad\Permission\Traits\HasRoles;

class User extends Eloquent implements Authenticatable, AuthorizableContract
{
    use AuthenticableTrait, Authorizable;
  
    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $fillable = [
        'userId',
        "name",
        "email",
        'password',
        "mobile",
        "image",
        'status',
        'emailVerification',
        'stripeSecretKey',
        'stripePublicKey',
        'fbVerification',
        'rating',
        'reviews',
        'chatNotification',
        'emailNotification',
        'pushNotification',
        'chatCount',
        'notificationCount',
        'online_status',
        'provider',
        'provider_id',
        'access_token'
    ];
    
}
