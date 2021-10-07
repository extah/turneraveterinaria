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
        $p->nombreyApellido = 'Emmanuel Baleztena';
        $p->cuit = 2036738451;
        $p->dni = 36738451;
        $p->contrasena = '$2y$10$UKXqQl3sS8O08fIj8Bx9A.fOYFIFizW7X2s2ndRjDgLF1ITtRl0FK';
        $p->save();
    }
}
