<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Promotion extends Eloquent
{
	
	protected $connection = 'mongodb';
	protected $collection = 'promotions';
	protected $fillable = [
		'name', 'duration', 'price'
	];
	
}
