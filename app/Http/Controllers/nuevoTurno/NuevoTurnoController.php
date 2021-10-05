<?php

namespace App\Http\Controllers\nuevoTurno;
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

class NuevoTurnoController extends Controller
{

	public function index(Request $request){

	 
	    $inicio = "";    
	    $tarmites =  DB::select("SELECT tab_tramites.* FROM tab_tramites where desabilitar = 0 ORDER BY tab_tramites.tramite ASC");
		$status_error = false;
		$esEmp = false;
		// dd( $tarmites);
    	return view('nuevoTurno.nuevoturno', compact('inicio','tarmites', 'status_error', 'esEmp'));
    }

	public function fechasIndex(Request $request){
	    $inicio = "";  
		$esEmp = false;  

	    $id_tramite =  $request->select_tramite;
		$tramite =  DB::select("SELECT tab_tramites.* FROM tab_tramites where id_tramite = $id_tramite");
		$id_tramite_turno = $tramite[0]->id_tramite_turno;	
		$nombretramite = $tramite[0]->tramite;
		//dias que tienen turnos
		
		$fecha_actual = Carbon::now('America/Argentina/Buenos_Aires');
		$dateactual = $fecha_actual->format('Y/m/d');
		$datefinal = substr($dateactual, 0, 5);
		
		//$datefinal = $datefinal . "31";
		$anioActual = date("Y");
		$mesActual = date("n");
		$mesActual += 1;
		$datefinal = $datefinal . $mesActual . '/';
		$datefinal = $datefinal . cal_days_in_month(CAL_GREGORIAN, $mesActual, $anioActual);
		// dd($datefinal);

		// SELECT DISTINCT fecha FROM `mm_turnos` WHERE libre = 1 AND id_tramite_turno = 1 AND fecha BETWEEN '2021/06/01' AND '2021/06/30' ORDER BY id_turno ASC
		$diasDisponible =  DB::select("SELECT DISTINCT fecha FROM mm_turnos WHERE libre = 1 AND id_tramite_turno = " . $id_tramite_turno . " AND fecha BETWEEN '" . $dateactual . "' AND '" . $datefinal . "' ORDER BY fecha ASC");
		// dd($diasDisponible);
		
		if(count($diasDisponible) == 0)
		{
			
			$message = "Por el momento no hay turnos disponibles";
			$status_error = true;
			$inicio = "";    
			$tarmites =  DB::select("SELECT tab_tramites.* FROM tab_tramites where desabilitar = 0 ORDER BY tab_tramites.tramite ASC");
	
			return view('nuevoTurno.nuevoturno', compact('inicio', 'tarmites', 'message', 'status_error', 'esEmp'));
		}
		$fechasDisp = [];
		foreach ($diasDisponible as $key => $fecha) {
			// dd($fecha->fecha);
			$fechastr = strtotime($fecha->fecha);
			//Le das el formato que necesitas a la fecha
			$fecha = date('d/m/Y',$fechastr);
			array_push($fechasDisp,$fecha);
		}
		// dd($fechasDisp);

		$status_error = false;
		$esEmp = false;
    	return view('nuevoTurno.nuevoturno2', compact('inicio','nombretramite', 'id_tramite', 'fechasDisp', 'status_error', 'esEmp'));
    }

    public function indexprueba(Request $request){

	    $inicio = "";    
	    $tarmites =  DB::select("SELECT tab_tramites.* FROM tab_tramites where desabilitar = 0 ORDER BY tab_tramites.tramite ASC");

    	return view('nuevoTurno.prueba', compact('inicio','tarmites'));
    }

