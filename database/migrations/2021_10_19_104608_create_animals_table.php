<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('especie', 255)->nullable();
            $table->string('nombre', 255)->nullable();
            $table->bigInteger('edad')->nullable();
            $table->string('sexo', 10)->nullable();
            $table->boolean('vacuna_antirrabica')->nullable();
            $table->boolean('vacuna_sextuple')->nullable();
            $table->boolean('castrado')->nullable();
            //brucelosis
            $table->boolean('cruzo_animal_hembra')->nullable();
            $table->boolean('preñada_animal_hembra')->nullable();
            $table->boolean('crias_animal_hembra')->nullable();
            $table->string('problema_parto_hembra', 255)->nullable();

            $table->boolean('cruzo_animal_macho')->nullable();
            $table->boolean('prenez_macho')->nullable();
            $table->boolean('inflamacion_macho')->nullable();

            $table->boolean('columna_animal_ambos')->nullable();

            $table->boolean('criadero_animal')->nullable();
            $table->boolean('viajo_animal')->nullable();

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
        Schema::dropIfExists('animals');
    }
}
