<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Help extends Eloquent
{
	
	protected $connection = 'mongodb';
	protected $collection = 'helps';
	protected $fillable = [
		'title', "description"
	];
	
}
