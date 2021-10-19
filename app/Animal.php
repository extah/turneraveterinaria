<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use App\Persona;

class Animal extends Model
{
    //
    //metodos
    public static function get_registro_existe($dni, $nombre_animal)
    {
        // $i = Persona::where('dni', '=', $dni)->first();
        $row = Animal::where([
            ['dni', '=', $dni],
            ['nombre', '=', $nombre_animal],
         ]);
        return $row;       
    }
}