    public function formdatospersonales($id_tramite){

    	//$form_html = "<script src='https://www.google.com/recaptcha/api.js?onload=onloadCallback&hl=es-419&render=explicit' async defer> </script>";
		$form_html = "<script src='https://www.google.com/recaptcha/api.js?hl=es' async defer> </script>";
    	 
    	$form_html .= "<script src='js/gforms.js'> </script>";
    	
		$form_html .= "<form name='form' method='post' action=''>";
		
		$form_html .= "<input type='hidden' id='form_id_tramite' name='form_id_tramite'  class='form-control' value='".$id_tramite."'/>";

		$form_html .= "<div class='row form-group'>";
		$form_html .= "<h5><label class='control-label'>Completá tus datos</label></h5>";
		$form_html .= "	<div class='col-md-4'>  ";       
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label required' for='form_nombre'>Nombre*</label>";
		$form_html .= "			<input type='text' id='form_nombre' name='form_nombre' required='required' class='form-control' style='text-transform:uppercase' maxlength='50'/>";
		$form_html .= "		</div>";     
		$form_html .= "	</div>"; 
		$form_html .= "	<div class='col-md-4'>  ";       
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label required' for='form_apellido'>Apellido*</label>";
		$form_html .= "			<input type='text' id='form_apellido' name='form_apellido' required='required' class='form-control' style='text-transform:uppercase' maxlength='50'/>";
		$form_html .= "		</div>";     
		$form_html .= "	</div>";


		$form_html .= "	<div class='col-md-2'>      ";   
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label required' for='form_tipoDocumento'>Tipo Documento*</label>";
		$form_html .= "			<select id='form_tipoDocumento' name='form_tipoDocumento' required='required' class='form-control'>";
		$form_html .= "			<option value='' selected='selected'>Seleccioná</option>    ";        
		$form_html .= "			<option value='DE' >DE</option>";
		$form_html .= "			<option value='DNI' >DNI</option>";
		$form_html .= "			<option value='LC' >LC</option> ";
		$form_html .= "			<option value='LE' >LE</option>";
		$form_html .= "			</select>";
		$form_html .= "		</div>";
		$form_html .= "	</div>";  

		$form_html .= "	<div class='col-md-2'>";       
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label required' for='form_numeroDocumento'>Nro de Documento*</label>";
		$form_html .= "			<input type='number' id='form_numeroDocumento' name='form_numeroDocumento' required='required' minlength='5' class='form-control' />";
		$form_html .= "		</div>";     
		$form_html .= "	</div>";

		$form_html .= "</div>";

		$form_html .= "<div class='row form-group' style='margin-top:-20px'>";
	//	$form_html .= "<h4>Domicilio</h4>";
		$form_html .= "	<div class='col-md-4'>  ";       
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label required' for='form_calle'>Calle*</label>";
		$form_html .= "			<input type='text' id='form_dir_calle' name='form_dir_calle' required='required' class='form-control' style='text-transform:uppercase' maxlength='50'/>";
		$form_html .= "		</div>";     
		$form_html .= "	</div>"; 

		$form_html .= "	<div class='col-md-2'>  ";       
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label required' for='form_nro' maxlength='5'>Nro</label>";
		$form_html .= "			<input type='number' id='form_dir_nro' name='form_dir_nro' class='form-control' />";
		$form_html .= "		</div>";     
		$form_html .= "	</div>"; 

		$form_html .= "	<div class='col-md-1'>      ";   
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label' for='form_subnro'>Sub Nro.</label>";
		$form_html .= "			<select id='form_dir_subnro' name='form_dir_subnro' class='form-control'>";
		$form_html .= "			<option value='' selected='selected'></option>    ";        
		$form_html .= "			<option value='4' >1/2</option>";
		$form_html .= "			<option value='1' >S/N</option>";
		$form_html .= "			</select>";
		$form_html .= "		</div>";
		$form_html .= "	</div>";  

		$form_html .= "	<div class='col-md-1'>  ";       
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label' for='form_piso' maxlength='2'>Piso</label>";
		$form_html .= "			<input type='text' id='form_dir_piso' name='form_dir_piso' class='form-control' style='text-transform:uppercase' maxlength='2'/>";
		$form_html .= "		</div>";     
		$form_html .= "	</div>"; 

		$form_html .= "	<div class='col-md-1'>  ";       
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label' for='form_dpto' maxlength='5'>Dpto.</label>";
		$form_html .= "			<input type='text' id='form_dir_dpto' name='form_dir_dpto' class='form-control' style='text-transform:uppercase' maxlength='2'/>";
		$form_html .= "		</div>";     
		$form_html .= "	</div>";

		$form_html .= "	<div class='col-md-1'>  ";       
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label' for='form_mzna' maxlength='5'>Manzana</label>";
		$form_html .= "			<input type='text' id='form_dir_mzna' name='form_dir_mzna' class='form-control' style='text-transform:uppercase' maxlength='2'/>";
		$form_html .= "		</div>";     
		$form_html .= "	</div>";

		$form_html .= "</div>";

		$form_html .= "<div class='row form-group' style='margin-top:-20px'>";
		//$form_html .= "<h4>Comunicación</h4>";

		$form_html .= "	<div class='col-md-4'>  ";       
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label required' for='form_tel'>Telefono*</label>";
		$form_html .= "			<input type='number' id='form_tel' name='form_tel' required='required' class='form-control' onkeypress='return justNumbers(event);'/>";
		$form_html .= "		</div>";     
		$form_html .= "	</div>"; 

		$form_html .= "	<div class='col-md-4'>  ";       
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label required' for='form_mail'>Email*</label>";
		$form_html .= "			<input type='email' id='form_mail' name='form_mail' required='required' class='form-control' value='' />";
		$form_html .= "		</div>";     
		$form_html .= "	</div>"; 

		$form_html .= "</div>";

		//$form_html .= "<div class='g-recaptcha' data-sitekey='6LfpoScUAAAAAA2usCdAwayw_KQiHe44y5e1Whk-'></div>";
		//$form_html .= "<div id='errorRecaptcha' style='display:none; color:#a94442'>    <span class='glyphicon glyphicon-exclamation-sign'></span>    Por favor, clickeá en el recaptcha para poder reservar el turno.</div>";

		$form_html .= "<input type='hidden' id='form_idTurno' name='form_idTurno' />";
		$form_html .= "<input type='hidden' id='form__token' name='form__token' value='u4zqC17juppOQuKaBOinPesSyCt4GM0TUCDCcBgeRJ8' />";

		$form_html .= "</form>";

		$miArray = array("content"=>$form_html, "error"=>"0", "form_token"=>"6LfpoScUAAAAAA2usCdAwayw_KQiHe44y5e1Whk-");
		 
		return  ($miArray);

    }

