<?php

use Illuminate\Database\Seeder;
use App\Turnos;

class TurnosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $p = new Turnos();
        $p->id_animal = '1';
        $p->id_persona = 1;
        $p->id_tipo_turno = 1;
        $p->id_barrio = 1;
        $p->fecha = date('Y-m-d', strtotime('2021-10-07'));
        $p->hora = ""; 
        $p->nro_turno = 1;
        $p->libre = false;
        $p->save();

        $p = new Turnos();
        $p->id_animal = '1';
        $p->id_persona = null;
        $p->id_tipo_turno = 1;
        $p->id_barrio = 1;
        $p->fecha = date('Y-m-d H:i:s', strtotime('2021-10-15'));
        $p->hora = "08:00"; 
        $p->nro_turno = 1;
        $p->libre = true;
        $p->save();

        $p = new Turnos();
        $p->id_animal = '1';
        $p->id_persona = null;
        $p->id_tipo_turno = 1;
        $p->id_barrio = 1;
        $p->fecha = date('Y-m-d H:i:s', strtotime('2021-10-15'));
        $p->hora = "09:00"; 
        $p->nro_turno = 2;
        $p->libre = true;
        $p->save();

        $p = new Turnos();
        $p->id_animal = '1';
        $p->id_persona = null;
        $p->id_tipo_turno = 1;
        $p->id_barrio = 1;
        $p->fecha = date('Y-m-d H:i:s', strtotime('2021-10-15'));
        $p->hora = "10:00"; 
        $p->nro_turno = 2;
        $p->libre = true;
        $p->save();

        $p = new Turnos();
        $p->id_animal = '1';
        $p->id_persona = null;
        $p->id_tipo_turno = 1;
        $p->id_barrio = 1;
        $p->fecha = date('Y-m-d H:i:s', strtotime('2021-10-15'));
        $p->hora = "11:00"; 
        $p->nro_turno = 2;
        $p->libre = true;
        $p->save();

        // $p = new Turnos();
        // $p->id_animal = '1';
        // // $p->id_persona = 1;
        // // $p->id_tipo_turno = 1;
        // $p->id_barrio = 2;
        // $p->fecha = date('Y-m-d H:i:s', strtotime('2021-10-07 13:12:48'));
        // $p->nro_turno = 1;
        // $p->libre = true;
        // $p->save();

        // $p = new Turnos();
        // $p->id_animal = '1';
        // // $p->id_persona = 2;
        // // $p->id_tipo_turno = 1;
        // $p->id_barrio = 2;
        // $p->fecha = date('Y-m-d H:i:s', strtotime('2021-10-07 13:12:48'));
        // $p->nro_turno = 1;
        // $p->libre = true;
        // $p->save();


    }
}
