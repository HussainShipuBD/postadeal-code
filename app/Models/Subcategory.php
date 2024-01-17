<?php

namespace App\Models;
use App\Models\Category;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Subcategory extends Eloquent
{
	
	protected $connection = 'mongodb';
	protected $collection = 'subcategories';
	protected $fillable = [
		'name', "parentCategory"
	];
	
}
