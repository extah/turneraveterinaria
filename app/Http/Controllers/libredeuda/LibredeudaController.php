<?php

namespace App\Http\Controllers\libredeuda;
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
use DateTime;

use SoapClient;

class LibredeudaController extends Controller
{

	public function libredeuda_index(){

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
		$form_html.= "        <div class='form-group'><label class='control-label' for='form_apellido'>Apellido*</label><input type='text' id='form_apellido' name='form_apellido' class='form-control' /></div>";
		$form_html.= "    </div>";

		$form_html.= "    <div class='col-md-2'>";
		$form_html.= "        <div class='form-group'><label class='control-label' for='form_nombre'>Nombre*</label><input type='text' id='form_nombre' name='form_nombre' class='form-control' /></div>";
		$form_html.= "    </div>";

		$form_html.= "</div>";
		$form_html.= "";
		$form_html.= "<div class='row form-group'>";
		$form_html.= "    <div class='col-md-4'>";
		$form_html.= "        <div class='g-recaptcha' data-sitekey='6LfpoScUAAAAAA2usCdAwayw_KQiHe44y5e1Whk-'></div>";
		$form_html.= "    </div>";
		$form_html.= "</div>";
		$form_html.= "";
		$form_html.= " ";
		$form_html.= "";
		$form_html.= "<div class='row form-group'>";
		$form_html.= "    <div class='col-md-2'>";
		$form_html.= "        <button type='button' class='btn btn-success' onclick='buscar()'>Buscar</button>";
		$form_html.= "    <div id='gif_cargando' class='gif_cargando' style='display: none'><img src='../css/css_imgs/cargando.gif'></div>";
		$form_html.= "    </div>";
		$form_html.= "</div>";
		$form_html.= "";
		$form_html.= "<input type='hidden' name='_token' value='".csrf_token()."'>";


		$form_html .= "</form>";

		$mensajeerror = "";

		return view('libredeuda.libredeuda',compact('mensajeerror','form_html'));

	}

