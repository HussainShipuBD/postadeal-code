<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Setting extends Eloquent
{
    
    protected $connection = 'mongodb';
    protected $collection = 'settings';
    protected $fillable = [
        'siteName', 
        'siteDesc', 
        'siteIcon',
        "siteLogo",
        "siteDarkLogo",
        "contactEmail",
        "copyrightText",
        "pushNotification",
    // email module
        "port",
        "host",
        "email",
        "status",
        "password",
        "enableSmtp",
        'facebookURL', 
        'twitterURL',
        'linkedinURL', 
        'playstoreLink',
        'appstoreLink',  
        'promotioncurrencycode',  
        'promotioncurrencysymbol',  
        'promotioncurrencyname',  
        'stripeType',
        'publickey',
        'privatekey',
        'notificationkey'
    ];
    
}
