<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class mm_turno_det extends Model
{
    protected $table = 'mm_turno_det';
    protected $primaryKey = 'id_comprobante';
    
    protected $fillable = ['id_comprobante', 'id_turno', 'tipo_doc', 'nro_doc', 'apellido', 'nombre', 'domicilio_calle', 'domicilio_nro', 'domicilio_subnro', 'domicilio_piso', 'domicilio_dpto', 'domicilio_mzna', 'telefono', 'email', 'Fecha_mov', 'fecha_cancela'];
    
    public $timestamps  = false;
    
    static public $insert_rules = ['id_comprobante' => 'required'];
    static public $edit_rules = ['id_comprobante' => 'required'];
    
    static public $campos_export = ['id_comprobante', 'id_turno', 'tipo_doc', 'nro_doc', 'apellido', 'nombre', 'domicilio_calle', 'domicilio_nro', 'domicilio_subnro', 'domicilio_piso', 'domicilio_dpto', 'domicilio_mzna', 'telefono', 'email', 'Fecha_mov', 'fecha_cancela'];
    
    //////////////metodos
    public static function get_registro($id)
    {
        $row = self::find($id);
        return $row;       
    }
    
}
