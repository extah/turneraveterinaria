<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turnos extends Model
{
    //
        //metodos
        public static function get_registro($id)
        {
            $row = self::find($id);
            return $row;       
        }
        
}
