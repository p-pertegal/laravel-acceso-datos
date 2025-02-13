<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fabricante extends Model
{
    	// Campos en masa de fabricante
	protected $fillable = [
		'nombre',
		'pais',
	];
}
