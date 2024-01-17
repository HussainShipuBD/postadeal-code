<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Commission extends Eloquent
{
	
	protected $connection = 'mongodb';
	protected $collection = 'commissions';
	protected $fillable = [
		'percentage', 'minrange', 'maxrange'
	];
	
}
