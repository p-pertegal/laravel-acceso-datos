<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
	// Tabla de fabricantes
	Schema::create('fabricantes', function(Blueprint $table) {
		$table->id();
		$table->string('nombre');
		$table->string('pais');
		$table->timestamps();
	});

	// Tabla de aeronaves
        Schema::create('aeronaves', function (Blueprint $table) {
            	$table->id();
		$table->string('nombre');
		$table->unsignedBigInteger('fabricante'); // FK
		$table->year('anyoFabricacion');
        $table->timestamps();

		// Restricciones
		$table->foreign('fabricante')->references('id')->on('fabricantes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aeronaves');
        Schema::dropIfExists('fabricantes');
    }
};
