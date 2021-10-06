@extends('template/template')

@section('css')


            <!-- <link rel="stylesheet" href="{{ asset('css/login.css') }}"> -->
            <link href="{{ asset('/assets/bootstrap-datepicker-1.7.1/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>

@endsection

@section('content')

    <article class="container col-12 mx-auto"> 

        <form class="row g-3">
            <div class="col-12 text-center" >
                <h2 style="color: #183a68;"><u>Datos del propietario</u></h2>
            </div>
            <div class="col-md-6">
                <label for="apellido" class="form-label"><b>Apellido</b></label>
                <input type="text" class="form-control" id="apellido">
            </div>
            <div class="col-md-6">
                <label for="nombre" class="form-label"><b>Nombre</b></label>
                <input type="text" class="form-control" id="nombre">
            </div>
            <div class="col-md-6">
                <label for="edad" class="form-label"><b>Edad</b></label>
                <input type="number" class="form-control" id="edad">
            </div>
            <div class="col-md-6">
                <label for="dni" class="form-label"><b>DNI</b></label>
                <input type="number" class="form-control" id="dni">
            </div>
            <!-- <div class="col-12">
                <label for="inputAddress" class="form-label">Address</label>
                <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
            </div> -->

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
                <input type="text" class="form-control" id="cod_postal" value="1923">
            </div>
            <div class="col-md-4">
                <label for="calle" class="form-label"><b>Calle</b></label>
                <input type="text" class="form-control" id="calle">
            </div>
            <div class="col-md-2">
                <label for="numero" class="form-label"><b>Número</b></label>
                <input type="text" class="form-control" id="numero">
            </div>
            <div class="col-md-2">
                <label for="barrio" class="form-label"><b>Barrio</b></label>
                <input type="text" class="form-control" id="barrio">
            </div>
            <div class="col-md-2">
                <label for="manzana" class="form-label"><b>Manzana</b></label>
                <input type="text" class="form-control" id="manzana">
            </div>

            <hr style="height:4px;border-width:0;background-color:blue;">

            <div class="col-12 text-center">
                <h2 style="color: #183a68;"><u>Datos del animal</u></h2>
            </div>
            <div class="col-md-4">
                <label for="especie" class="form-label"><b>Especie</b></label>
                <select id="especie" class="form-select">
                    <option selected>Elegir...</option>
                    <option>Ave</option>
                    <option>Canino</option>
                    <option>Conejo</option>
                    <option>Felino</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="nom_animal" class="form-label"><b>Nombre</b></label>
                <input type="text" class="form-control" id="nom_animal">
            </div>
            <div class="col-md-2">
                <label for="edad_animal" class="form-label"><b>Edad</b></label>
                <input type="number" class="form-control" id="edad_animal">
            </div>
            <div class="col-md-2">
                <label for="sexo" class="form-label"><b>Sexo</b></label>
                <select id="sexo" class="form-select">
                    <option selected>Elegir...</option>
                    <option>Hembra</option>
                    <option>Macho</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="vacuna_antirrabica" class="form-label"><b>Recibió vacuna antirrábica el último año</b></label>
                <select id="vacuna_antirrabica" class="form-select">
                    <option selected>Elegir...</option>
                    <option>SI</option>
                    <option>NO</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="vacuna_sextuple" class="form-label"><b>Recibió vacuna sextuple/triple el último año</b></label>
                <select id="vacuna_sextuple" class="form-select">
                    <option selected>Elegir...</option>
                    <option>SI</option>
                    <option>NO</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="castrado" class="form-label"><b>Castrado</b></label>
                <select id="castrado" class="form-select">
                    <option selected>Elegir...</option>
                    <option>SI</option>
                    <option>NO</option>
                </select>
            </div>

            <!-- Preguntas sanitarias -->
            <!-- CANINO -->

            <hr style="height:4px;border-width:0;background-color:blue;">

            <div class="container">
                <div class="col-12 text-center">
                    <h2 style="color: #183a68;"><u>Preguntas de interés sanitario</u></h2>
                </div>
                <div class="col-12">
                    <h4><u>Brucelosis</u></h4>
                </div>
                <br>
                <div class="row">
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
                <br>
                <div class="row">
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
                    <h4><u>Leptospirosis</u></h4>
 
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