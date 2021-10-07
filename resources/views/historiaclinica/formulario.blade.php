@extends('template/template')

@section('css')
            <link href="{{ asset('/assets/bootstrap-datepicker-1.7.1/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>
            <link rel="stylesheet" href="{{ asset('css/barrapasoYcirculo.css') }}">

            <style>
 
                </style>
@endsection

@section('content')

    <article class="container col-12 mx-auto"> 
        <br>
        <div class="container col-6 mx-auto">
            <div class="card text-black bg-info mb-3" style="max-width: 100rem;">
                {{-- <div class="card-header">Header</div> --}}
                <div class="card-body text-Black text-center">
                  <h4 class="card-title">Ciudad: Berisso</h4>
                  {{-- <h2 class="card-title">Berisso</h2> --}}
                  {{-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> --}}
                </div>                  
            </div>
            
        </div>
        <p class="" style="">Por favor completá los siguientes datos. Todos los campos con * son obligatorios.</p>
        <div class="form-group">
            <div class="my-2 pb-1 barrapaso-uno" id="barra1"></div>    
        </div>

        <form class="row g-3">
            <div class="col-12 text-center" >
                <div class="circulo uno" id="numeral1"><h3>1</h3></div>
                <h2 style="color: #183a68;"><u>Datos del propietario</u></h2>
            </div>
            <div class="col-md-6">
                <label for="apellido" class="form-label"><b>Apellido</b></label>
                <input type="text" class="form-control" id="apellido" placeholder="ingrese su apellido">
            </div>
            <div class="col-md-6">
                <label for="nombre" class="form-label"><b>Nombre</b></label>
                <input type="text" class="form-control" id="nombre" placeholder="ingrese su nombre">
            </div>
            <div class="col-md-6">
                <label for="edad" class="form-label"><b>Edad</b></label>
                <input type="number" class="form-control" id="edad" placeholder="ingrese su edad">
            </div>
            <div class="col-md-6">
                <label for="dni" class="form-label"><b>DNI</b></label>
                <input type="number" class="form-control" id="dni" placeholder="ingrese su dni">
            </div>
            <div class="col-md-4">
                <label for="ciudad" class="form-label"><b>Ciudad</b></label>
                <input type="text" class="form-control" id="ciudad" value="Berisso" readonly>
            </div>
            <div class="col-md-4">
                <label for="barrio" class="form-label"><b>Barrio</b></label>
                <select id="barrio" class="form-select">
                <option selected>Elegir...</option>
                <option>...</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="cod_postal" class="form-label"><b>Codigo Postal</b></label>
                <input type="text" class="form-control" id="cod_postal" value="1923" placeholder="ingrese su codigo postal">
            </div>
            <div class="col-md-4">
                <label for="calle" class="form-label"><b>Calle</b></label>
                <input type="text" class="form-control" id="calle" placeholder="ingrese su calle">
            </div>
            <div class="col-md-3">
                <label for="numero" class="form-label"><b>Número</b></label>
                <input type="text" class="form-control" id="numero" placeholder="ingrese su N° de domicilio">
            </div>
            <div class="col-md-3">
                <label for="barrio" class="form-label"><b>Barrio</b></label>
                <input type="text" class="form-control" id="barrio" placeholder="ingrese su barrio">
            </div>
            <div class="col-md-2">
                <label for="manzana" class="form-label"><b>Manzana</b></label>
                <input type="text" class="form-control" id="manzana" placeholder="ingrese su manzana">
            </div>

            <div class="form-group">    
                <div class="my-2 pb-1 barrapaso-dos" id="barra2"></div>        
            </div>

            <div class="col-12 text-center">
                <div class="circulo dos" id="numeral2"><h3>2</h3></div>
                <h2 style="color: #183a68;"><u>Datos del animal</u></h2>
            </div>
            <div class="col-md-4">
                <label for="especie" class="form-label"><b>Especie</b></label>
                <select id="especie" class="form-select" onchange="showDiv('interes_sanitario', this)">
                    <option selected>Elegir...</option>
                    <option value="ave">Ave</option>
                    <option value="canino">Canino</option>
                    <option value="conejo">Conejo</option>
                    <option value="felino">Felino</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="nom_animal" class="form-label"><b>Nombre</b></label>
                <input type="text" class="form-control" id="nom_animal" placeholder="ingrese el nombre de su mascota">
            </div>
            <div class="col-md-2">
                <label for="edad_animal" class="form-label"><b>Edad</b></label>
                <input type="number" class="form-control" id="edad_animal" placeholder="ingrese la edad">
            </div>
            <div class="col-md-2">
                <label for="sexo" class="form-label"><b>Sexo</b></label>
                <select id="sexo" class="form-select" onchange="showDiv('interes_sanitario', this)">
                    <option selected>Elegir...</option>
                    <option value="hembra">Hembra</option>
                    <option value="macho">Macho</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="vacuna_antirrabica" class="form-label"><b>Recibió vacuna antirrábica el último año</b></label>
                <select id="vacuna_antirrabica" class="form-select">
                    <option selected>Elegir...</option>
                    <option>SI</option>
                    <option>NO</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="vacuna_sextuple" class="form-label"><b>Recibió vacuna sextuple/triple el último año</b></label>
                <select id="vacuna_sextuple" class="form-select">
                    <option selected>Elegir...</option>
                    <option>SI</option>
                    <option>NO</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="castrado" class="form-label"><b>Castrado</b></label>
                <select id="castrado" class="form-select">
                    <option selected>Elegir...</option>
                    <option>SI</option>
                    <option>NO</option>
                </select>
            </div>

            <!-- Preguntas sanitarias -->
            <!-- CANINO -->

            <div class="container" id="interes_sanitario" style="display : none">
                <div class="form-group">
                    <div class="my-2 pb-1 barrapaso-tres" id="barra3"></div>
                </div>
                <div class="col-12 text-center">
                    <div class="circulo tres" id="numeral4"><H3>3</H3></div>
                    <h2 style="color: #183a68;"><u>Preguntas de interés sanitario</u></h2>
                </div>
                <br>
                <div class="col-12">
                    <h4 style="color: #f74525"><u>Brucelosis</u></h4>
                </div>
                {{-- <br> --}}
                <div class="row" id="canino_hembra" style="display: none">
                    <br>
                    <h6>*Canino hembra</h6>
                    <div class="col-md-8">
                        <label for="vacuna_sextuple" class="form-label"><b>¿Se cruzó alguna vez con algún macho intencionalmente o por accidente?</b></label>
                        <select id="vacuna_sextuple" class="form-select">
                            <option selected>Elegir...</option>
                            <option>SI</option>
                            <option>NO</option>
                        </select>
                    </div>    
                    <div class="col-md-8">
                        <label for="vacuna_sextuple" class="form-label"><b>¿Quedó preñada alguna vez?</b></label>
                        <select id="vacuna_sextuple" class="form-select">
                            <option selected>Elegir...</option>
                            <option>SI</option>
                            <option>NO</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label for="vacuna_sextuple" class="form-label"><b>¿Tuvo crías?</b></label>
                        <select id="vacuna_sextuple" class="form-select">
                            <option selected>Elegir...</option>
                            <option>SI</option>
                            <option>NO</option>
                        </select>
                    </div>    
                    <div class="col-md-8">
                        <label for="problema_parto" class="form-label"><b>¿Tuvo problemas de parto, crías muertas o débiles y murieron luego de nacer?</b></label>
                        <input type="text" class="form-control" id="problema_parto">
                    </div>

                </div>
                {{-- <br> --}}
                <div class="row" id="canino_macho" style="display: none">
                    <br>
                    <h6>*Canino macho</h6>
                    <div class="col-md-8">
                        <label for="vacuna_sextuple" class="form-label"><b>¿Dio servicio o lo cruzo alguna vez con una hembra?</b></label>
                        <select id="vacuna_sextuple" class="form-select">
                            <option selected>Elegir...</option>
                            <option>SI</option>
                            <option>NO</option>
                        </select>
                    </div>    
                    <div class="col-md-8">
                        <label for="vacuna_sextuple" class="form-label"><b>Si dio servicios, ¿Logró la preñez de la hembra?</b></label>
                        <select id="vacuna_sextuple" class="form-select">
                            <option selected>Elegir...</option>
                            <option>SI</option>
                            <option>NO</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label for="vacuna_sextuple" class="form-label"><b>¿Tuvo o tiene inflamación de testículos, se lame o se lastima la zona?</b></label>
                        <select id="vacuna_sextuple" class="form-select">
                            <option selected>Elegir...</option>
                            <option>SI</option>
                            <option>NO</option>
                        </select>
                    </div>    
                </div>
                <br>
                <div class="col-12">
                    <h6>*Canino sin importar sexo</h6>
                    <div class="col-md-8">
                        <label for="vacuna_sextuple" class="form-label"><b>¿Dificultad para caminar, dolor en la columna, se niega a subir escalones o a sillones o camas?</b></label>
                        <select id="vacuna_sextuple" class="form-select">
                            <option selected>Elegir...</option>
                            <option>SI</option>
                            <option>NO</option>
                        </select>
                    </div>     
                </div>
                <br>
                <div class="col-12">
                    <h4 style="color: #f74525"><u>Leptospirosis</u></h4>
 
                </div>
                <br>
                <div class="col-md-8">
                        <label for="vacuna_sextuple" class="form-label"><b>¿Es un animal comprado en un criadero?</b></label>
                        <select id="vacuna_sextuple" class="form-select">
                            <option selected>Elegir...</option>
                            <option>SI</option>
                            <option>NO</option>
                        </select>
                </div> 
                <div class="col-md-8">
                        <label for="vacuna_sextuple" class="form-label"><b>¿El perro proviene o viajo alguna vez de otra provincia o pais?</b></label>
                        <select id="vacuna_sextuple" class="form-select">
                            <option selected>Elegir...</option>
                            <option>SI</option>
                            <option>NO</option>
                        </select>
                </div> 
                <br>

            </div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary btn-lg">Reservar Turno</button>
            </div>
        </form>
        <br>
        
    </article>

