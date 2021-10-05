<?php

namespace App\Http\Controllers\portaldelpaciente;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use URL;
use Redirect; 

class PortaldelpacienteController extends Controller
{
    //
    public function index(Request $request){
        // dd("hola");
        $usuario = $request->session()->get('usuario');
        $result = $this->isUsuario($usuario);

        if($result == "OK")
        {
            $inicio ="";
            $status_ok = false;
            $esPaciente = true;
            $message = "";
            return view('portaldelpaciente.portaldelpaciente', compact('inicio', 'message', 'status_ok', 'esPaciente', 'usuario'));

        }
	    $inicio = "";    
		$status_error = false;
        $esPaciente = false;
    	return view('portaldelpaciente.portaldelpacienteiniciarsesion', compact('inicio','status_error', 'esPaciente'));
    }

    function isUsuario($usuario)
    {
        # code...
        if($usuario == null)
        {
            $inicio = ""; 
            $status_error = false;
            $esPaciente = false;

            return view('portaldelpaciente.portaldelpacienteiniciarsesion', compact('inicio','status_error', 'esPaciente'));
        }
 
        return "OK";

    }
}
