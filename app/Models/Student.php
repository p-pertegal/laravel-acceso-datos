<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    	protected $fillable = [
		'nia',
		'dni',
		'name',
		'phone',
		'location',
		'email',
	];
}