	public function libredeuda_buscar(Request $request){

		//return redirect('libredeuda/boletapdf/1/25583697');

		$mensaje = "<span class='help-block'>    <ul class='list-unstyled'><li><span class='glyphicon glyphicon-exclamation-sign'></span> Este campo es obligatorio.</li></ul></span>"; 
		$mensajeerror = "";
		$captcha = "";
		$descError = "";
		$id_turno = 0;
		
		$tipodoc = $request->form_tipoDocumento;
		$nrodoc = $request->form_numeroDocumento;
		$apellido = $request->form_apellido;
		$nombre = $request->form_nombre;

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
	    
	    		return redirect('nuevoTurno/boletapdf/'.$request->id_turno.'/'.$request->id_nrodoc);
	    		 
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

        if ($descError == "" & ($tipodoc !="" & $nrodoc!="" & $nombre!="" & $apellido!="")){
        	//$turno =  DB::select("select * from mm_causas where doc_tipo = '".$tipodoc."' and doc_nro = ".$nrodoc);
			//ws faltas
        	$opts = array(
		        'ssl' => array('ciphers'=>'RC4-SHA', 'verify_peer'=>false, 'verify_peer_name'=>false)
		    ); 
        	$params = array ('encoding' => 'UTF-8', 'verifypeer' => false, 'verifyhost' => false, 'soap_version' => SOAP_1_2, 'trace' => 1, 'exceptions' => 1, "connection_timeout" => 180, 'stream_context' => stream_context_create($opts) );
			$url_ = "http://10.240.52.28/ws_faltas/ws_causas.asmx?WSDL";
        	$causas_ws = new SoapClient($url_ , $params);

        	$tiene_causas=$causas_ws->tieneCausas(['pDocTipo' => $tipodoc,'pDocNro' => $nrodoc ])->tieneCausasResult;
        	
        	//return $tiene_causas; 

    	 	if ($tiene_causas == "N"){
    	 		$error = "0";
    	 		//$descError = "No tiene causas.";

    	 		$descError = $this->libredeuda_save($tipodoc, $nrodoc, $apellido, $nombre);
    	 		if ($descError == "Error al grabar"){
    	 			$error = "1";
    	 		}
    	 		else
    	 		{	
    	 			 return redirect('libredeuda/boletapdf/'.$descError.'/'.$nrodoc);
    	 		}

    	 	}
    	 	else{
	 		 
    	 		$error = "1";
    	 		$descError = "";
    	 		$form_html = $this->tiene_causas($request->form_tipoDocumento, $request->form_numeroDocumento);
    	 		return view('libredeuda.libredeuda',compact('mensajeerror','form_html'));
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
		$form_html.= "		</div>";
		$form_html.= "	</div>";


		$form_html .= $this->cambia_class($request->form_apellido, 2);
		$form_html.= "        <div class='form-group'><label class='control-label' for='form_apellido'>Apellido*</label>";
		$form_html .= "			<input type='text' id='form_apellido' name='form_apellido' required='required' class='form-control' value='".$request->form_apellido."' ".$deshabilitar."/>";
		if($request->form_apellido ==""){
			$error = "1";
			$form_html .= $mensaje;
		}
		$form_html.= "		</div>";
		$form_html.= "	</div>";

		$form_html .= $this->cambia_class($request->form_nombre, 2);
		$form_html.= "        <div class='form-group'><label class='control-label' for='form_nombre'>Nombre*</label>";
		$form_html .= "			<input type='text' id='form_nombre' name='form_nombre' required='required' class='form-control' value='".$request->form_nombre."' ".$deshabilitar."/>";
		if($request->form_nombre ==""){
			$error = "1";
			$form_html .= $mensaje;
		}
		$form_html.= "		</div>";
		$form_html.= "	</div>";

	 
		if ($descError == ""){
			$form_html.= "    <div class='col-md-3'>";
			$form_html.= "        <div class='form-group'><label class='control-label' for='form_numeroTramite'>Apellido y Nombre</label><label id='form_numeroTramite' name='form_numeroTramite' class='form-control' />".$turno[0]->Apyn."</div>";
			$form_html.= "    </div>";
			 
			$form_html.= "";

			$form_html.= "";
			$form_html.= "    <div class='col-md-2'>";
			$form_html.= "        <div class='form-group'><label class='control-label' for='form_numeroTramite'>Turno</label><label id='form_numeroTramite' name='form_numeroTramite' class='form-control' />".$turno[0]->turno."</div>";
			$form_html.= "<input type='hidden' name='id_turno' value='".$turno[0]->id_turno."'>";
			$form_html.= "<input type='hidden' name='id_tipodoc' value='".$tipodoc."'>";
			$form_html.= "<input type='hidden' name='id_nrodoc' value='".$nrodoc."'>";
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

    	return view('libredeuda.libredeuda',compact('mensajeerror','form_html'));
		
	}

	public function cambia_class($val, $cols){
    	if($val == "")
			{return "	<div class='col-md-".$cols." has-error'>  ";}
		else
			{return "	<div class='col-md-".$cols."'>  ";}
    }

	public function reimprimir($tipodoc, $nrodoc){


		return "ok";

		
	}

	public function tiene_causas($tdoc, $ndoc){

    	
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
        $div .= '              <p>El Documento '.$tdoc.' '.$ndoc.' posee causas pendientes, por favor acerquese al Juzgado de Faltas sito en calle 11 N° 4454. Tel: 0221 461-7362, Horario: 08:00 a 12:00Hs</p>';
        $div .= '            </div>';
        $div .= '          </div>';

        $div .= '        </div>';
        $div .= '      </div>';
        $div .= '    </div>';

        return $div;

    }

    function prueba(){

		$hoy = date('Y-m-d');
    	$vto = date('Y-m-d', strtotime('+5 day'));

    	//verifico los sabados y domingos
    	$cantdias = $this->Fines_de_semana($hoy, $vto);
    	$vto = date('Y-m-d', strtotime($vto.'+'.$cantdias.' day'));

    	$feriados = DB::select("select count(*) as cant from tab_feriados 
			where fecha BETWEEN  '".$hoy."' and '".$vto."'");
    	
    	if ($feriados[0]->cant != 0 ){
    		$vto = date('Y-m-d', strtotime($vto.'+'.$feriados[0]->cant.' day'));
    	}
    	
    	return "Hoy = ".$hoy."vto= ".$vto." fines de semana = ".$cantdias. " feriados = ".$feriados[0]->cant;

    }

    function libredeuda_save($tipodoc, $nrodoc, $apellido, $nombre){

    	$zona_horaria = "-3";  
    	$formato = "H:i"; //El formato de tu fecha. Checa en http://www.php.net/date 
	    $hora = gmdate($formato,time()+($zona_horaria*3600)); 

    	$precio = DB::select("SELECT * FROM tab_precios WHERE id_tramite = 1");
    	DB::beginTransaction();

		$hoy = date('Y-m-d');
    	$vto = date('Y-m-d', strtotime('+5 day'));

    	//verifico los sabados y domingos
    	$cantdias = $this->Fines_de_semana($hoy, $vto);
    	$vto = date('Y-m-d', strtotime($vto.'+'.$cantdias.' day'));

    	$feriados = DB::select("select count(*) as cant from tab_feriados 
			where fecha BETWEEN  '".$hoy."' and '".$vto."'");
    	
    	if ($feriados[0]->cant != 0 ){
    		$vto = date('Y-m-d', strtotime($vto.'+'.$feriados[0]->cant.' day'));
    	}
        
        try{

    		$liq = new mm_liquidaciones;

    		$liq = new mm_liquidaciones;
			$liq->id_turno = 0;
			$liq->tasa = "1211200";
			$liq->tipo_doc = $tipodoc;
			$liq->nro_doc = $nrodoc;
			$liq->apellido = strtoupper($apellido);
			$liq->nombre = strtoupper($nombre);
			$liq->origen = "WEB";
			$liq->importe = $precio[0]->Importe;
			$liq->fecha_vto = $vto;
			$liq->fecha_emision = date("Y-m-d"); 
			$liq->hora_emision = $hora; 
			$liq->estado = "Emitida";


    		if($liq->save()) {
                $comprobante = $liq->nconprobante;
            }

			DB::commit();
			$error = "0";
            //$descError = 'libredeuda/boletapdf/'.$comprobante.'/'.$nrodoc;
            $descError = $comprobante;


            }

        catch (\Exception $e)
        {
            DB::rollBack();
            $error = "3";
            $descError = "Error al grabar";
            throw $e;
          
        }        

      return $descError ;

    }

    public function Fines_de_semana($desde, $hasta){

	  $starDate = new DateTime($desde);
	  $endDate = new DateTime($hasta);
	  $interval = $starDate->diff($endDate);
	  $numberOfDays = $interval->format('%d days');
	  $day = 0;
	  for($i = 1; $i <= $numberOfDays; $i++){
	       if($starDate->format('l')== 'Saturday' || $starDate->format('l')== 'Sunday'){
	              //echo $starDate->format('y-m-d (D)')."<br/>";
	              $day += 1;
	       }
	       $starDate->modify("+1 days");
	  }
	  return $day;
	}

    public function invoice($id, $nrodoc) 
    {
    	
        $liquidacion =  DB::select('SELECT *
            FROM mm_liquidaciones
            WHERE nconprobante = '.$id.' and nro_doc = '.$nrodoc);

        IF ($liquidacion){
            
        	$vto = date("d/m/Y", strtotime($liquidacion[0]->fecha_vto));

            $caracteres = Array(".",","); 
            $imp = number_format($liquidacion[0]->importe, 2, ',', ' ');
            //0288 tasa=43 ID= 999999 Boleta=00053819 Vto=310717 importe=00026000 digito=0
            $barcode = "028843999999";
            $barcode .= str_pad($liquidacion[0]->nconprobante, 8, "0", STR_PAD_LEFT);
            $barcode .= substr($vto, 0, -8);
            $barcode .= substr($vto, 3, -5);
            $barcode .= substr($vto, 8, 2);
            $barcode .= str_pad(str_replace($caracteres,"",$imp), 8, "0", STR_PAD_LEFT);
            $barcode .= $this->digitoverif($barcode);
            
            $date = date('Y-m-d');

            $domicilio = "";

            //$view =  \View::make('pdf.invoice', compact('data', 'date', 'invoice'))->render();
            $view =  \View::make('boleta.libredeudab', compact('liquidacion', 'date', 'imp','barcode','domicilio'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream('invoice');
        }
        else
        {
            return view('boleta.error');
        }
    }

    function digitoverif($XBar){
        $XDigito = 0;
        for($i = 0; $i < strlen($XBar); $i++) {
        	if($i %2 == 0){
                $XDigito += $XBar[$i] ;
                }
              else{

                $XDigito += $XBar[$i]* 3;
            }
        }
        $XDigito = $XDigito % 10;
        return $XDigito;
    }


}