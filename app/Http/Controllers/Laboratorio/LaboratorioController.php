<?php

namespace App\Http\Controllers\Laboratorio;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LaboratorioController extends Controller
{
    //
    public function index(){

    	return view('laboratorio.laboratorio');
    
    }
}
