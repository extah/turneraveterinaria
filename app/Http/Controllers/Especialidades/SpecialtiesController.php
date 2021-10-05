<?php

namespace App\Http\Controllers\Especialidades;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests;


class SpecialtiesController extends Controller
{
    public function specialties(){
        
    	return view('especialidades.especialidades');
    
    }
}
