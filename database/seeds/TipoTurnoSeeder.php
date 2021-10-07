<?php

use Illuminate\Database\Seeder;
use App\Tipo_turno;
class TipoTurnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $p = new Tipo_turno();
        $p->tipo = 1;
        $p->descripcion = 'atencion primaria';

        $p->save();
    }
}