    public function validarDatosPersonales(Request $request){

    	$error = "0";
    	//$causas = "";
    	if ($request->form_tipoDocumento != "" && $request->form_numeroDocumento != ""){
    		
    		//$mm_causas = mm_causas::where('doc_tipo', $request->form_tipoDocumento)->where('doc_nro', $request->form_numeroDocumento)->get();  
        	
        	//if($mm_causas->count() > 0){ 
/*
    		$opts = array(
		        'ssl' => array('ciphers'=>'RC4-SHA', 'verify_peer'=>false, 'verify_peer_name'=>false)
		    ); 
        	$params = array ('encoding' => 'UTF-8', 'verifypeer' => false, 'verifyhost' => false, 'soap_version' => SOAP_1_2, 'trace' => 1, 'exceptions' => 1, "connection_timeout" => 180, 'stream_context' => stream_context_create($opts) );
			$url_ = "http://10.240.52.28/ws_faltas/ws_causas.asmx?WSDL";
        	$causas_ws = new SoapClient($url_ , $params);

        	$tiene_causas=$causas_ws->tieneCausas(['pDocTipo' => $request->form_tipoDocumento,'pDocNro' => $request->form_numeroDocumento ])->tieneCausasResult;
        	
        	//return $tiene_causas; 

    	 	if ($tiene_causas != "N"){
        		$error = "99";
        		$form_html = $this->tiene_causas($request->form_tipoDocumento, $request->form_numeroDocumento, 1);
        		
        		$miArray = array("content"=>$form_html, "error"=>$error, "form_token"=>"6LfpoScUAAAAAA2usCdAwayw_KQiHe44y5e1Whk-" );
				return  ($miArray);
        		//$causas = $mm_causas[0]->causas;
        		
        	}*/

        	$mm_tieneturnos =DB::select("select mm_turno_det.id_comprobante, mm_turno_det.id_turno, mm_turnos.fecha, mm_turno_det.id_tramite 
			from mm_turno_det 
			INNER JOIN mm_turnos ON mm_turno_det.id_turno = mm_turnos.id_turno
			where mm_turno_det.tipo_doc = '".$request->form_tipoDocumento."' and mm_turno_det.nro_doc = ".$request->form_numeroDocumento." and mm_turno_det.fecha_cancela is null and fecha >= curdate() and mm_turno_det.id_tramite = ".$request->form_id_tramite);
         
        		
        	if($mm_tieneturnos){ 
        		$error = "98";
        		$form_html = $this->tiene_causas($request->form_tipoDocumento, $request->form_numeroDocumento, 0);
        		
        		$miArray = array("content"=>$form_html, "error"=>$error, "form_token"=>"6LfpoScUAAAAAA2usCdAwayw_KQiHe44y5e1Whk-" );
				return  ($miArray);
        	}


        }

    	
    	$mensaje = "<span class='help-block'>    <ul class='list-unstyled'><li><span class='glyphicon glyphicon-exclamation-sign'></span> Este campo es obligatorio.</li></ul></span>";
    	$mensajemail = "<span class='help-block'>    <ul class='list-unstyled'><li><span class='glyphicon glyphicon-exclamation-sign'></span> No es un mail valido.</li></ul></span>";


    	$form_html = "<script src='https://www.google.com/recaptcha/api.js?hl=es' async defer> </script>";
    	 
    	$form_html .= "<script src='js/gforms.js'> </script>";
    	
		$form_html .= "<form name='form' method='post' action=''>";
		$form_html .= "<input type='hidden' id='form_id_tramite' name='form_id_tramite'  class='form-control' value='".$request->form_id_tramite."'/>";
		$form_html .= "<div class='row form-group'>";
		$form_html .= "<h5><label class='control-label'>Completá tus datos</label></h5>";

		$form_html .= $this->cambia_class($request->form_nombre, 4);	
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label required' for='form_nombre'>Nombre*</label>";
		$form_html .= "			<input type='text' id='form_nombre' name='form_nombre' required='required' class='form-control' style='text-transform:uppercase' maxlength='50' value='".$request->form_nombre."' >";
		if($request->form_nombre ==""){
			$error = "1";
			$form_html .= $mensaje;
		}
		$form_html .= "		</div>";     
		$form_html .= "	</div>";


		$form_html .= $this->cambia_class($request->form_apellido, 4);
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label required' for='form_apellido'>Apellido*</label>";
		$form_html .= "			<input type='text' id='form_apellido' name='form_apellido' required='required' class='form-control' style='text-transform:uppercase' maxlength='50' value='".$request->form_apellido."'/>";
		if($request->form_apellido ==""){
			$error = "1";
			$form_html .= $mensaje;
		}
		$form_html .= "		</div>";     
		$form_html .= "	</div>";


		$form_html .= $this->cambia_class($request->form_tipoDocumento, 2);   
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label required' for='form_tipoDocumento'>Tipo Documento*</label>";
		$form_html .= "			<select id='form_tipoDocumento' name='form_tipoDocumento' required='required' class='form-control'>";
		$form_html .= "			<option value='' ". (($request->form_tipoDocumento =="") ? " selected='selected'" : "") .">Seleccioná</option>    ";        
		$form_html .= "			<option value='DE' ". (($request->form_tipoDocumento =="DE") ? " selected='selected'" : " ") .">DE</option>";
		$form_html .= "			<option value='DNI' ". (($request->form_tipoDocumento =="DNI") ? " selected='selected'" : " ") ." >DNI</option>";
		$form_html .= "			<option value='LC' ". (($request->form_tipoDocumento =="LC") ? " selected='selected'" : " ") .">LC</option> ";
		$form_html .= "			<option value='LE' ". (($request->form_tipoDocumento =="LE") ? " selected='selected'" : " ") .">LE</option>";
		$form_html .= "			</select>";
		if($request->form_tipoDocumento ==""){
			$error = "1";
			$form_html .= $mensaje;
		}
		$form_html .= "		</div>";
		$form_html .= "	</div>";  

		$form_html .= $this->cambia_class($request->form_numeroDocumento, 2, 7);          
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label required' for='form_numeroDocumento'>Nro de Documento*</label>";
		$form_html .= "			<input type='number' id='form_numeroDocumento' name='form_numeroDocumento' required='required' minlength='5' class='form-control' value='".$request->form_numeroDocumento."'/>";
		
		if($request->form_numeroDocumento =="" ){
			$error = "1";
			$form_html .= $mensaje;
		}
		$characterCount = strlen($request->form_numeroDocumento);
		if($characterCount < 7 && $request->form_numeroDocumento !=""){
			$error = "1";
			$mensajedoc = "<span class='help-block'>    <ul class='list-unstyled'><li><span class='glyphicon glyphicon-exclamation-sign'></span>El Número de Documento debe tener al menos 7 dígitos.</li></ul></span>";
			$form_html .= $mensajedoc;
		}
		$form_html .= "		</div>";     
		$form_html .= "	</div>";

		$form_html .= "</div>";

		$form_html .= "</br>";

		$form_html .= "<div class='row form-group' style='margin-top:-20px'>";
	//	$form_html .= "<h4>Domicilio</h4>";
		$form_html .= $this->cambia_class($request->form_dir_calle, 4);       
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label required' for='form_calle'>Calle*</label>";
		$form_html .= "			<input type='text' id='form_dir_calle' name='form_dir_calle' required='required' class='form-control' style='text-transform:uppercase' maxlength='50' value='".$request->form_dir_calle."'/>";
		if($request->form_dir_calle ==""){
			$error = "1";
			$form_html .= $mensaje;
		}
		$form_html .= "		</div>";     
		$form_html .= "	</div>"; 

		$form_html .= "	<div class='col-md-2'>  ";       
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label required' for='form_nro' maxlength='5'>Nro</label>";
		$form_html .= "			<input type='number' id='form_dir_nro' name='form_dir_nro' class='form-control' value='".$request->form_dir_nro."'/>";
		$form_html .= "		</div>";     
		$form_html .= "	</div>"; 

		$form_html .= "	<div class='col-md-1'>      ";   
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label' for='form_subnro'>Sub Nro.</label>";
		$form_html .= "			<select id='form_dir_subnro' name='form_dir_subnro' class='form-control'>";
		$form_html .= "			<option value='' selected='selected'></option>    ";        
		$form_html .= "			<option value='4' >1/2</option>";
		$form_html .= "			<option value='1' >S/N</option>";
		$form_html .= "			</select>";
		$form_html .= "		</div>";
		$form_html .= "	</div>";  

		$form_html .= "	<div class='col-md-1'>  ";       
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label' for='form_piso' maxlength='2'>Piso</label>";
		$form_html .= "			<input type='text' id='form_dir_piso' name='form_dir_piso' class='form-control' style='text-transform:uppercase' maxlength='2' value='".$request->form_dir_piso."'/>";
		$form_html .= "		</div>";     
		$form_html .= "	</div>"; 

		$form_html .= "	<div class='col-md-1'>  ";       
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label' for='form_dpto' maxlength='5'>Dpto.</label>";
		$form_html .= "			<input type='text' id='form_dir_dpto' maxlength='2' name='form_dir_dpto' class='form-control' style='text-transform:uppercase' value='".$request->form_dir_dpto."'/>";
		$form_html .= "		</div>";     
		$form_html .= "	</div>";

		$form_html .= "	<div class='col-md-1'>  ";       
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label' for='form_mzna' maxlength='5'>Manzana</label>";
		$form_html .= "			<input type='text' id='form_dir_mzna' name='form_dir_mzna' class='form-control' style='text-transform:uppercase' maxlength='2' value='".$request->form_dir_mzna."'/>";
		$form_html .= "		</div>";     
		$form_html .= "	</div>";

		$form_html .= "</div>";
		
		$form_html .= "</br>";

		$form_html .= "<div class='row form-group' style='margin-top:-20px'>";
		//$form_html .= "<h4>Comunicación</h4>";

		$form_html .= $this->cambia_class($request->form_tel, 4);     
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label required' for='form_tel'>Telefono*</label>";
		$form_html .= "			<input type='number' id='form_tel' name='form_tel' required='required' class='form-control' value='".$request->form_tel."' onkeypress='return justNumbers(event);'/>";
		if($request->form_tel ==""){
			$error = "1";
			$form_html .= $mensaje;
		}
		$form_html .= "		</div>";     
		$form_html .= "	</div>"; 

		$valmail = $this->validEmail($request->form_mail); 

		$form_html .= $this->cambia_class_mail($request->form_mail, 4, $valmail);      
		$form_html .= "		<div class='form-group'>";
		$form_html .= "			<label class='control-label required' for='form_mail'>Email*</label>";
		$form_html .= "			<input type='email' id='form_mail' name='form_mail' required='required' class='form-control' value='".$request->form_mail."'/>";
		if($request->form_mail ==""){
			$error = "1";
			$form_html .= $mensaje;
		}
		else
		{
			if(!$valmail){
				$error = "1";
				$form_html .= $mensajemail;
			}
		}
		
		$form_html .= "		</div>";     
		$form_html .= "	</div>"; 

		$form_html .= "</div>";

		//$form_html .= "<div class='g-recaptcha' data-sitekey='6LfpoScUAAAAAA2usCdAwayw_KQiHe44y5e1Whk-'></div>";
		//$form_html .= "<div id='errorRecaptcha' style='display:none; color:#a94442'>    <span class='glyphicon glyphicon-exclamation-sign'></span>    Por favor, clickeá en el recaptcha para poder reservar el turno.</div>";
		$form_html .= "<input type='hidden' id='form_idTurno' name='form_idTurno' />";
		$form_html .= "<input type='hidden' id='form__token' name='form__token' value='u4zqC17juppOQuKaBOinPesSyCt4GM0TUCDCcBgeRJ8' />";

		$form_html .= "</form>";
		
		/*$captcha ;
		
		 //https://codeforgeek.com/2014/12/google-recaptcha-tutorial/

		if(isset($_GET['g-recaptcha-response'])){
          $captcha=$_GET['g-recaptcha-response'];
          $entro = true;
        }  
	 	
		if(!$captcha){
		  $entro = false;
		  $error = "1";		
          $recaptchaValido = false;
        }
        else
        {
        	$entro = true;
        	$secretKey = "6LfpoScUAAAAADa8tFk83dKvRWSTbx91JWBd2q68";
        	$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha);
        	$responseKeys = json_decode($response,true);
	        if(intval($responseKeys["success"]) !== 1) {
	        	$error = "1";
	          $recaptchaValido =  false ;
	        } else {
	          $recaptchaValido =  true ;
	        }
        } */

		//$error = "1";
		//$recaptchaValido = false;
		//$miArray = array("content"=>$form_html, "error"=>$error, "recaptchaValido"=>$recaptchaValido, "form_token"=>"6LfpoScUAAAAAA2usCdAwayw_KQiHe44y5e1Whk-", "entro"=>$captcha );
        $miArray = array("content"=>$form_html, "error"=>$error, "form_token"=>"6LfpoScUAAAAAA2usCdAwayw_KQiHe44y5e1Whk-" );
		 
		return  ($miArray);

    }

    public function tiene_causas($tdoc, $ndoc, $causas){

    	
    	$div = '<div class="col-md-6 col-sm-6 col-xs-12">';
        $div .= '     <div class="x_panel">';
        $div .= '        <div class="x_title">';
        //$div .= '         <h2>Daily active users <small>Sessions</small></h2>';
        $div .= '          <ul class="nav navbar-right panel_toolbox">';
        $div .= '            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>';
        $div .= '            </li>';
        $div .= '            <li class="dropdown">';
        $div .= '              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>';
        $div .= '              <ul class="dropdown-menu" role="menu">';
        $div .= '                <li><a href="#">Settings 1</a>';
        $div .= '                </li>';
        $div .= '                <li><a href="#">Settings 2</a>';
        $div .= '                </li>';
        $div .= '              </ul>';
        $div .= '            </li>';
        $div .= '            <li><a class="close-link"><i class="fa fa-close"></i></a>';
        $div .= '            </li>';
        $div .= '          </ul>';
        $div .= '          <div class="clearfix"></div>';
        $div .= '        </div>';
        //$div .= '        <div class="x_content">';
        $div .= '		<div class="alert alert-danger" role="alert">';
		 
        $div .= '          <div class="bs-example" data-example-id="simple-jumbotron">';
        $div .= '            <div class="jumbotron">';
        $div .= '              <h1>Atención!!</h1>';
        if ($causas == 1){
        $div .= '              <p>El Documento '.$tdoc.' '.$ndoc.' posee causas pendientes, por favor acerquese al Juzgado de Faltas sito en calle 11 N° 4454. Tel: 0221 461-7362, Horario: 08:00 a 12:00Hs</p>';
        }
        else{
        $div .= '              <p>El Documento '.$tdoc.' '.$ndoc.' Ya posee un turno vigente, primero debe anularlo y volver a intentar</p>';
        }
        $div .= '            </div>';
        $div .= '          </div>';

        $div .= '        </div>';
        $div .= '      </div>';
        $div .= '    </div>';

        return $div;

    }

    public function cambia_class($val, $cols, $length = 0){
    	$characterCount = strlen($val);
    	if($val == "" || $characterCount < $length)
			{return "	<div class='col-md-".$cols." has-error'>  ";}
		else
			{return "	<div class='col-md-".$cols."'>  ";}
    }
    public function cambia_class_mail($val, $cols, $valmail){
    	if($val == "" || !$valmail)
			{return "	<div class='col-md-".$cols." has-error'>  ";}
		else
			{return "	<div class='col-md-".$cols."'>  ";}
    }
    public function cambia_classLength($val, $cols, $length){
    	$characterCount = strlen($val);
    	if($characterCount < $length)
			{return "	<div class='col-md-".$cols." has-error'>  ";}
		else
			{return "	<div class='col-md-".$cols."'>  ";}
    }

    function validEmail($email){
	    // First, we check that there's one @ symbol, and that the lengths are right
	    if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
	        // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
	        return false;
	    }
	    // Split it into sections to make life easier
	    $email_array = explode("@", $email);
	    $local_array = explode(".", $email_array[0]);
	    for ($i = 0; $i < sizeof($local_array); $i++) {
	        if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
	            return false;
	        }
	    }
	    if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
	        $domain_array = explode(".", $email_array[1]);
	        if (sizeof($domain_array) < 2) {
	            return false; // Not enough parts to domain
	        }
	        for ($i = 0; $i < sizeof($domain_array); $i++) {
	            if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
	                return false;
	            }
	        }
	    }

	    return true;
	}

	public function disponibles($id_tramite, $fecha){
 		

		date_default_timezone_set("America/Argentina/Buenos_Aires");
		$now=date_create(date("Y-m-d"));
		$date2=date_create($fecha);
		$diff=date_diff($now,$date2);
		$datediff = $diff->format("%a");
 		//solo muestra los turnos de aca a 3 dias 
		if ($datediff >= 0){
 

			$tipoTramite = DB::select("SELECT * FROM tab_tramites WHERE id_tramite = ".$id_tramite);
		//dd($id_tramite);
			$whereAmpliacion = "";
			if($fecha == date("Y-m-d")){
				//$whereAmpliacion = "and hora >'11:20'";
				$whereAmpliacion = "and hora >'".date("h:i")."'";
			}
			//$whereAmpliacion = "and hora >'".date("h:i")."'";
			
			$turnos =  DB::select("SELECT * FROM mm_turnos WHERE id_tramite_turno = ".$tipoTramite[0]->id_tramite_turno." and libre = 1 AND fecha = '".$fecha."' ".$whereAmpliacion);
			 
		}
		else{
			$turnos =  DB::select("SELECT * FROM mm_turnos WHERE id_turno = -12");
		}

		$content= compact('turnos'); 

		$error = "0";
		return compact('content','error');
	}
	
	//POST Emma
	public function turnosDisponibles(Request $request){
 		// dd($request);
		$id_tramite = $request->select_tramite;
		$fechaParam = $request->fecha_turno;
		//Le pasas el string
		// dd($fechaParam);
 		//Le das el formato que necesitas a la fecha  30/06/2021

		 $diaparam = substr($fechaParam, 0, 2);
		//  dd($diaparam);
		 $mesparam = substr($fechaParam, -7, 2);
		//  dd($mesparam);
		 $anioparam = substr($fechaParam, -4, 4);
		//  dd($anioparam);

		 $fecha = $anioparam . "/" . $mesparam . "/" . $diaparam;
		// dd($fecha);

		$fecha_actual = Carbon::now('America/Argentina/Buenos_Aires');
		$date = $fecha_actual->format('Y/m/d');
		$hora_actual =  $fecha_actual->format('H:i');

		$tipoTramite = DB::select("SELECT * FROM tab_tramites WHERE id_tramite = ".$id_tramite);

		// dd($tipoTramite);
		// echo($fecha . "  " . $date);

		$whereAmpliacion = "";

		if(strcmp($fecha,$date) == 0){

			$whereAmpliacion = "and hora >'" . $hora_actual."'";
			// dd($whereAmpliacion);
		}

		$turnos =  DB::select("SELECT * FROM mm_turnos WHERE id_tramite_turno = ".$tipoTramite[0]->id_tramite_turno." and libre = 1 AND fecha = '".$fecha."' ".$whereAmpliacion);
		// dd($turnos);

		$content= compact('turnos'); 

		$error = "0";

		if(count($turnos) == 0)
		{
			$message = "NO HAY TURNOS PARA LA FECHA: " . $fecha;
			$status_error = true;
			$inicio = "";    
			$tarmites =  DB::select("SELECT tab_tramites.* FROM tab_tramites where desabilitar = 0 ORDER BY tab_tramites.tramite ASC");
			
			$esEmp = false;
	
			return view('nuevoTurno.nuevoturno', compact('inicio', 'tarmites', 'message', 'status_error', 'esEmp'));
			
		}
		//AGREGADO DE ERROR
		// return compact('content');
		$esEmp = false;
		return view('nuevoTurno.turnos_disponibles', compact('turnos', 'esEmp', 'id_tramite'));

		// return compact('content','error');
	
	}
	//POST Emma
	public function turnoConfirmado(Request $request){
		$id_tramite = $request->id_tramite;
		$id_turno = $request->select_turno;
		// dd($request);
		$mm_turnos   = mm_turnos::get_registro($request->select_turno);
		// dd($mm_turnos);
		$comprobante = 0;
		$nro_documento = $request->nro_documento;
		$hora = $mm_turnos->hora;
		$fecha = $mm_turnos->fecha;

		$fecha_actual = Carbon::now('America/Argentina/Buenos_Aires');
		$date123 = $fecha_actual->format('Y-m-d H:i:s');

		if($mm_turnos->libre == 1){
			// dd($mm_turnos->libre);
			DB::beginTransaction();
			try{

				$mm_turnos->libre = 0;
				$mm_turnos->Fecha_mov = date("Y-m-d H:i:s"); 
				$mm_turnos->save();

				$mm_turno_det = new mm_turno_det;
				$mm_turno_det->id_turno = $mm_turnos->id_turno;
				$mm_turno_det->id_tramite = $id_tramite;
				$mm_turno_det->tipo_doc = $request->tipo_doc;
				$mm_turno_det->nro_doc = $request->nro_documento;
				$mm_turno_det->apellido = strtoupper($request->apellido) ;
				$mm_turno_det->nombre = strtoupper($request->nombre);
				$mm_turno_det->domicilio_calle = $request->calle; 
				$mm_turno_det->domicilio_nro = $request->numero; 
				$mm_turno_det->domicilio_subnro = ""; 
				$mm_turno_det->domicilio_piso = $request->piso; 
				$mm_turno_det->domicilio_dpto = strtoupper($request->depto); 
				$mm_turno_det->domicilio_mzna = ""; 
				$mm_turno_det->telefono = $request->telefono; 
				$mm_turno_det->email = $request->email; 
				$mm_turno_det->Fecha_mov = date("Y-m-d H:i:s"); 
				//$mm_turno_det->save();
				  
				if($mm_turno_det->save()) {
					$comprobante = $mm_turno_det->id_comprobante;
				}


				$precio = 0; //DB::select("SELECT * FROM tab_precios WHERE id_tramite = 1");	
				
				DB::commit();
				$error = "0";
				// $dato = app()->call('App\Http\Controllers\boleta\BoletaController@invoice', [$comprobante, $request->nro_documento]);
				// return ($dato);
				$message = "El turno se registro con ÉXITO";
				$status = true;
				$esEmp = false;
				return view('nuevoTurno.comprobanteTurno', compact('comprobante', 'nro_documento', 'status', 'message','hora','fecha', 'esEmp'));
			}

			catch (\Exception $e)
			{
				DB::rollBack();
				$error = "3";
				$descError = "Error al grabar ".$e;
				throw $e;
				$miArray = array("error"=>$error, "recaptchaValido"=>$recaptchaValido, "descError"=>$descError, "comprobante"=>$comprobante, "id_turno"=>$id_turno, "dni"=>$dni);

				//return ($miArray);
			}        
			
		}
		else{
			$message = "El turno se ha ocupado mientras ingresaba los datos, INTENTE NUEVAMENTE";
			$status_error = true;
			$inicio = "";    
			$tarmites =  DB::select("SELECT tab_tramites.* FROM tab_tramites where desabilitar = 0 ORDER BY tab_tramites.tramite ASC");
			$esEmp = false;

			return view('nuevoTurno.nuevoturno', compact('inicio', 'tarmites', 'message', 'status_error', 'esEmp'));
		}

		// $content= compact('mm_turnos');//tranformo a json

		// return $content;
	}

	public function fechaHasta($id_tramite){
		$tipoTramite = DB::select("SELECT * FROM tab_tramites WHERE id_tramite = ".$id_tramite);
		
		$fechas =  DB::select("SELECT CURDATE() as desde, IF(min(fecha) is null, CURDATE(), min(fecha)) as primer, IF(max(fecha) is null, CURDATE(), max(fecha))as hasta 
		FROM mm_turnos WHERE id_tramite_turno = ".$tipoTramite[0]->id_tramite_turno." and libre = 1 and fecha >= CURDATE()");	 	

		$error = "0";
		$esEmp = false;
		return compact('fechas','error', 'esEmp');
	}

	public function save_turno(Request $request){
		$comprobante = 0;
		$captcha ;
		$descError = "";
		$id_turno = 0;
		$dni = 0;
		$recaptchaValido =  true ;
		 //https://codeforgeek.com/2014/12/google-recaptcha-tutorial/
		$error = "0";	
		if(isset($_GET['g-recaptcha-response'])){
          $captcha=$_GET['g-recaptcha-response'];
          $entro = true;
        }  
	 	
		if(!$captcha){
		  $entro = false;
		  $error = "1";		
          $recaptchaValido = false;
          $descError = "Debe Resolver el captcha";
        }
        else
        {
        	$error = "0";
	        $recaptchaValido =  true ;
	        //por el error del celular lo deshabilito hata encontrar la solucion
        	/*$arrContextOptions=array(
			    "ssl"=>array(
			        "verify_peer"=>false,
			        "verify_peer_name"=>false,
			    ),
			);  
        	$entro = true;
        	$secretKey = "6LfpoScUAAAAADa8tFk83dKvRWSTbx91JWBd2q68";
        	$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha, false, stream_context_create($arrContextOptions));
        	$responseKeys = json_decode($response,true);
        	
        	if(intval($responseKeys["success"]) !== 1) {
	          $error = "1";
	          $recaptchaValido =  false ;
	          $descError = "Captcha Erroneo, verifique";
	        } else {
	          $error = "0";
	          $recaptchaValido =  true ;
	        }*/
        }

        if ($error == "0"){
        	$mm_turnos   = mm_turnos::get_registro($request->f_id_turno);
        	$id_turno = $mm_turnos->id_turno;
			$dni = $request->f_nro_doc;

        	if($mm_turnos)
        	{
        		if($mm_turnos->libre == 1){

        			DB::beginTransaction();
			        try{

			        	$mm_turnos->libre = 0;
			        	$mm_turnos->save();
						 
			        	$mm_turno_det = new mm_turno_det;
			        	$mm_turno_det->id_turno = $mm_turnos->id_turno;
			        	$mm_turno_det->id_tramite = $request->f_tramite;
						$mm_turno_det->tipo_doc = $request->f_tipo_doc;
						$mm_turno_det->nro_doc = $request->f_nro_doc;
						$mm_turno_det->apellido = strtoupper($request->f_apellido) ;
						$mm_turno_det->nombre = strtoupper($request->f_nombre);
						$mm_turno_det->domicilio_calle = $request->f_domicilio_calle; 
						$mm_turno_det->domicilio_nro = $request->f_domicilio_nro; 
						$mm_turno_det->domicilio_subnro = $request->f_domicilio_subnro; 
						$mm_turno_det->domicilio_piso = $request->f_domicilio_piso; 
						$mm_turno_det->domicilio_dpto = $request->s_domicilio_dpto; 
						$mm_turno_det->domicilio_mzna = $request->f_domicilio_mzna; 
						$mm_turno_det->telefono = $request->f_telefono; 
						$mm_turno_det->email = $request->f_email; 
						$mm_turno_det->Fecha_mov = date("Y-m-d H:i:s"); 
						//$mm_turno_det->save();
 						 
						if($mm_turno_det->save()) {
			                $comprobante = $mm_turno_det->id_comprobante;
			            }


						$precio = 0; //DB::select("SELECT * FROM tab_precios WHERE id_tramite = 1");	
			            
						DB::commit();
						$error = "0";
		                $descError = 'nuevoTurno/boletapdf/'.$comprobante.'/'.$request->f_nro_doc;
		                
		                $miArray = array("error"=>$error, "recaptchaValido"=>$recaptchaValido, "descError"=>$descError, "comprobante"=>$comprobante, "id_turno"=>$id_turno, "dni"=>$dni);
		 
						return ($miArray);
		            }

			        catch (\Exception $e)
			        {
			            DB::rollBack();
			            $error = "3";
			            $descError = "Error al grabar ".$e;
			            throw $e;
			            $miArray = array("error"=>$error, "recaptchaValido"=>$recaptchaValido, "descError"=>$descError, "comprobante"=>$comprobante, "id_turno"=>$id_turno, "dni"=>$dni);
 	
						//return ($miArray);
			        }        
        			
        		}
        		else{
        			$error = "2";
        			$descError = "El Turno se ha ocupado mientras ingresaba los datos, reintente";
        		}
        	}
        	else{
        		$error = "2";
        		$descError = "Turno Invalido";
        	}

        }
       /* else {
        	$error = "2";
    		$descError = "Turno no encontrado";
        }*/
        if ($comprobante != 0){
        	$error = "0";
            $descError = 'nuevoTurno/boletapdf/'.$comprobante.'/'.$request->f_nro_doc;
        }

        $miArray = array("error"=>$error, "recaptchaValido"=>$recaptchaValido, "descError"=>$descError, "comprobante"=>$comprobante, "id_turno"=>$id_turno, "dni"=>$dni);
		 
		return ($miArray);


	}


}