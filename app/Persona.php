<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    //
    //metodos
    public static function get_registro_dni($dni)
    {
        // $i = Persona::where('dni', '=', $dni)->first();
        $row = Persona::where('dni', '=', $dni)->first();
        return $row;       
    }
}
