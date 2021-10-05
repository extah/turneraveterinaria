<?php

namespace App\Http\Controllers\anulaturno;
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

use Carbon\Carbon;

class AnulaTurnoController extends Controller
{
	// public function emma()
	// {
	// 	// return "llega";
	// 	$nro_documento = 36738451;
	// 	$nombre = "Emmanuel";
	// 	$apellido = "Baleztena";
	// 	$fecha = "2021/04/13";
	// 	$hora = "17:48";


	// 	return view('anular.cancelarTurnoOk', compact('nro_documento', 'nombre', 'apellido', 'fecha', 'hora'));
	// }
	public function index()
	{
		$status_error = false;
		$message = ""; 
		$esEmp = false;

		return view('anular.cancelarTurno', compact('status_error', 'message' ,'esEmp'));
	}

	public function buscar_turno_cancelar(Request $request)
	{
		$tipo_doc=$request->tipo_doc;
		$nro_documento=$request->nro_documento;
		$comprobante=$request->nro_comprobante;


		$turno =  DB::select("select mm_turno_det.id_comprobante, mm_turno_det.id_turno, mm_turnos.fecha , mm_turno_det.tipo_doc, mm_turno_det.nro_doc, CONCAT(mm_turno_det.apellido,' ', mm_turno_det.nombre) as Apyn, mm_turno_det.fecha_cancela , tab_tramites.tramite, CONCAT(DATE_FORMAT(mm_turnos.fecha,'%d/%m/%Y'),' ', mm_turnos.hora,' Hs') as turno, mm_turnos.Nro_turno, mm_turnos.hora as hora
		from mm_turno_det 
		INNER JOIN mm_turnos ON mm_turno_det.id_turno = mm_turnos.id_turno
		INNER JOIN tab_tramites ON mm_turno_det.id_tramite = tab_tramites.id_tramite  
		 WHERE mm_turno_det.id_comprobante = ".$comprobante." AND mm_turno_det.tipo_doc = '".$tipo_doc."' AND mm_turno_det.nro_doc = ".$nro_documento);

		if(count($turno) == 0){
			$status_error = true;
			$message = "El turno no existe"; 

			return view('anular.cancelarTurno', compact('status_error', 'message'));
		}
		else{
			$apeynombre =  $turno[0]->Apyn;

			$fecha_actual = Carbon::now('America/Argentina/Buenos_Aires');
			$date = $fecha_actual->format('Y-m-d');
			$hora = $turno[0]->hora;
			$hora_actual =  $fecha_actual->format('H:i');
			if($turno[0]->fecha <= $date){
				if($hora <= $hora_actual)
				{
				   $status_error = true;
				   $message =  "El turno ya pasó, no puede anularse";
				   $esEmp = false;
				   return view('anular.cancelarTurno', compact('status_error', 'message' , 'esEmp'));
				}
				
			}
		}

		DB::beginTransaction();
		try{

			//DB::select(DB::raw('delete from mm_turno_det  where id_turno = '.$turno[0]->id_turno));
			DB::insert('insert into mm_turno_det_copy (SELECT id_comprobante, id_turno, id_tramite, tipo_doc, nro_doc, apellido, nombre, domicilio_calle, domicilio_nro, domicilio_subnro, domicilio_piso, domicilio_dpto, domicilio_mzna, telefono, email, Fecha_mov, NOW() as fecha_cancela FROM mm_turno_det where id_turno = '.$turno[0]->id_turno.')');

			DB::insert('delete from mm_turno_det  where id_turno = '.$turno[0]->id_turno);

			$mm_turnos   = mm_turnos::get_registro($turno[0]->id_turno);
			$mm_turnos->libre = 1;
			$mm_turnos->save();

			DB::commit();
			$rta ='ok';
			// return $nro_doc;
			$esEmp = false;
	
			return view('anular.cancelarTurnoOk', compact('nro_documento', 'apeynombre', 'date', 'hora' , 'esEmp'));

		}
        catch (\Exception $e)
        {
            DB::rollBack();            
            $rta ='error al anular el turno'.$e;
            throw $e;          
        }    
		return false;
	}

	public function cancela_turno(){

		$form_html = "<script src='https://www.google.com/recaptcha/api.js?hl=es' async defer> </script>";
    	 
    	$form_html .= "<script src='js/gforms.js'> </script>";
    	
		$form_html .= "<form name='form' method='post' action=''>";

		$form_html.= "<div class='row form-group'>";
		$form_html.= "    <div class='col-md-2'>";
		$form_html.= "        <div class='form-group'><label class='control-label' for='form_tipoDocumento'>Tipo Documento*</label>";
		$form_html.= "        <select id='form_tipoDocumento' name='form_tipoDocumento' class='form-control'>";
		$form_html.= "        <option value=''>Seleccioná</option>            <option value='DE' >DE</option>";
		$form_html.= "        <option value='DNI' >DNI</option>            <option value='LC' >LC</option>";
		$form_html.= "        <option value='LE' >LE</option>";
		$form_html.= "        </select>";
		$form_html.= "        </div>";
		$form_html.= "    </div>";
		$form_html.= "    <div class='col-md-2'>";
		$form_html.= "        <div class='form-group'><label class='control-label' for='form_numeroDocumento'>Nº de Documento*</label><input type='number' id='form_numeroDocumento' name='form_numeroDocumento' class='form-control' /></div>";
		$form_html.= "    </div>";
		$form_html.= "    <div class='col-md-2'>";
		$form_html.= "        <div class='form-group'><label class='control-label' for='form_numeroTramite'>Nº de Trámite*</label><input type='text' id='form_numeroTramite' name='form_numeroTramite' class='form-control' /></div>";
		$form_html.= "    </div>";
		$form_html.= "</div>";
		$form_html.= "";
		$form_html.= "<div class='row form-group'>";
		$form_html.= "    <div class='col-md-4'>";
		$form_html.= "        <div class='g-recaptcha' data-sitekey='6LfpoScUAAAAAA2usCdAwayw_KQiHe44y5e1Whk-'></div>";
		$form_html.= "        </div>";
		$form_html.= "</div>";
		$form_html.= "";
		$form_html.= " ";
		$form_html.= "";
		$form_html.= "<div class='row form-group'>";
		$form_html.= "    <div class='col-md-2'>";
		$form_html.= "        <button type='button' class='btn btn-success' onclick='buscar()'>Buscar</button>";
		$form_html.= "        <div id='gif_cargando' class='gif_cargando' style='display: none'><img src='../css/css_imgs/cargando.gif'></div>";
		$form_html.= "    </div>";
		$form_html.= "</div>";
		$form_html.= "";
		$form_html.= "<input type='hidden' name='_token' value='".csrf_token()."'>";


		$form_html .= "</form>";

		$mensajeerror = "";

		return view('anular.cancelaturno',compact('mensajeerror','form_html'));

	}

	public function buscar_turno(Request $request){
		//return $request;
		$mensaje = "<span class='help-block'>    <ul class='list-unstyled'><li><span class='glyphicon glyphicon-exclamation-sign'></span> Este campo es obligatorio.</li></ul></span>"; 
		$mensajeerror = "";
		$captcha = "";
		$descError = "";
		$id_turno = 0;
		$comprobante = $request->form_numeroTramite;
		$tipodoc = $request->form_tipoDocumento;
		$nrodoc = $request->form_numeroDocumento;
		$deshabilitar = "";
		//val_cancela' value='ok'
		if($request->val_cancela == 'ok'){
		//	return $request;
          $rta = $this->cancela_turno_save($request->id_turno, $request->id_tipodoc, $request->id_nrodoc, $request->id_comprobante);
          
          if ($rta != 'ok'){
				$mensajeerror = "<div class='alert alert-danger'>    <ul class='list-unstyled'><li><span class=
				glyphicon glyphicon-exclamation-sign'></span> ".$rta."</li></ul>
	    		</div>";
	    	}
	    	else{
	    		$mensajeerror = "<div class='alert alert-success'>    <ul class='list-unstyled'><li><span class=
				glyphicon glyphicon-ok'></span>El turno se anuló con éxito.</li></ul>
	    		</div>";
	    	}	

	    	$form_html= "<div class='row form-group'>";
			$form_html.= "    <div class='col-md-2'>";
		
			$form_html.= "        <button type='button' class='btn btn-success' onclick='volver()'>Volver</button>"; 
	
			$form_html.= "    </div>";
			$form_html.= "</div>";
          	return view('anular.cancelaturno',compact('mensajeerror','form_html'));

        } 

		 //https://codeforgeek.com/2014/12/google-recaptcha-tutorial/
		$error = "0";	
		if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
          $entro = true;
        }  
	 	//return $captcha;
		if($captcha == ""){
		  $entro = false;
		  $error = "1";		
          $recaptchaValido = false;
          $descError = "Debe Resolver el captcha";
        }
        else
        {
        	$arrContextOptions=array(
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
	          $descError = "Captcha Erroneo";
	        } else {
	          $recaptchaValido =  true ;
	        }
        }

        if ($descError == "" & ($comprobante!="" & $tipodoc !="" & $nrodoc!="")){
        	 $turno =  DB::select("select mm_turno_det.id_comprobante, mm_turno_det.id_turno, mm_turnos.fecha , mm_turno_det.tipo_doc, mm_turno_det.nro_doc, CONCAT(mm_turno_det.apellido,' ', mm_turno_det.nombre) as Apyn, mm_turno_det.fecha_cancela , tab_tramites.tramite, CONCAT(DATE_FORMAT(mm_turnos.fecha,'%d/%m/%Y'),' ', mm_turnos.hora,' Hs') as turno, mm_turnos.Nro_turno
				from mm_turno_det 
				INNER JOIN mm_turnos ON mm_turno_det.id_turno = mm_turnos.id_turno
				INNER JOIN tab_tramites ON mm_turno_det.id_tramite = tab_tramites.id_tramite  
        	 	WHERE mm_turno_det.id_comprobante = ".$comprobante." AND mm_turno_det.tipo_doc = '".$tipodoc."' AND mm_turno_det.nro_doc = ".$nrodoc);
        	 // return $turno;
    	 	if (!$turno){
    	 		$error = "1";
    	 		$descError = "No se encontró ningun trámite con los datos que ingresaste en el sistema. Por favor, revisá que los datos ingresados sean correctos.";
    	 	}
    	 	else{
    	 		if ($turno[0]->fecha_cancela != null){
        	 		$error = "1";
        	 		$descError = "El turno ya se encuentra anulado ";
    	 		}
    	 		else{
    	 			$deshabilitar = " disabled='true' ";
    	 		}
    	 	}
        }
        else{
        	$descError = "Faltan ingresar Datos";
        }


		$form_html = "<script src='https://www.google.com/recaptcha/api.js?hl=es' async defer> </script>";
    	 
    	$form_html .= "<script src='js/gforms.js'> </script>";
    	
		$form_html .= "<form name='form' method='post' action=''>";


		$form_html.= "<div class='row form-group'>";
		 
		$form_html .= $this->cambia_class($request->form_tipoDocumento, 2);
		$form_html.= "        <div class='form-group'><label class='control-label' for='form_tipoDocumento'>Tipo Documento*</label>";
		$form_html .= "			<select id='form_tipoDocumento' name='form_tipoDocumento' required='required' class='form-control' ".$deshabilitar.">";
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
		$form_html.= "        </div>";
		$form_html.= "    </div>";
		 
		$form_html .= $this->cambia_class($request->form_numeroDocumento, 2);
		$form_html.= "        <div class='form-group'><label class='control-label' for='form_numeroDocumento'>Nº de Documento*</label>";
		$form_html .= "			<input type='number' id='form_numeroDocumento' name='form_numeroDocumento' required='required' class='form-control' value='".$request->form_numeroDocumento."' ".$deshabilitar."/>";
		if($request->form_numeroDocumento ==""){
			$error = "1";
			$form_html .= $mensaje;
		}
		$form_html.= "</div>";
		$form_html.= "    </div>";
	 
		$form_html .= $this->cambia_class($request->form_numeroTramite, 2);
		$form_html.= "        <div class='form-group'><label class='control-label' for='form_numeroTramite'>Nº de Trámite*</label><input type='text' id='form_numeroTramite' name='form_numeroTramite' class='form-control' value='".$request->form_numeroTramite."' ".$deshabilitar."/></div>";
		if($request->form_numeroTramite ==""){
			$error = "1";
			$form_html .= $mensaje;
		}
		$form_html.= "    </div>";
		
		if ($descError == ""){
			$form_html.= "    <div class='col-md-3'>";
			$form_html.= "        <div class='form-group'><label class='control-label' for='form_numeroTramite'>Apellido y Nombre</label><label id='form_numeroTramite' name='form_numeroTramite' class='form-control' />".$turno[0]->Apyn."</div>";
			$form_html.= "    </div>";
			 
			$form_html.= "";
			$form_html.= "    <div class='col-md-2'>";
			$form_html.= "        <div class='form-group'><label class='control-label' for='form_numeroTramite'>Tramite</label><label id='form_numeroTramite' name='form_numeroTramite' class='form-control' />".$turno[0]->tramite."</div>";
			$form_html.= "    </div>";
			 
			$form_html.= "";
			$form_html.= "    <div class='col-md-2'>";
			$form_html.= "        <div class='form-group'><label class='control-label' for='form_numeroTramite'>Turno</label><label id='form_numeroTramite' name='form_numeroTramite' class='form-control' />".$turno[0]->turno."</div>";
			$form_html.= "<input type='hidden' name='id_turno' value='".$turno[0]->id_turno."'>";
			$form_html.= "<input type='hidden' name='id_tipodoc' value='".$tipodoc."'>";
			$form_html.= "<input type='hidden' name='id_nrodoc' value='".$nrodoc."'>";
			$form_html.= "<input type='hidden' name='id_comprobante' value='".$comprobante."'>";
			$form_html.= "    </div>";
			 
			$form_html.= "";
		}

		$form_html.= "</div>";

		$form_html.= "";
		if ($descError != ""){
			$form_html.= "<div class='row form-group'>";
			$form_html.= "    <div class='col-md-4'>";
			$form_html.= "        <div class='g-recaptcha' data-sitekey='6LfpoScUAAAAAA2usCdAwayw_KQiHe44y5e1Whk-'></div>";
			$form_html.= "        </div>";
			$form_html.= "</div>";
		}
		else{
			$form_html.= "        <button type='button' class='btn btn-success' onclick='anular()'>Cancelar Turno</button>"; 
			$form_html.= "<input type='hidden' name='val_cancela' value='ok'>";
		}

		$form_html.= "";
		$form_html.= " ";
		$form_html.= "";
		$form_html.= "<div class='row form-group'>";
		$form_html.= "    <div class='col-md-2'>";
		if ($descError != ""){
			$form_html.= "        <button type='button' class='btn btn-success' onclick='buscar()'>Buscar</button>"; 
		}
		

		$form_html.= "        <div id='gif_cargando' class='gif_cargando' style='display: none'><img src='../css/css_imgs/cargando.gif'></div>";
		$form_html.= "    </div>";
		$form_html.= "</div>";
		$form_html.= "";
		$form_html.= "<input type='hidden' name='_token' value='".csrf_token()."'>";


		$form_html .= "</form>";

		if ($descError != ""){
			$mensajeerror = "<div class='alert alert-danger'>    <ul class='list-unstyled'><li><span class=
			glyphicon glyphicon-exclamation-sign'></span> ".$descError."</li></ul>
    		</div>";
    	}
    	else{
    		$mensajeerror = "<div class='alert alert-success'>    <ul class='list-unstyled'><li><span class=
			glyphicon glyphicon-ok'></span>Verifique si los datos son correctos y confirme.</li></ul>
    		</div>";
    	}	


    	return view('anular.cancelaturno',compact('mensajeerror','form_html'));
        
		
	}

	public function cambia_class($val, $cols){
    	if($val == "")
			{return "	<div class='col-md-".$cols." has-error'>  ";}
		else
			{return "	<div class='col-md-".$cols."'>  ";}
    }

	public function cancela_turno_save($id_turno, $tipodoc, $nrodoc, $comprobante){

		/*$turno =  DB::select("SELECT mm_turnos.id_turno, mm_liquidaciones.nconprobante, mm_liquidaciones.tipo_doc, mm_liquidaciones.nro_doc, mm_turnos.libre, mm_liquidaciones.estado, mm_turnos.fecha 
			FROM mm_liquidaciones INNER JOIN mm_turnos ON mm_liquidaciones.id_turno = mm_turnos.id_turno 
			WHERE mm_turnos.id_turno = ".$id_turno." AND mm_liquidaciones.nconprobante = ".$comprobante." AND mm_liquidaciones.tipo_doc = '".$tipodoc."' AND mm_liquidaciones.nro_doc = ".$nrodoc);*/

		$turno =  DB::select("select mm_turno_det.id_comprobante, mm_turno_det.id_turno, mm_turnos.fecha , mm_turno_det.tipo_doc, mm_turno_det.nro_doc, CONCAT(mm_turno_det.apellido,' ', mm_turno_det.nombre) as Apyn, mm_turno_det.fecha_cancela , tab_tramites.tramite, CONCAT(DATE_FORMAT(mm_turnos.fecha,'%d/%m/%Y'),' ', mm_turnos.hora,' Hs') as turno, mm_turnos.Nro_turno
				from mm_turno_det 
				INNER JOIN mm_turnos ON mm_turno_det.id_turno = mm_turnos.id_turno
				INNER JOIN tab_tramites ON mm_turno_det.id_tramite = tab_tramites.id_tramite  
        	 	WHERE mm_turno_det.id_comprobante = ".$comprobante." AND mm_turno_det.tipo_doc = '".$tipodoc."' AND mm_turno_det.nro_doc = ".$nrodoc);

		if(!$turno){
			return "Turno no encontrado";
		}
		else{
			$date = Carbon::now();
			$date = $date->format('Y-m-d');

			if($turno[0]->fecha < $date){
				return "El turno ya pasó, no puede anularse";
			}
			
		}

		$rta ='error al anlar el turno';
		DB::beginTransaction();
        try{

        	//DB::select(DB::raw('delete from mm_turno_det  where id_turno = '.$turno[0]->id_turno));
	    	DB::insert('insert into mm_turno_det_copy (SELECT id_comprobante, id_turno, id_tramite, tipo_doc, nro_doc, apellido, nombre, domicilio_calle, domicilio_nro, domicilio_subnro, domicilio_piso, domicilio_dpto, domicilio_mzna, telefono, email, Fecha_mov, NOW() as fecha_cancela FROM mm_turno_det where id_turno = '.$turno[0]->id_turno.')');

            DB::insert('delete from mm_turno_det  where id_turno = '.$turno[0]->id_turno);

        	$mm_turnos   = mm_turnos::get_registro($turno[0]->id_turno);
        	$mm_turnos->libre = 1;
        	$mm_turnos->save();

			DB::commit();
			$rta ='ok';
        }

        catch (\Exception $e)
        {
            DB::rollBack();            
            $rta ='error al anlar el turno'.$e;
            throw $e;          
        }        

		return $rta;
		
	}



}