@endsection

@section('js')
<script src="{{ asset('/assets/bootstrap-datepicker-1.7.1/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js') }}"></script>

<!-- <script>
	$('#fecha_hasta').datepicker({
		uiLibrary: 'bootstrap4',
    format: "mm/yyyy",
    startView: "year", 
    minViewMode: "months",
		locale: 'es',
		language: 'es',
		autoclose: true,
		todayHighlight: true,
		// startDate: sumarDias(new Date()),
	});
	$('#fecha_hasta').datepicker("setDate", new Date());

	function sumarDias(fecha){
			fecha.setDate(fecha.getDate());
			return fecha;
		}

	
</script> -->
<!-- <script>
	$('#fecha_desde').datepicker({
		uiLibrary: 'bootstrap4',
    format: "mm/yyyy",
    startView: "year", 
    minViewMode: "months",
		locale: 'es',
		language: 'es',
		autoclose: true,
		todayHighlight: true,
		// startDate: sumarDias(new Date()),
	});
	$('#fecha_desde').datepicker("setDate", new Date());

	function sumarDias(fecha){
			fecha.setDate(fecha.getDate());
			return fecha;
		}

	
</script> -->
<script>
function showDiv(divId, element)
{
    var varCanino = document.getElementById("especie").value;
    var varSexo = document.getElementById("sexo").value;
    var hembra = document.getElementById("canino_hembra");
    var macho = document.getElementById("canino_macho");
    var interes_sanitario =  document.getElementById("interes_sanitario");

    if (varCanino == "canino") 
    { 
        // alert(varCanino);
        if(varSexo == "hembra") 
        {
            macho.style.display = "none";
            document.getElementById(divId).style.display = 'block';
            hembra.style.display = "block";
        }
        else if(varSexo == "macho")
        {
            hembra.style.display = "none";
            document.getElementById(divId).style.display = 'block';
            macho.style.display = "block";
        }
        else
        {
            document.getElementById(divId).style.display = 'none';
        }
       
    }
    else { 
        document.getElementById(divId).style.display = 'none';
    }

    // document.getElementById(divId).style.display = element.value == 1 ? 'block' : 'none';
}
</script>
<script>

(function () {
  'use strict'

  var forms = document.querySelectorAll('.needs-validation')

  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()
  </script>


@endsection