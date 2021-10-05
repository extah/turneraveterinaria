<?php

namespace App\Http\Controllers\historiaclinica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HistoriaClinicaController extends Controller
{
    //
    public function index(Request $request)
    {
        # code...
        $esEmp = false;
        return view('historiaclinica.formulario', compact('esEmp'));
    }
}
