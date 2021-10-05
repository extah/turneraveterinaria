<?php

namespace App\Http\Controllers\administrador;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use Auth;
use DB;
use URL;
use Redirect; 

use App\mm_turnos;
use App\mm_turno_det;
use App\mm_liquidaciones;
use App\mm_causas;

use SoapClient;

use Carbon\Carbon;
use App\Libraries\invoice_listador;
use App\tab_feriados;

class AdministradorController extends Controller
{
    public function index(Request $request){

        $usuario = $request->session()->get('usuario');
        $result = $this->isUsuario($usuario);

        if($result == "OK")
        {
            $inicio ="";
            $status_ok = false;
            $esEmp = true;
            $message = "";
            return view('administrador.turnosadminmenu', compact('inicio', 'message', 'status_ok', 'esEmp', 'usuario'));

        }
	    $inicio = "";    
		$status_error = false;
        $esEmp = false;
    	return view('administrador.turnosadmininiciarsesion', compact('inicio','status_error', 'esEmp'));
    }
    
    public function cerrarsesion(Request $request)
    {
        $usuario = $request->session()->get('usuario');
        $result = $this->isUsuario($usuario);
        // dd();
        if($result == "OK")
        {
            $request->session()->flush();

        }
        $inicio = "";    
        // $status_error = false;
        $esEmp = false;
        // return view('administrador.turnosadmininiciarsesion', compact('inicio','status_error', 'esEmp'));
        // return view('inicio.inicio', compact('inicio', 'esEmp'));
        return redirect('inicio');

    }
    public function iniciarsesion(Request $request)
    {
        $inicio = "";
        $usuario = $request->usuario;
        $contrasena = $request->contrasena;

        $login =  DB::select("SELECT * FROM users where email = '" . $usuario . "'");
        
        if(count($login) == 0)
		{
            
			$message = "usuario/contraseña ";
			$status_error = true;
            $esEmp = false;
			
			return view('administrador.turnosadmininiciarsesion', compact('inicio', 'message', 'status_error', 'esEmp'));
		}
        else{
            
            $contrasenasql = $login[0]->password;
            if(password_verify($contrasena, $contrasenasql))
            {
                $message = "Bienvenido/a ";
                $status_ok = true;
                $esEmp = true;
                $request->session()->flush();
                session(['usuario'=>$usuario, 'nombre'=>$login[0]->name]);
                return view('administrador.turnosadminmenu', compact('inicio', 'message', 'status_ok', 'esEmp', 'usuario'));
            }
            else
            {
                $message = "usuario/contraseña ";
                $status_error = true;
                $esEmp = false;
                
                return view('administrador.turnosadmininiciarsesion', compact('inicio', 'message', 'status_error', 'esEmp'));
            }
        }
    }
    //get menu
    public function iniciarsesionget(Request $request)
    {
        $usuario = $request->session()->get('usuario');
        $result = $this->isUsuario($usuario);
        if($result == "OK")
        {
           


            $message = "Bienvenido/a ";
            $status_ok = true;
            $esEmp = true;
            $inicio ="";
            $usuario = $request->session()->get('usuario');

            return view('administrador.turnosadminmenu', compact('inicio', 'message', 'status_ok', 'esEmp', 'usuario'));
        }
        else
        {
            $inicio = "";    
            $status_error = false;
            $esEmp = false;
            return view('administrador.turnosadmininiciarsesion', compact('inicio','status_error', 'esEmp'));
        }
    }

    public function turnosasignados(Request $request)
    {

        $usuario = $request->session()->get('usuario');
        $result = $this->isUsuario($usuario);
        if($result == "OK")
        {
           
            $esEmp = true;
            $usuario = $request->session()->get('usuario');
            return view('administrador.turnosadminverturnos', compact('esEmp', 'usuario'));
        }
        $inicio = ""; 
        $status_error = false;
        $esEmp = false;
        return view('administrador.turnosadmininiciarsesion', compact('inicio','status_error', 'esEmp'));

    }

