<?php

namespace App\Http\Controllers\boleta;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Mail\Reminder;
use Illuminate\Support\Facades\Mail;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Barryvdh\DomPDF\Facade as PDF;


use Auth;
use DB;
use URL;
use Redirect; 

use App\mm_turnos;
use App\mm_turno_det;

class BoletaController extends Controller
{

	public function invoice($id, $nrodoc) 
    {
        $turno =  DB::select('SELECT mm_turnos.id_turno, mm_turno_det.id_comprobante, tab_tramites.tramite, DATE_FORMAT( mm_turnos.fecha,"%d/%m/%Y") AS fecha, mm_turnos.hora, mm_turnos.Nro_turno, mm_turno_det.tipo_doc, FORMAT(mm_turno_det.nro_doc, 0, "de_DE") AS nro_doc, mm_turno_det.apellido, mm_turno_det.nombre, mm_turno_det.domicilio_calle, mm_turno_det.domicilio_nro, mm_turno_det.domicilio_subnro, mm_turno_det.domicilio_piso, mm_turno_det.domicilio_dpto, mm_turno_det.domicilio_mzna, mm_turno_det.telefono, mm_turno_det.email, mm_turnos.Fecha_mov , mm_turno_det.id_comprobante, mm_turno_det.Fecha_mov, DATE_FORMAT(mm_turno_det.Fecha_mov, "%d/%m/%Y") as fecha_emision, DATE_FORMAT(mm_turno_det.Fecha_mov, "%H:%i") as hora_emision
            FROM mm_turnos
            INNER JOIN mm_turno_det ON mm_turnos.id_turno = mm_turno_det.id_turno
            INNER JOIN tab_tramites ON mm_turno_det.id_tramite = tab_tramites.id_tramite
            WHERE mm_turno_det.id_comprobante = '.$id.' and mm_turno_det.nro_doc = '.$nrodoc);

        IF ($turno){
            /*$importe = DB::select('SELECT * FROM Tab_precios WHERE id_Tramite = 1');

            $caracteres = Array(".",","); 
            $imp = number_format($turno[0]->importe, 2, ',', ' ');
            //0288 tasa=43 ID= 999999 Boleta=00053819 Vto=310717 importe=00026000 digito=0
            $barcode = "028843999999";
            $barcode .= str_pad($turno[0]->nconprobante, 8, "0", STR_PAD_LEFT);
            $barcode .= substr($turno[0]->fecha_vto, 0, -8);
            $barcode .= substr($turno[0]->fecha_vto, 3, -5);
            $barcode .= substr($turno[0]->fecha_vto, 8, 2);
            $barcode .= str_pad(str_replace($caracteres,"",$imp), 8, "0", STR_PAD_LEFT);
            $barcode .= $this->digitoverif($barcode);
            */

            $date = date('Y-m-d');

            $domicilio = $this->cargadom($turno[0]->domicilio_calle, $turno[0]->domicilio_nro, $turno[0]->domicilio_subnro, $turno[0]->domicilio_piso, $turno[0]->domicilio_dpto, $turno[0]->domicilio_mzna);

            $xmail = $turno[0]->email;
            $xid = $id;
            $xndoc = $nrodoc;

            // Mail::to($xmail)->send(new Reminder($xmail,$xid,$xndoc));

            //$view =  \View::make('pdf.invoice', compact('data', 'date', 'invoice'))->render();
            $view =  \View::make('boleta.comprobante', compact('turno', 'date', 'importe','barcode','domicilio'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream('invoice');
        }
        else
        {
            return view('boleta.error');
        }
    }
 
    public function getData() 
    {
        $data =  [
            'quantity'      => '1' ,
            'description'   => 'some ramdom text',
            'price'   => '500',
            'total'     => '500'
        ];
        return $data;
    }
	
    public function muestrapdf(){
		$data = $this->getData();
        $date = date('Y-m-d');
        $invoice = "2222";
        
        return view('boleta.comprobante', compact('data', 'date', 'invoice'));
 

    }

    public function errorboleta(){
        return view('boleta.error');

    }

    function cargadom($calle, $nro, $subnro, $piso, $dpto, $mzna){
        $dom = "";
        if($calle != '')
        {
            $dom .= "calle ".$calle;
        }
        if($nro != '')
        {
            $dom .= " N° ".$nro;
        }
        if($subnro != '')
        {
            $dom .= " ".$subnro;
        }
        if($piso != '')
        {
            $dom .= " piso ".$piso;
        }
        if($dpto != '')
        {
            $dom .= " dpto. ".$dpto;
        }
        if($mzna != '')
        {
            $dom .= " mzna. ".$mzna;
        }

        return $dom;

    }

    function digitoverif($XBar){

        $XDigito = 0;

         
        for($i = 1; $i <= count($XBar); $i++) {
            If (($i / 2) == floor($i / 2)) {
                $XDigito += $XBar[$i] * 3;
                }
              else{
                $XDigito += $XBar[$i];
            }
        }

        $XDigito = $XDigito % 10;

    }

    public function imprimir_pdf($id, $nrodoc){

        $turno =  DB::select('SELECT mm_turnos.id_turno, mm_turno_det.id_comprobante, tab_tramites.tramite, DATE_FORMAT( mm_turnos.fecha,"%d/%m/%Y") AS fecha, mm_turnos.hora, mm_turnos.Nro_turno, mm_turno_det.tipo_doc, FORMAT(mm_turno_det.nro_doc, 0, "de_DE") AS nro_doc, mm_turno_det.apellido, mm_turno_det.nombre, mm_turno_det.domicilio_calle, mm_turno_det.domicilio_nro, mm_turno_det.domicilio_subnro, mm_turno_det.domicilio_piso, mm_turno_det.domicilio_dpto, mm_turno_det.domicilio_mzna, mm_turno_det.telefono, mm_turno_det.email, mm_turnos.Fecha_mov , mm_turno_det.id_comprobante, mm_turno_det.Fecha_mov, DATE_FORMAT(mm_turno_det.Fecha_mov, "%d/%m/%Y") as fecha_emision, DATE_FORMAT(mm_turno_det.Fecha_mov, "%H:%i") as hora_emision
        FROM mm_turnos
        INNER JOIN mm_turno_det ON mm_turnos.id_turno = mm_turno_det.id_turno
        INNER JOIN tab_tramites ON mm_turno_det.id_tramite = tab_tramites.id_tramite
        WHERE mm_turno_det.id_comprobante = '.$id.' and mm_turno_det.nro_doc = '.$nrodoc);
        if ($turno){
            
            $date = date('Y-m-d');

            $domicilio = $this->cargadom($turno[0]->domicilio_calle, $turno[0]->domicilio_nro, $turno[0]->domicilio_subnro, $turno[0]->domicilio_piso, $turno[0]->domicilio_dpto, $turno[0]->domicilio_mzna);

            $xmail = $turno[0]->email;
            $xid = $id;
            $xndoc = $nrodoc;


            $pdf = PDF::loadView('boleta.comprobante', compact('turno', 'date','domicilio'));

            return $pdf->download('comprobanteTurno.pdf');
        }
    }
}