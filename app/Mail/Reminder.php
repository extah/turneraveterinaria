<?php
//https://mattstauffer.co/blog/introducing-mailables-in-laravel-5-3
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use Auth;
use DB;

class Reminder extends Mailable
{
    use Queueable, SerializesModels;
    protected  $xmail;
    protected  $xid;
    protected  $xndoc;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($xmail, $xid, $xndoc)
    {
        $this->xmail = $xmail;
        $this->xid = $xid;
        $this->xndoc = $xndoc;
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        

        $turno =  DB::select('SELECT mm_turnos.id_turno, mm_turno_det.id_comprobante, tab_tramites.tramite, DATE_FORMAT( mm_turnos.fecha,"%d/%m/%Y") AS fecha, mm_turnos.hora, mm_turnos.Nro_turno, mm_turno_det.tipo_doc, FORMAT(mm_turno_det.nro_doc, 0, "de_DE") AS nro_doc, mm_turno_det.apellido, mm_turno_det.nombre, mm_turno_det.domicilio_calle, mm_turno_det.domicilio_nro, mm_turno_det.domicilio_subnro, mm_turno_det.domicilio_piso, mm_turno_det.domicilio_dpto, mm_turno_det.domicilio_mzna, mm_turno_det.telefono, mm_turno_det.email, mm_turnos.Fecha_mov , mm_turno_det.id_comprobante, mm_turno_det.Fecha_mov, DATE_FORMAT(mm_turno_det.Fecha_mov, "%d/%m/%Y") as fecha_emision, DATE_FORMAT(mm_turno_det.Fecha_mov, "%H:%i") as hora_emision
            FROM mm_turnos
            INNER JOIN mm_turno_det ON mm_turnos.id_turno = mm_turno_det.id_turno
            INNER JOIN tab_tramites ON mm_turno_det.id_tramite = tab_tramites.id_tramite
            WHERE mm_turno_det.id_comprobante = '.$this->xid.' and mm_turno_det.nro_doc = '.$this->xndoc);
            //WHERE mm_turnos.id_turno = '.$this->xid.' and mm_turno_det.nro_doc ='.$this->xndoc);

        $domicilio = $this->cargadom($turno[0]->domicilio_calle, $turno[0]->domicilio_nro, $turno[0]->domicilio_subnro, $turno[0]->domicilio_piso, $turno[0]->domicilio_dpto, $turno[0]->domicilio_mzna);

        //return $this->view('view.name');
        return $this->from('noreply@berisso.gov.ar', 'Municipalidad de Berisso')
        ->subject('TURNO MUNICIPALIDAD DE BERISSO')
        ->view('email.mail')
        ->with(['turno' => $turno, 'domicilio' => $domicilio]); 

      
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
}
