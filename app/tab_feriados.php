<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class tab_feriados extends Model
{
    protected $table = 'tab_feriados';
    protected $primaryKey = 'fecha';

    protected $fillable = ['fecha', 'feriado'];
    
    public $timestamps  = false;

    public static function get_registro($fecha)
    {
        $row = self::find($fecha);
        return $row;       
    }
}