<?php

namespace App\Http\Controllers\Inicio;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use Auth;
use DB;
use URL;
use Redirect; 


class InicioController extends Controller
{

	public function index(Request $request){

		// $id = $request->session->id;
		// $id = $request->session()->get('id');
		
		// dd($id);
		// dd($request);
		// session(['session'=>$usuario]);
	    $inicio = "";
		$esEmp = false;
		$cuix = "";
		$status_info = "";
	   
    	return view('inicio.inicio', compact('inicio', 'esEmp', 'status_info'));
    }



}