<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Productcondition extends Eloquent
{
	
	protected $connection = 'mongodb';
	protected $collection = 'productconditions';
	protected $fillable = [
		'name'
	];
	
}
