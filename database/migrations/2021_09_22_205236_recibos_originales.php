<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecibosOriginales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibos_originales', function (Blueprint $table) {
            $table->id();
            $table->string('apellido', 55)->nullable();
            $table->string('nombre', 55)->nullable();
            $table->bigInteger('legajo')->nullable();
            $table->date('fecha_ingreso', 0)->nullable();
            $table->date('fecha_reingreso', 0)->nullable();
            $table->string('tipo_documento', 5)->nullable();
            $table->bigInteger('numero_documento')->nullable();
            $table->string('dependencia', 255)->nullable();
            $table->smallInteger('antiguedad')->nullable();
            $table->smallInteger('categoria')->nullable();
            $table->string('carrera', 100)->nullable();
            $table->string('clase', 1)->nullable();
            $table->smallInteger('regimen_horario')->nullable();
            $table->bigInteger('cuil')->nullable();
            $table->string('planta', 100)->nullable();
            $table->string('dep', 100)->nullable();
            $table->smallInteger('mes')->nullable();
            $table->string('mes_nom', 50)->nullable();
            $table->bigInteger('anio')->nullable();
            $table->string('tipo', 1)->nullable();
            // $table->string('tipo_detalle', 35)->nullable();
            $table->double('total_haberes', 15, 2)->default(0)->nullable();
            $table->double('total_hasindto', 15, 2)->default(0)->nullable();
            $table->double('total_dto', 15, 2)->default(0)->nullable();
            $table->smallInteger('concepto')->nullable();
            $table->double('cantidad', 15, 2)->default(0)->nullable();
            $table->string('descripcion', 255)->nullable();
            $table->double('importe', 15, 2)->default(0)->nullable();

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
        //
    }
}
