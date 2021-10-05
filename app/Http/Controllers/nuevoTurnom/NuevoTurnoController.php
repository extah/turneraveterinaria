<?php

namespace App\Http\Controllers\nuevoTurnom;
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

class NuevoTurnoController extends Controller
{

	public function index(Request $request){

	    $inicio = "";    
	    $tarmites =  DB::select("SELECT tab_tramites.* FROM tab_tramites ORDER BY tab_tramites.id_tramite ASC");

    	return view('nuevoTurnom.nuevoturno', compact('inicio','tarmites'));
    }

}