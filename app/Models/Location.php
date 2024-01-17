<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Location extends Eloquent
{
	
	protected $connection = 'mongodb';
	protected $collection = 'locations';
	protected $fillable = [
		'name'
	];
	
}
