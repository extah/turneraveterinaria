<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class mm_liquidaciones extends Model
{
    protected $table = 'mm_liquidaciones';
    protected $primaryKey = 'nconprobante';
    
    protected $fillable = ['nconprobante', 'id_turno', 'tasa', 'tipo_doc', 'nro_doc', 'apellido', 'nombre', 'origen', 'importe', 'fecha_vto', 'fecha_emision', 'hora_emision', 'estado'];
    
    public $timestamps  = false;
    
    static public $insert_rules = ['id_turno' => 'required'];
    static public $edit_rules = ['id_turno' => 'required'];
    
    static public $campos_export = ['nconprobante', 'id_turno', 'tasa', 'tipo_doc', 'nro_doc', 'apellido', 'nombre', 'origen', 'importe', 'fecha_vto', 'fecha_emision', 'hora_emision', 'estado'];
    
    //////////////metodos
    public static function get_registro($id)
    {
        $row = self::find($id);
        return $row;       
    }
    
}
