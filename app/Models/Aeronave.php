<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aeronave extends Model
{
    	// Introducimos los atributos que se pueden introducir en masa
	// en nuestro caso serán todos los campos
	protected $fillable = [
		'nombre',
		'fabricante',
		'anyoFabricacion',
	];
}
