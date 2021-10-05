<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turno_espec_medic extends Model
{
    //
    protected $table = 'turno_espec_medic';
    protected $primaryKey = 'id';
    
    protected $fillable = ['id', 'id_especialidades', 'id_medico', 'dia_horario', 'pami', 'obra_social', 'consulta_particular', 'otros'];

    public $timestamps  = false;
}
