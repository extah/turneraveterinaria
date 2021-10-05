<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class mm_turnos extends Model
{
    protected $table = 'mm_turnos';
    protected $primaryKey = 'id_turno';
    
    protected $fillable = ['id_turno', 'id_tramite_turno', 'fecha', 'hora', 'Nro_turno', 'libre', 'Fecha_mov'];
    
    public $timestamps  = false;
    
    static public $insert_rules = ['fecha' => 'required'];
    static public $edit_rules = ['fecha' => 'required'];
    
    static public $campos_export = ['id_turno', 'id_tramite_turno', 'fecha', 'hora', 'Nro_turno', 'libre', 'Fecha_mov']; 
    
    //////////////metodos
    public static function get_registro($id)
    {
        $row = self::find($id);
        return $row;       
    }
    
}
