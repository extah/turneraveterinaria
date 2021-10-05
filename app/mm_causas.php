<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class mm_causas extends Model
{
    protected $table = 'mm_causas';
    protected $primaryKey = '';
    
    protected $fillable = ['doc_tipo', 'doc_nro', 'causas'];
    
    public $timestamps  = false;
    
    static public $insert_rules = ['id_turno' => 'required'];
    static public $edit_rules = ['id_turno' => 'required'];
    
    static public $campos_export = ['doc_tipo', 'doc_nro', 'causas'];
    
    //////////////metodos
    public static function get_registro($id)
    {
        $row = self::find($id);
        return $row;      
    }
    
}
