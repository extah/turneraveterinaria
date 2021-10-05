<?php

namespace App\Http\Controllers\Especialidades;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests;

use Auth;
use DB;
use URL;
use Redirect; 


class EspecialidadesController extends Controller
{
    public function index(){
        
        $especialidades =  DB::select("SELECT especialidades.* FROM especialidades ORDER BY especialidades.id ASC");
        $medicos =  DB::select("SELECT medico.* FROM medico ORDER BY medico.id ASC");
        // dd($especialidades);
        $data = DB::select("SELECT turno_espec_medic.* FROM turno_espec_medic ORDER BY turno_espec_medic.id ASC");
        // return json_encode($data, JSON_UNESCAPED_UNICODE);
        // return datatables()->of($data)->toJson();
        // return view('especialidades.pruebaModel', compact('especialidades', 'medicos'));
    	return view('especialidades.especialidades', compact('especialidades', 'medicos'));
    
    }
    public function turnosasignadosdatatable(Request $request)
    {
        $opcion = $request->input("opcion");
        $id_especialidad = $request->input("select_especialidades");
        $id_medico = $request->input("select_medicos");
        switch($opcion){

            case 1:
                
                $data = DB::select("SELECT especialidades.nombre as especialidad, concat(medico.nombre, ' ', medico.apellido)  as nombre_medico, turno_espec_medic.dia_horario, turno_espec_medic.pami, turno_espec_medic.obra_social, turno_espec_medic.consulta_particular, turno_espec_medic.otros
                FROM turno_espec_medic  
                LEFT JOIN especialidades ON turno_espec_medic.id_especialidades = especialidades.id
                LEFT JOIN medico ON turno_espec_medic.id_medico = medico.id
                where id_especialidades = $id_especialidad ORDER BY turno_espec_medic.id ASC");

                break;    
            case 2: 

                $data = DB::select("SELECT turno_espec_medic.* FROM turno_espec_medic where id=0 ORDER BY turno_espec_medic.id ASC");

                break;
            case 3: 
                // $data = DB::select("SELECT turno_espec_medic.* FROM turno_espec_medic  where id_medico = $id_medico ORDER BY turno_espec_medic.id ASC");
                $data = DB::select("SELECT especialidades.nombre as especialidad, concat(medico.apellido, ' ', medico.nombre)  as nombre_medico, turno_espec_medic.dia_horario, turno_espec_medic.pami, turno_espec_medic.obra_social, turno_espec_medic.consulta_particular, turno_espec_medic.otros
                FROM turno_espec_medic  
                LEFT JOIN especialidades ON turno_espec_medic.id_especialidades = especialidades.id
                LEFT JOIN medico ON turno_espec_medic.id_medico = medico.id
                where id_medico = $id_medico ORDER BY turno_espec_medic.id ASC");
                break;
            case 4: 
                
                break;
            
        }

        return json_encode($data, JSON_UNESCAPED_UNICODE);

    }
}
