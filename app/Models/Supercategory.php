<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Supercategory extends Eloquent
{
	
	protected $connection = 'mongodb';
	protected $collection = 'supercategories';
	protected $fillable = [
		'name', "parentCategory", "subCategory"
	];
	
}
