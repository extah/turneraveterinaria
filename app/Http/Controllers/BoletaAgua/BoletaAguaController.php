<?php

namespace App\Http\Controllers\BoletaAgua;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use SoapClient;

//use App\Libraries\barcode\code128;
use App\Libraries\barcode\mem_image;

 
class BoletaAguaController extends Controller
{

	public function index(Request $request) 
	{	
		$url = action('BoletaAgua\BoletaAguaController@getboleta');


		$form_html = "<script src='https://www.google.com/recaptcha/api.js?hl=es' async defer> </script>";
    	 
    	$form_html .= "<script src='js/gforms.js'> </script>";
    	
		$form_html .= "<form name='form' method='GET' action='".$url."'>";

		$form_html.= "<div class='row form-group'>";
		$form_html.= "    <div class='col-md-3'>";
		$form_html.= "        <div class='form-group'><label class='control-label' for='form_numeroDocumento'>Nº de Tanque*</label><input type='number' id='form_numeroTanque' name='form_numeroTanque' class='form-control' required /></div>";
		$form_html.= "    </div>";
		$form_html.= "<div class='row form-group'>";
		$form_html.= "    <div class='col-md-3'>";
		$form_html.= "        <div class='form-group'><label class='control-label' for='form_numeroDocumento'>Email*</label><input type='Email' id='form_email' name='form_email' class='form-control' required /></div>";
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

		return view('boletaagua.boleta',compact('mensajeerror','form_html'));


	}

