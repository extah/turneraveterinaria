<?php

use Illuminate\Database\Seeder;
use App\Barrio;

class BarrioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $p = new Barrio();
        $p->barrio = 'ALTO DE LOS TALAS';
        $p->save();

        $p = new Barrio();
        $p->barrio = 'BANCO PROVINCIA';
        $p->save();

        $p = new Barrio();
        $p->barrio = 'BERISSO CENTRO';
        $p->save();

        $p = new Barrio();
        $p->barrio = 'CALLE NUEVA YORK';
        $p->save();

        $p = new Barrio();
        $p->barrio = 'EL CARMEN';
        $p->save();

        $p = new Barrio();
        $p->barrio = 'JUAN B. JUSTO';
        $p->save();

        $p = new Barrio();
        $p->barrio = 'LAS 14';
        $p->save();

        $p = new Barrio();
        $p->barrio = 'OBRERO';
        $p->save();

        $p = new Barrio();
        $p->barrio = 'SANTA CRUZ';
        $p->save();

        $p = new Barrio();
        $p->barrio = 'SANTA TERESITA';
        $p->save();

        $p = new Barrio();
        $p->barrio = 'SOLIDARIDAD';
        $p->save();

        $p = new Barrio();
        $p->barrio = 'TRABAJADORES DE LA CARNE';
        $p->save();

        $p = new Barrio();
        $p->barrio = 'UNIVERSITARIO';
        $p->save();
        
        $p = new Barrio();
        $p->barrio = 'VILLA ARGÚELLO';
        $p->save();
        
        $p = new Barrio();
        $p->barrio = 'VILLA DOLORES';
        $p->save();
        
        $p = new Barrio();
        $p->barrio = 'VILLA ESPAÑA';
        $p->save();
        
        $p = new Barrio();
        $p->barrio = 'Banco Provincia';
        $p->save();
        
        $p = new Barrio();
        $p->barrio = 'VILLA NUEVA';
        $p->save();
        
        $p = new Barrio();
        $p->barrio = 'VILLA PAULA';
        $p->save();
        
        $p = new Barrio();
        $p->barrio = 'VILLA PORTEÑA';
        $p->save();
        
        $p = new Barrio();
        $p->barrio = 'VILLA PROGRESO';
        $p->save();
                
        $p = new Barrio();
        $p->barrio = 'VILLA ROCA';
        $p->save();
                
        $p = new Barrio();
        $p->barrio = 'VILLA SAN CARLOS';
        $p->save();
                
        $p = new Barrio();
        $p->barrio = 'VILLA ZULA';
        $p->save();
                
        $p = new Barrio();
        $p->barrio = 'YPF';
        $p->save();
                
        $p = new Barrio();
        $p->barrio = 'ZONA RURAL';
        $p->save();
    }
}