    public function turnosasignadosdatatable(Request $request)
    {
        $usuario = $request->session()->get('usuario');
        $result = $this->isUsuario($usuario);

        if($result == "OK")
        {
            // $opcion = $request->input("opcion");
            
 
                    // var_dump(" caso 1 "); 
                    $fecha_desde_param = $request->input("fecha_desde");
                    $fecha_hasta_param = $request->input("fecha_hasta");
                    
                    $diaparam = substr($fecha_desde_param, 0, 2);
                    $mesparam = substr($fecha_desde_param, -7, 2);
                    $anioparam = substr($fecha_desde_param, -4, 4);
                    $fecha_desde = $anioparam . "/" . $mesparam . "/" . $diaparam;
           
                    $diaparamdesde = substr($fecha_hasta_param, 0, 2);
                     $mesparamdesde = substr($fecha_hasta_param, -7, 2);
                     $anioparamdesde = substr($fecha_hasta_param, -4, 4);
                     $fecha_hasta = $anioparamdesde . "/" . $mesparamdesde . "/" . $diaparamdesde;
        
                    $where = " mm_turnos.fecha BETWEEN '" . $fecha_desde . "' AND '" . $fecha_hasta . "'";
        
                    $where .= " and fecha_cancela is null ";
        
                    $limit = " LIMIT 500";        
                    $orderby = " ORDER BY mm_turnos.fecha DESC, mm_turnos.hora ASC ";
        
                    $data = DB::select(DB::raw("SELECT DATE_FORMAT(mm_turnos.fecha, '%d/%m/%Y') as fecha, mm_turnos.hora, mm_turnos.Nro_turno as Nro, IF(mm_turnos.libre != 1 ,'NO', 'SI') as libre, concat(mm_turno_det.apellido, ' ', mm_turno_det.nombre) as Apyn, concat(mm_turno_det.tipo_doc,' ', mm_turno_det.nro_doc) as doc, mm_turno_det.telefono, if(tab_tramites.tramite is null,rr_tramite_turno.descripcion,tab_tramites.tramite ) as tram, mm_turno_det.email
                    FROM mm_turnos
                    LEFT JOIN mm_turno_det ON mm_turnos.id_turno = mm_turno_det.id_turno
                    LEFT JOIN rr_tramite_turno ON mm_turnos.id_tramite_turno = rr_tramite_turno.id_tramite_turno
                    LEFT JOIN tab_tramites ON mm_turno_det.id_tramite = tab_tramites.id_tramite          
                        WHERE ".$where."
                        ".$orderby." ".$limit));
                    // var_dump("caso 2 ");
                    // $data = datatables()->of($data)->toJson();
                    return json_encode($data, JSON_UNESCAPED_UNICODE);
            

        }
        else
        {
            $inicio = ""; 
            $status_error = false;
            $esEmp = false;
            // dd( $tarmites);
            return view('administrador.turnosadmininiciarsesion', compact('inicio','status_error', 'esEmp'));
        }
    }

    public function generarturnos(Request $request)
    {
        if($request->session()->get('usuario') == null)
        {
           
            $inicio = "";    
            $status_error = false;
            $esEmp = false;
            $status = false;
            // dd( $tarmites);
            return view('administrador.turnosadmininiciarsesion', compact('inicio','status_error', 'status', 'esEmp'));
        }

        $esEmp = true;
        $usuario = $request->session()->get('usuario');
        $status_error = false;
        $status = false;
        return view('administrador.generarturnos', compact('esEmp', 'usuario','status_error', 'status'));
    }
    public function generarturnospost(Request $request)
    {
        $fecha_desde = $request->fecha_desde;
        $fecha_hasta = $request->fecha_hasta;
        $tipo_turno = substr($request->tipo_turno, 0, 1);
        
        $hora_desde = $request->hora_desde;
        $hora_hasta = $request->hora_hasta;
        $lapzo_tiempo = $request->lapzo_tiempo;

        $esEmp = true;
        $usuario = $request->session()->get('usuario');       
        $resultusuario = $this->isUsuario($usuario);

        if($resultusuario == "OK")
        {
            $result = $this->genera_calendario($fecha_desde, $fecha_hasta, $tipo_turno,$hora_desde, $hora_hasta, $lapzo_tiempo);
            if($result == "OK")
            {
                $status = true;
                $status_error = false;
                
                return view('administrador.generarturnos', compact("status", "status_error", 'esEmp', 'usuario'));

            }else{

                $tipo_turno_nombre = substr($request->tipo_turno, strpos($request->tipo_turno,'-')+strlen('-'));
                if($fecha_desde == $fecha_hasta)
                {
                    $result = " con fecha : " . $fecha_desde;
                }
                else{
                    $result = " entre las fechas " . $fecha_desde . ' y ' . $fecha_hasta;
                }
                $message = "Existe turnos para el tipo : " . $tipo_turno_nombre . $result;
                
                $status = false;
                $status_error = true;
                
                return view('administrador.generarturnos', compact('message', "status", "status_error", 'esEmp', 'usuario'));
            }

        }else
        {


            
        }
        # code...
        return "";
    }



    function genera_calendario($fecha_desde_param, $fecha_hasta_param, $tipo_turno_param,$hora_desde_param, $hora_hasta_param, $lapzo_tiempo_param){

        //consulto si ya existe la grilla
        $diaparam = substr($fecha_desde_param, 0, 2);
		 $mesparam = substr($fecha_desde_param, -7, 2);
		 $anioparam = substr($fecha_desde_param, -4, 4);
		 $fecha_desde = $anioparam . "/" . $mesparam . "/" . $diaparam;

         $diaparamdesde = substr($fecha_hasta_param, 0, 2);
          $mesparamdesde = substr($fecha_hasta_param, -7, 2);
          $anioparamdesde = substr($fecha_hasta_param, -4, 4);
          $fecha_hasta = $anioparamdesde . "/" . $mesparamdesde . "/" . $diaparamdesde;
        // dd($fecha_desde . ' y '. $fecha_hasta);

        $existe = DB::select("SELECT * FROM `mm_turnos` WHERE fecha BETWEEN ' $fecha_desde' AND '$fecha_hasta' AND id_tramite_turno=$tipo_turno_param");
        // dd(count($existe) . "   ". $tipo_turno_param);
        if(count($existe) != 0 )
        {
            // DD(count($existe) != 0);
            return "ERROR";
        }
        
        //dd($fecha);
		$feriados =  DB::select("SELECT * FROM tab_feriados WHERE fecha BETWEEN ' $fecha_desde' AND '$fecha_hasta'");
        // dd($feriados);
		$Hora = $hora_desde_param;
		$mes_hasta = date("m",strtotime($fecha_hasta));
        $dia_desde = date("d",strtotime($fecha_desde));
        $dia_hasta = date("d",strtotime($fecha_hasta));

        // dd($dia_desde . '   ,  ' . $dia_hasta);
        // dd($mes_hasta);


		$fecha = $fecha_desde;
        $mes = date("m",strtotime($fecha));
        $ok = true;
        $dia_actual = date("d",strtotime($fecha));
        // dd($fecha . "  " . $mes .   "   "  .  $dia_actual);
		while (($mes <= $mes_hasta) && ($ok))
		{	
           
            if($mes == $mes_hasta)
            {
                if($dia_actual == $dia_hasta)
                {
                    $ok = false;
                }

            }
			if(!$this->isWeekend($fecha)){
                
				$es_feriado = array_values(array_filter($feriados, function($obj) use ($fecha)
				{
				    return $obj->fecha == $fecha;
				}));

		        if (sizeof($es_feriado) == 0){
		        	//echo $fecha, PHP_EOL; 
		        	$Hora = $hora_desde_param;
					// for ($i=1; $i < $cant + 1; $i++) { 

                        // if($Hora <= "13:30")
                        $i=1;

                        while($Hora <= $hora_hasta_param)
                        {
                            DB::insert("insert into mm_turnos 
							(id_tramite_turno,fecha,hora,Nro_turno,libre,Fecha_mov)
							values(".$tipo_turno_param.",'".$fecha."','".$Hora."',".$i.",1,NOW())"); 
                            
                            $Hora = date("H:i", strtotime($Hora)+($lapzo_tiempo_param*60));
                            $i++;
						    // echo $Hora, PHP_EOL;
                        }	
					// }
				}
			}

			$fecha = date('Y-m-d', strtotime($fecha. ' + 1 days'));
            
			$mes = date("m",strtotime($fecha));
            $dia_actual = date("d",strtotime($fecha));
			//echo $mes, PHP_EOL; 
        }
        // dd("termino");
     return "OK";    
    }    
    
    function isWeekend($date) {
	    $weekDay = date('w', strtotime($date));
	    return ($weekDay == 0 || $weekDay == 6);
	}	


    public function generarferiados(Request $request)
    {
        $esEmp = true;
        $usuario = $request->session()->get('usuario');
        $message = "";
        $status = false;
        $status_error = false;

        return view('administrador.generarferiados', compact('message', "status", "status_error", 'esEmp', 'usuario'));
    }

    public function feriadosdatatable(Request $request)
    {
        # code...
        $usuario = $request->session()->get('usuario');
        $result = $this->isUsuario($usuario);


        if($result == "OK"){

            $limit = " LIMIT 500";        
            $orderby = " ORDER BY tab_feriados.fecha DESC ";

            $data = DB::select(DB::raw("SELECT DATE_FORMAT(tab_feriados.fecha, '%d/%m/%Y') as fecha, tab_feriados.feriado as descripcion
            FROM tab_feriados        
                ".$orderby." ".$limit));


            return datatables()->of($data)->toJson();
        }
    }
    function isUsuario($usuario)
    {
        # code...
        if($usuario == null)
        {
            $inicio = ""; 
            $status_error = false;
            $esEmp = false;

            return view('administrador.turnosadmininiciarsesion', compact('inicio','status_error', 'esEmp'));
        }
 
        return "OK";

    }


public function feriadoseliminareditar(Request $request)
{
            # code...
            $usuario = $request->session()->get('usuario');
            $result = $this->isUsuario($usuario);
           
                
            if($result == "OK"){
                $opcion = $request->input("opcion");
            

                $fecha = $request->input("fecha");
                switch($opcion){

                    case 1:
                    
                                
                        $feriadosexiste = tab_feriados::where('fecha', '=',  $fecha)->get();
            
                        if ($feriadosexiste->count() != 0){
                            
                            $esEmp = true;
                            $usuario = $request->session()->get('usuario');
                            $message = "El feriado ya existe";
                            $status = false;
                            $status_error = true;
                            
                            return Redirect::to('administrador.generarferiados');           
                        }
                
                        $feriados   = new tab_feriados;
                
                        $feriados->fecha= $fecha;   
                        $feriados->feriado=$request->input("descripcion");        
                        $feriados->save(); 

                        $limit = " LIMIT 500";        
                        $orderby = " ORDER BY tab_feriados.fecha DESC ";
            
                        $data = DB::select(DB::raw("SELECT id_feriado, tab_feriados.fecha as fecha, tab_feriados.feriado as descripcion
                        FROM tab_feriados        
                            ".$orderby));
                        break;    
                    case 2: 
                        $feriado = $request->input("descripcion");
                        $id_feriado = $request->input("id_feriado");
                        // return $id_feriado;

                        DB::table('tab_feriados')->where('id_feriado',$id_feriado)->update(['feriado' => $feriado, 'fecha' => $fecha]);

                                    $limit = " LIMIT 500";        
                        $orderby = " ORDER BY tab_feriados.fecha DESC ";

                        $data = DB::select(DB::raw("SELECT id_feriado, tab_feriados.fecha as fecha, tab_feriados.feriado as descripcion
                        FROM tab_feriados        
                            ".$orderby));


                        break;
                    case 3: 
                        //borro
                        $feriado = tab_feriados::get_registro($fecha);
                        $feriado->delete($fecha);   
                        $limit = " LIMIT 500";        
                        $orderby = " ORDER BY tab_feriados.fecha DESC ";
            
                        $data = DB::select(DB::raw("SELECT DATE_FORMAT(tab_feriados.fecha, '%Y/%m/%d') as fecha, tab_feriados.feriado as descripcion
                        FROM tab_feriados        
                            ".$orderby));
                    
                        break;
                    case 4: 
                        $limit = " LIMIT 500";        
                        $orderby = " ORDER BY tab_feriados.fecha DESC ";
            
                        $data = DB::select(DB::raw("SELECT id_feriado, DATE_FORMAT(tab_feriados.fecha, '%Y/%m/%d') as fecha, tab_feriados.feriado as descripcion
                        FROM tab_feriados        
                            ".$orderby));
                        break;
                    
                }

                return json_encode($data, JSON_UNESCAPED_UNICODE);

            }else
            {
                $inicio = "";    
                $status_error = false;
                $esEmp = false;
                return view('administrador.turnosadmininiciarsesion', compact('inicio','status_error', 'esEmp'));
            }
            // print json_encode($data, JSON_UNESCAPED_UNICODE);//envio el array final el formato json a AJAX
            //  return datatables()->of($data)->toJson();



               
}








// public function feriadoseditar(Request $request)
// {

//     $usuario = $request->session()->get('usuario');
//     $result = $this->isUsuario($usuario);

//     $usuario = $request->session()->get('usuario');
//     $result = $this->isUsuario($usuario);

//     if($result == "OK"){
//         $fecha_desde_param = $request->input("fecha");
    
//         $diaparam = substr($fecha_desde_param, 0, 2);
//         $mesparam = substr($fecha_desde_param, -7, 2);
//         $anioparam = substr($fecha_desde_param, -4, 4);
//         $fecha = $anioparam . "/" . $mesparam . "/" . $diaparam;       
        
//         $feriados   = new tab_feriados;
    
//         $feriados->fecha= $fecha;   
//         $feriados->feriado=$request->feriado;          
//         $feriados->save();    
        
//         $data = DB::select(DB::raw("SELECT DATE_FORMAT(tab_feriados.fecha, '%d/%m/%Y') as fecha, tab_feriados.feriado as descripcion
//         FROM tab_feriados        
//             ".$orderby." ".$limit));
//         print json_encode($data, JSON_UNESCAPED_UNICODE);//envio el array final el formato json a AJAX
//     }

// }



    // function listado(Request $request) {
        
    //     $fecha_actual = Carbon::now('America/Argentina/Buenos_Aires');
    //     $dateactual = $fecha_actual->format('Y/m/d');
    //     $datefinal = substr($dateactual, 0, 8);
    //     $datefinal = $datefinal . "31";

    //     $where = " mm_turnos.fecha BETWEEN '" . $dateactual . "' AND '" . $datefinal . "'";

    //     $where .= " and fecha_cancela is null ";

    //     $limit = " LIMIT 500";        
    //     $orderby = " ORDER BY mm_turnos.fecha DESC, mm_turnos.hora ASC ";

    //     $data = DB::select(DB::raw("SELECT DATE_FORMAT(mm_turnos.fecha, '%d/%m/%Y') as fecha, mm_turnos.hora, mm_turnos.Nro_turno as Nro, IF(mm_turnos.libre != 1 ,'NO', 'SI') as libre, concat(mm_turno_det.apellido, ' ', mm_turno_det.nombre) as Apyn, concat(mm_turno_det.tipo_doc,' ', mm_turno_det.nro_doc) as doc, mm_turno_det.telefono, if(tab_tramites.tramite is null,rr_tramite_turno.descripcion,tab_tramites.tramite ) as tram, mm_turno_det.email
    //     FROM mm_turnos
    //     LEFT JOIN mm_turno_det ON mm_turnos.id_turno = mm_turno_det.id_turno
    //     LEFT JOIN rr_tramite_turno ON mm_turnos.id_tramite_turno = rr_tramite_turno.id_tramite_turno
    //     LEFT JOIN tab_tramites ON mm_turno_det.id_tramite = tab_tramites.id_tramite          
    //         WHERE ".$where."
    //         ".$orderby." ".$limit));

    //     $pdf=new invoice_listador();
    //     $pdf->AddPage('P');
    //     $pdf->SetAutoPageBreak(false);
    //     $config = [];        
    //     $i=0;
    //     $config[0] = ['visible' =>'S','titulo' =>'Fecha', 'alingtitu' => 'L', 'wide' => 15, 'aling' => 'R','tipo' => 'C'];
    //     $config[1] = ['visible' =>'S','titulo' =>'Hora', 'alingtitu' => 'L','wide' => 10, 'aling' => 'L','tipo' => 'C'];
    //     $config[2] = ['visible' =>'S','titulo' =>'Nro', 'alingtitu' => 'R', 'wide' => 5, 'aling' => 'R','tipo' => 'C'];
    //     $config[3] = ['visible' =>'S','titulo' =>'Apellido y Nombre', 'alingtitu' => 'L','wide' => 80, 'aling' => 'L','tipo' => 'C'];
    //     $config[4] = ['visible' =>'S','titulo' =>'Documento', 'alingtitu' => 'L','wide' => 25, 'aling' => 'L','tipo' => 'C'];
    //     $config[5] = ['visible' =>'S','titulo' =>'Teléfono', 'alingtitu' => 'L','wide' => 30, 'aling' => 'L','tipo' => 'C'];
    //     $config[6] = ['visible' =>'S','titulo' =>'Trámite', 'alingtitu' => 'L','wide' => 40, 'aling' => 'L','tipo' => 'C'];
        
    //     $titulo= "TURNOS DEL DIA ".$fecha_actual;
    //     $pdf->listador($titulo, $config, $data, '', '', '','L');        
    //     $pdf->Output();        
    //     exit;        



    // }
}
