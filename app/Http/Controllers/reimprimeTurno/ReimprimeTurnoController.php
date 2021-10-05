<?php

namespace App\Http\Controllers\reimprimeTurno;
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

class ReimprimeTurnoController extends Controller
{

	public function reimprimir_turno(){

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

		return view('reimprime.reimprimeTurno',compact('mensajeerror','form_html'));

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
          $rta = $this->reimprimir($request->id_turno, $request->id_tipodoc, $request->id_nrodoc, $request->id_comprobante);
          
          if ($rta != 'ok'){
				$mensajeerror = "<div class='alert alert-danger'>    <ul class='list-unstyled'><li><span class=
				glyphicon glyphicon-exclamation-sign'></span> ".$rta."</li></ul>
	    		</div>";
	    	}
	    	else{
	    
	    		return redirect('nuevoTurno/boletapdf/'.$request->id_comprobante.'/'.$request->id_nrodoc);
	    		 
	    	}	

	    	$form_html= "<div class='row form-group'>";
			$form_html.= "    <div class='col-md-2'>";
		
			$form_html.= "        <button type='button' class='btn btn-success' onclick='volver()'>Volver</button>"; 
	
			$form_html.= "    </div>";
			$form_html.= "</div>";
          	return view('reimprime.reimprimeTurno',compact('mensajeerror','form_html'));

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
        	 /*$turno =  DB::select("SELECT mm_liquidaciones.nconprobante, mm_liquidaciones.id_turno, mm_liquidaciones.tipo_doc, mm_liquidaciones.nro_doc, CONCAT(mm_liquidaciones.apellido,' ', mm_liquidaciones.nombre) as Apyn, mm_liquidaciones.estado, tab_tramites.tramite, CONCAT(DATE_FORMAT(mm_turnos.fecha,'%d/%m/%Y'),' ', mm_turnos.hora,' Hs') as turno, mm_turnos.Nro_turno
        	 	FROM mm_liquidaciones 
        	 	INNER JOIN mm_turnos ON mm_liquidaciones.id_turno = mm_turnos.id_turno 
        	 	INNER JOIN tab_tramites ON mm_turnos.id_tramite_turno = tab_tramites.id_tramite 
        	 	WHERE mm_liquidaciones.nconprobante = ".$comprobante." AND mm_liquidaciones.tipo_doc = '".$tipodoc."' AND mm_liquidaciones.nro_doc = ".$nrodoc);*/
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
        	 		$descError = "No se puede descargar el turno porque se encuentra anulado";
    	 		}
    	 		else{
    	 			$deshabilitar = " disabled='true' ";
    	 		}
    	 	}
        }
        else{
        	$descError .= " Faltan ingresar Datos";
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
			$form_html.= "        <button type='button' class='btn btn-success' onclick='reimprimir()'>Reimprimir Turno</button>"; 
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


    	return view('reimprime.reimprimeTurno',compact('mensajeerror','form_html'));
        
		
	}

	public function cambia_class($val, $cols){
    	if($val == "")
			{return "	<div class='col-md-".$cols." has-error'>  ";}
		else
			{return "	<div class='col-md-".$cols."'>  ";}
    }

	public function reimprimir($id_turno, $tipodoc, $nrodoc, $comprobante){


		return "ok";

		
	}



}