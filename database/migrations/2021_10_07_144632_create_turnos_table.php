<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turnos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_animal')->nullable();
            $table->foreignId('id_persona')->nullable();
            $table->foreignId('id_tipo_turno')->nullable();
            $table->foreignId('id_barrio')->nullable();
            $table->date('fecha', 0)->nullable();
            $table->string('hora', 255)->nullable();
            $table->bigInteger('nro_turno')->nullable();
            $table->boolean('libre')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turnos');
    }
}