	public function getboleta(Request $request) 
	{	
		//$NroBoleta = "9999" ;
		//$this->genera2($NroBoleta);
		
	    /*$view =  \View::make('boletaagua.boletapdf', compact('NroBoleta'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('boletaagua');
		*/ 

 		/*$params = '0288A600016710118504130220000000802/2019-02-15/12020/'.$request->form_email."/".$request->form_numeroTanque."/".$request->form_numeroTanque;

        $wsdl = "http://plataforma.desarrollo.berisso.gob.ar/app_dev.php/rest/generarComprobante/".$params;
 	
        
		$response = file_get_contents($wsdl);
		$obj = json_decode($response);

		dd($obj->{'codigo_barras'});
		die;
		*/
			 


		if (Session::token() != $request->_token)
	    {
	    	$descError = 'Error de TOKEN';
	    	return $this->index_Error($descError);
	    }



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
			
        	$wsdl = "http://10.240.52.28/boletasdelegacion/ws_boleta.asmx?WSDL";
        	//$wsdl = "http://localhost:2901/ws_boleta.asmx?WSDL";
			$client = new SoapClient($wsdl, array('soap_version' => SOAP_1_1, 'trace' => true));
			$params =  array( "Xtanque"  => $request->form_numeroTanque);
			$result = $client->Boleta_ws($params);
			
			
			$obj = json_decode($result->Boleta_wsResult);


			//{"NroBoleta":"10118504","NroTanque":167,"Titular":"Segovia Sergio","Domicilio":"176 entre 80 y 82 N°167 Zona: 2","Vto":"2020-02-13","Imp_total":"280,00","barCode":"0288A600016710118504130220000000802","mensaje":"OK"}
			if ($obj->{'mensaje'}=="OK"){

				 
				$fvto = date("d/m/Y", strtotime($obj->{'Vto'}) );
				$f_liq = date("d/m/Y");

				$params = $obj->{'barCode'}.'/'.$obj->{'Vto'}.'/'.str_replace(',', '.', $obj->{'Imp_total'}).'/'.$request->form_email."/".$request->form_numeroTanque."/".$request->form_numeroTanque;
				
				//desarrollo
		        //$wsdl = "http://plataforma.desarrollo.berisso.gob.ar/app_dev.php/rest/generarComprobante/".$params;
		        //produccion
		        //$wsdl = "http://plataforma.berisso.gob.ar/app_dev.php/rest/generarComprobante/".$params;
		        

		        //desarrollo berisso.gob.ar

		        //$wsdl = "http://localhost:8080/turnosadm/public/epagos/generarComprobante/".$params;
		        //prosuccion berisso.gob.ar
		        $wsdl = "http://berisso.gov.ar/_licencias/turnosadm/public/epagos/generarComprobante/".$params;

				$response = file_get_contents($wsdl);
				$obj_cb = json_decode($response);
				 
				//dd($obj_cb);
				//die;
				 
				$this->genera2($request->form_numeroTanque,$obj->{'NroBoleta'},$f_liq,$fvto,$obj->{'Titular'},str_replace(',', '.', $obj->{'Imp_total'}), $obj_cb->{'codigo_barras'}, $obj_cb->{'base_64_image_codigo_barras'}, $obj_cb->{'base_64_image_qr'}, $obj->{'Domicilio'});
				die;
			}
			else{
				$descError = 'Error!! '.$obj->{'mensaje'};
	    		return $this->index_Error($descError);
			}
			
			
			//return $obj->{'NroBoleta'};
			//var_dump($result->Boleta_wsResult);
			
			 
		}
		else{
			return $this->index_Error($descError);
		}

		

	}

	public function index_Error($error) 
	{	
 		$url = action('BoletaAgua\BoletaAguaController@getboleta');
		$form_html = "<script src='https://www.google.com/recaptcha/api.js?hl=es' async defer> </script>";
    	 
    	$form_html .= "<script src='js/gforms.js'> </script>";
    	
		$form_html .= "<form name='form' method='GET' action='".$url."'>";

		$form_html.= "<div class='row form-group'>";
		$form_html.= "    <div class='col-md-3'>";
		$form_html.= "        <div class='form-group'><label class='control-label' for='form_numeroDocumento'>Nº de Tanque*</label><input type='number' id='form_numeroTanque' name='form_numeroTanque' class='form-control' required /></div>";
		$form_html.= "    </div>";
		$form_html.= "<div class='row form-group'>";
		$form_html.= "    <div class='col-md-3'>";
		$form_html.= "        <div class='form-group'><label class='control-label' for='form_numeroDocumento'>Email*</label><input type='Email' id='form_email' name='form_email' class='form-control' required /></div>";
		$form_html.= "    </div>";

		$form_html.= "</div>";
		$form_html.= "";
		$form_html.= "<div class='row form-group'>";
		$form_html.= "    <div class='col-md-4'>";
		$form_html.= "        <div class='g-recaptcha' data-sitekey='6LfpoScUAAAAAA2usCdAwayw_KQiHe44y5e1Whk-'></div>";
		$form_html.= "    </div>";
		$form_html.= "</div>";
		$form_html.= "<div class='alert alert-danger' role='alert'>";
		$form_html.= $error;
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

		return view('boletaagua.boleta',compact('mensajeerror','form_html'));


	}

	function genera2($ntanque,$boleta,$f_liq,$f_vto,$titular,$importe, $barcode, $ibc, $iqr, $Domicilio){


		/*$boleta = "12345699";
		$f_liq = "02/02/2020";
		$f_vto = "20/02/2020";
		$titular = "Segovia Sergio";
		$importe = 280;
		 */

		//$pdf = new code128('P', 'mm', 'A4');
		$pdf = new mem_image();
		$pdf->AddPage();
		$pdf->SetFont('Arial','',10);

		
		$pdf->Image('css/css_imgs/Logo_Municipal.png', 10, 8,-280);
		
		$pdf->SetLineWidth(.4);
		$pdf->Rect(70, $pdf->GetY(), 120, 18);
		$pdf->SetFillColor(211,211,211);
		$pdf->Rect(160, $pdf->GetY(), 30, 18,'DF');
		$pdf->SetFillColor(0,0,0);

		$pdf->SetFont('Arial','B',10);
		$pdf->SetX(70);
		$pdf->Cell(30, 5, "Boleta", 0, 0, 'C');
		$pdf->SetX(95);
		$pdf->Cell(30, 5, "Tasa", 0, 0, 'C');
		$pdf->SetX(125);
		$pdf->Cell(30, 5, utf8_decode("Fecha Liquidación"), 0, 0, 'C');
		$pdf->SetX(160);
		$pdf->Cell(30, 5, "Vencimiento", 0, 0, 'C');

		$pdf->SetFont('Arial','',12);
		$pdf->SetXY(70,$pdf->GetY()+8);
		$pdf->Cell(30, 5, $boleta, 0, 0, 'C');
		$pdf->SetX(95);
		$pdf->Cell(30, 5, "1211700", 0, 0, 'C');
		$pdf->SetX(125);
		$pdf->Cell(30, 5, $f_liq, 0, 0, 'C');
		$pdf->SetX(160);
		$pdf->Cell(30, 5, $f_vto, 0, 0, 'C');

		//letra blanca
		$pdf->SetXY(15,$pdf->GetY()+15);
		$pdf->SetFillColor(0,0,0);
		$pdf->Rect(15, $pdf->GetY(), 30, 7,'F');
		$pdf->SetTextColor(255,255,255);
		$pdf->SetFont('Arial','B',12);
		$pdf->SetXY(15,$pdf->GetY()+1);
		$pdf->Cell(30, 5, "DATOS", 0, 0, 'C');
		$pdf->SetTextColor(0,0,0);
		//

		$pdf->Rect(15, $pdf->GetY()+6, 175, 80);
		$pdf->SetXY(17, $pdf->GetY()+10);
		$pdf->Cell(30, 5, "TITULAR:", 0, 0, 'L');
		$pdf->SetXY(17, $pdf->GetY()+10);
		$pdf->Cell(30, 5, utf8_decode("N° TANQUE:"), 0, 0, 'L');
		$pdf->SetXY(17, $pdf->GetY()+10);
		$pdf->Cell(30, 5, utf8_decode("Dirección:"), 0, 0, 'L');

		$pdf->SetFont('Arial','',12);

		$pdf->SetXY(50, $pdf->GetY()-20);
		$pdf->Cell(30, 5, $titular, 0, 0, 'L');
		$pdf->SetXY(50, $pdf->GetY()+10);
		$pdf->Cell(30, 5,$ntanque, 0, 0, 'L');
		$pdf->SetXY(50, $pdf->GetY()+10);
		$pdf->Cell(30, 5,utf8_decode($Domicilio), 0, 0, 'L');


		$pdf->Rect(15, $pdf->GetY()+6, 175, 5);
		$pdf->SetXY(17, $pdf->GetY()+6);
		$pdf->SetFont('Arial','B',8);
		$pdf->SetX(17);
		$pdf->Cell(30, 5, "Cantidad", 0, 0, 'L');
		$pdf->SetX(40);
		$pdf->Cell(30, 5, "Detalle", 0, 0, 'L');
		$pdf->SetX(150);
		$pdf->Cell(30, 5, "Importe", 0, 0, 'L');
		$pdf->SetX(180);
		$pdf->Cell(30, 5, "Total", 0, 0, 'L');

		$pdf->SetXY(17, $pdf->GetY()+8);
		$pdf->SetFont('Arial','',10);
		$pdf->SetX(22);
		$pdf->Cell(30, 5, "1", 0, 0, 'L');
		$pdf->SetX(40);
		$pdf->Cell(30, 5, "1/2 Tanque de Agua Familia", 0, 0, 'L');
		$pdf->SetX(150);
		$pdf->Cell(30, 5, number_format($importe, 2, ',', ' '), 0, 0, 'L');
		$pdf->SetX(176);
		$pdf->Cell(30, 5, number_format($importe, 2, ',', ' '), 0, 0, 'L');


		$pdf->SetXY(17, $pdf->GetY()+42);
		$pdf->Rect(120, $pdf->GetY(), 43, 10);
		$pdf->SetFillColor(211,211,211);
		$pdf->Rect(163, $pdf->GetY(), 27, 10,'DF');
		$pdf->SetFillColor(0,0,0);

		$pdf->SetXY(125, $pdf->GetY()+3);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(30, 5, "IMPORTE TOTAL", 0, 0, 'L');
		$pdf->SetX(176);
		$pdf->Cell(30, 5, number_format($importe, 2, ',', ' '), 0, 0, 'L');


		//QR
		$pdf->SetXY(70, $pdf->GetY()+10);
		$pic = base64_decode($ibc);
		$im = imagecreatefromstring($pic);
		if ($im !== false) {
    		header('Content-Type: image/png');
			//$pdf->GDImage($im, 90, $pdf->GetY(), 110);
			$pdf->GDImage($im, 70, $pdf->GetY(),120);
		}
		$pic = base64_decode($iqr);
		$im = imagecreatefromstring($pic);
		if ($im !== false) {
    		header('Content-Type: image/png');
			//$pdf->GDImage($im, 90, $pdf->GetY(), 110);
			$pdf->GDImage($im, 15, $pdf->GetY()-5);
		}
		$pdf->SetXY(70, $pdf->GetY()+13);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(30, 5, $barcode, 0, 0, 'L');

		$pdf->SetXY(15, $pdf->GetY()+30);
		for($x = 15; $x <= 185; $x += 10)
		{
		    $pdf->Line($x, $pdf->GetY(), $x+5, $pdf->GetY());
		    
		}		 
				//segundo talon

		//letra blanca
		$pdf->SetXY(15,$pdf->GetY()+5);
		$pdf->SetFillColor(0,0,0);
		$pdf->Rect(15, $pdf->GetY(), 55, 7,'F');
		$pdf->SetTextColor(255,255,255);
		$pdf->SetFont('Arial','B',12);
		$pdf->SetXY(15,$pdf->GetY()+1);
		$pdf->Cell(55, 5, utf8_decode("Talón Municipalidad"), 0, 0, 'C');
		$pdf->SetTextColor(0,0,0);
		//

		$pdf->SetFont('Arial','',10);

		$pdf->Image('css/css_imgs/Logo_Municipal.png', 10, $pdf->GetY()+4,-280);
		$pdf->SetXY(15,$pdf->GetY()+6);
		$pdf->SetLineWidth(.4);
		$pdf->Rect(70, $pdf->GetY(), 120, 19);
		$pdf->SetFillColor(211,211,211);
		$pdf->Rect(160, $pdf->GetY(), 30, 19,'DF');
		$pdf->SetFillColor(0,0,0);

		$pdf->SetFont('Arial','B',10);
		$pdf->SetX(70);
		$pdf->Cell(30, 5, "Boleta", 0, 0, 'C');
		$pdf->SetX(95);
		$pdf->Cell(30, 5, "Tasa", 0, 0, 'C');
		$pdf->SetX(125);
		$pdf->Cell(30, 5, utf8_decode("Fecha Liquidación"), 0, 0, 'C');
		$pdf->SetX(160);
		$pdf->Cell(30, 5, "Vencimiento", 0, 0, 'C');

		$pdf->SetFont('Arial','',12);
		$pdf->SetXY(70,$pdf->GetY()+8);
		$pdf->Cell(30, 5, $boleta, 0, 0, 'C');
		$pdf->SetX(95);
		$pdf->Cell(30, 5, "1211700", 0, 0, 'C');
		$pdf->SetX(125);
		$pdf->Cell(30, 5, $f_liq, 0, 0, 'C');
		$pdf->SetX(160);
		$pdf->Cell(30, 5, $f_vto, 0, 0, 'C');

		//

		$pdf->Rect(15, $pdf->GetY()+11, 175, 50);
		$pdf->SetXY(17, $pdf->GetY()+13);
		$pdf->Cell(30, 5, "TITULAR:", 0, 0, 'L');
		$pdf->SetXY(17, $pdf->GetY()+5);
		$pdf->Cell(30, 5, utf8_decode("N° TANQUE:"), 0, 0, 'L');
		$pdf->SetXY(17, $pdf->GetY()+5);
		$pdf->Cell(30, 5, utf8_decode("Dirección:"), 0, 0, 'L');

		$pdf->SetFont('Arial','',12);

		$pdf->SetXY(50, $pdf->GetY()-10);
		$pdf->Cell(30, 5, $titular, 0, 0, 'L');
		$pdf->SetXY(50, $pdf->GetY()+5);
		$pdf->Cell(30, 5,$ntanque, 0, 0, 'L');
		$pdf->SetXY(50, $pdf->GetY()+5);
		$pdf->Cell(30, 5,utf8_decode($Domicilio), 0, 0, 'L');

		$pdf->Rect(15, $pdf->GetY()+6, 175, 5);
		$pdf->SetXY(17, $pdf->GetY()+6);
		$pdf->SetFont('Arial','B',8);
		$pdf->SetX(17);
		$pdf->Cell(30, 5, "Cantidad", 0, 0, 'L');
		$pdf->SetX(40);
		$pdf->Cell(30, 5, "Detalle", 0, 0, 'L');
		$pdf->SetX(150);
		$pdf->Cell(30, 5, "Importe", 0, 0, 'L');
		$pdf->SetX(180);
		$pdf->Cell(30, 5, "Total", 0, 0, 'L');

		$pdf->SetXY(17, $pdf->GetY()+8);
		$pdf->SetFont('Arial','',10);
		$pdf->SetX(22);
		$pdf->Cell(30, 5, "1", 0, 0, 'L');
		$pdf->SetX(40);
		$pdf->Cell(30, 5, "1/2 Tanque de Agua Familia", 0, 0, 'L');
		$pdf->SetX(150);
		$pdf->Cell(30, 5, number_format($importe, 2, ',', ' '), 0, 0, 'L');
		$pdf->SetX(176);
		$pdf->Cell(30, 5, number_format($importe, 2, ',', ' '), 0, 0, 'L');


		$pdf->SetXY(17, $pdf->GetY()+24);
		$pdf->Rect(120, $pdf->GetY(), 43, 10);
		$pdf->SetFillColor(211,211,211);
		$pdf->Rect(163, $pdf->GetY(), 27, 10,'DF');
		$pdf->SetFillColor(0,0,0);

		$pdf->SetXY(125, $pdf->GetY()+3);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(30, 5, "IMPORTE TOTAL", 0, 0, 'L');
		$pdf->SetX(176);
		$pdf->Cell(30, 5, number_format($importe, 2, ',', ' '), 0, 0, 'L');

		$pdf->Output();
	}

	function prueba(){

		//$wsdl = "http://10.240.50.213/ws_LiqConve/Service1.asmx?WSDL";

		$wsdl = "http://10.240.52.28/wsportal/Service1.asmx?WSDL";    	

		$client = new SoapClient($wsdl, array('soap_version' => SOAP_1_1, 'trace' => true));
		
		//consulta deuda convenio
		$params =  array( "tasa"  => 23	,"xID"  => "887");
		
		$result = $client->Cuotas_deuda($params);
		

		//Generar Liquidacion 
		
		//$params = array( "xjson"  => '{"tasa": "29", "identificacion": "20714","periodos":[{"cuota":"1"},{"cuota":"2"},{"cuota":"3"}]}');
		
//$params = array( "xjson"  => '{"tasa": "33", "identificacion": "857AQQ","periodos":[{"cuota":"-1"}]}');

		
//		$result = $client->Liquida_deuda($params);

		dd($result);
 
		
		//$obj = json_decode($result->Boleta_wsResult);

		//dd($obj);
	}

}