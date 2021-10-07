<?php

use Illuminate\Database\Seeder;
use App\Persona;

class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $p = new Persona();
        $p->nombre = 'Emmanuel';
        $p->apellido = 'Baleztena';
        $p->fecha_nacimiento = date('Y-m-d H:i:s', strtotime('1992-10-07 13:12:48'));
        $p->dni = 36738451;
        $p->telefono = 2355443082;
        $p->email = "extah23@gmail.com";
        $p->save();
    }
}
