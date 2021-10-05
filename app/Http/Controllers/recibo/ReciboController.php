<?php

namespace App\Http\Controllers\recibo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReciboController extends Controller
{
    //
    public function index(Request $request){

	    $inicio = "";
		$esEmp = true;
        $cuix = "20367384515";
        $nombre = "Emmanuel Baleztena";
	   
    	return view('recibo.recibo', compact('inicio', 'esEmp', 'cuix', 'nombre'));
    }
}
