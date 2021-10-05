<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(DependenciaSeeder::class);
        // $this->call(LugarPagoSeeder::class);
        // $this->call(TipoPiezaSeeder::class);
        // $this->call(AccionSeeder::class);
        // $this->call(RolSeeder::class);
        // $this->call(InternoSeeder::class);
        // $this->call(CampaniaSeeder::class);
        // $this->call(PiezaSeeder::class);
        //  $this->call(EspecialidadesSeeder::class);
        //  $this->call(MedicoSeeder::class);
         $this->call(UsersSeeder::class);
         $this->call(ReciboSeeder::class);
        //  $this->call(Turno_espec_medicSeeder::class);
    }
}
