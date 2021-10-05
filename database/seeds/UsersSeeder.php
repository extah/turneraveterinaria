<?php

use Illuminate\Database\Seeder;
use App\Users;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $p = new Users();
        $p->nombreyApellido = 'JUAN CARLOS LITWIN';
        $p->cuit = 20106012742;
        $p->dni = 10601274;
        $p->contrasena = '$2y$10$UKXqQl3sS8O08fIj8Bx9A.fOYFIFizW7X2s2ndRjDgLF1ITtRl0FK';
        $p->save();

        $p = new Users();
        $p->nombreyApellido = 'GLADYS NOEMI TOLOZA';
        $p->cuit = 27125825104;
        $p->dni = 12582510;
        $p->contrasena = '$2y$10$UKXqQl3sS8O08fIj8Bx9A.fOYFIFizW7X2s2ndRjDgLF1ITtRl0FK';
        $p->save();

        $p = new Users();
        $p->nombreyApellido = 'SANDRA ELENA TEZZELI';
        $p->cuit = 23204150184;
        $p->dni = 20415018;
        $p->contrasena = '$2y$10$UKXqQl3sS8O08fIj8Bx9A.fOYFIFizW7X2s2ndRjDgLF1ITtRl0FK';
        $p->save();

        $p = new Users();
        $p->nombreyApellido = 'CLAUDIA EDITH NUCCELLI';
        $p->cuit = 27215989459;
        $p->dni = 21598945;
        $p->contrasena = '$2y$10$UKXqQl3sS8O08fIj8Bx9A.fOYFIFizW7X2s2ndRjDgLF1ITtRl0FK';
        $p->save();

        $p = new Users();
        $p->nombreyApellido = 'NOEMI LILIANA BASALDUA';
        $p->cuit = 27217366882;
        $p->dni = 21736688;
        $p->contrasena = '$2y$10$UKXqQl3sS8O08fIj8Bx9A.fOYFIFizW7X2s2ndRjDgLF1ITtRl0FK';
        $p->save();
        
        $p = new Users();
        $p->nombreyApellido = 'MAXIMILIANO EDUARDO SERVIN';
        $p->cuit = 20225984299;
        $p->dni = 22598429;
        $p->contrasena = '$2y$10$UKXqQl3sS8O08fIj8Bx9A.fOYFIFizW7X2s2ndRjDgLF1ITtRl0FK';
        $p->save();
        
        $p = new Users();
        $p->nombreyApellido = 'GUILLERMO RUBEN GARCIA';
        $p->cuit = 20278211828;
        $p->dni = 27821182;
        $p->contrasena = '$2y$10$UKXqQl3sS8O08fIj8Bx9A.fOYFIFizW7X2s2ndRjDgLF1ITtRl0FK';
        $p->save();
        
        $p = new Users();
        $p->nombreyApellido = 'HORACIO ALFREDO POMI';
        $p->cuit = 20083866056;
        $p->dni = 8386605;
        $p->contrasena = '$2y$10$UKXqQl3sS8O08fIj8Bx9A.fOYFIFizW7X2s2ndRjDgLF1ITtRl0FK';
        $p->save();
                
        $p = new Users();
        $p->nombreyApellido = 'ADRIAN ALEJANDRO FERREYRO';
        $p->cuit = 20169784303;
        $p->dni = 16978430;
        $p->contrasena = '$2y$10$UKXqQl3sS8O08fIj8Bx9A.fOYFIFizW7X2s2ndRjDgLF1ITtRl0FK';
        $p->save();
                
        $p = new Users();
        $p->nombreyApellido = 'SILVINA NOEMI CHANTRERO';
        $p->cuit = 27238066625;
        $p->dni = 23806662;
        $p->contrasena = '$2y$10$UKXqQl3sS8O08fIj8Bx9A.fOYFIFizW7X2s2ndRjDgLF1ITtRl0FK';
        $p->save();
                
        $p = new Users();
        $p->nombreyApellido = 'JORGE DANIEL JURADO';
        $p->cuit = 20214330483;
        $p->dni = 21433048;
        $p->contrasena = '$2y$10$UKXqQl3sS8O08fIj8Bx9A.fOYFIFizW7X2s2ndRjDgLF1ITtRl0FK';
        $p->save();
    }
}
