<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Banner extends Eloquent
{
	
	protected $connection = 'mongodb';
	protected $collection = 'banners';
	protected $fillable = [
		'name', "url", "image", "status"
	];
	
}
