@extends('template/template')

@section('css')
<!-- <link href="{{ asset('/css/formulario.css') }}" rel="stylesheet"> -->
<!-- <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet"> -->



<!-- <link href="{{ asset('/assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet"> -->
<!-- <link href="{{ asset('/css/turnero.css') }}" rel="stylesheet"> -->
<!-- <link href="{{ asset('/css/sweetalert.css') }}" rel="stylesheet">


<link href='{{ asset("css/sweetalert.css") }}' rel="stylesheet">
<link href="{{ asset('/assets/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('/assets/toastr/toastr.min.css') }}" rel="stylesheet">

<link href="{{ asset('/assets/bootstrap-datepicker-1.7.1/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/> -->
<link rel="stylesheet" href="{{ asset('css/barrapasoYcirculo.css') }}">

<style type="text/css">
 
 /* .btn_personalizado{
  text-decoration: none;
  padding: 10px;
  font-weight: 600;
  font-size: 20px;
  color: #ffffff;
  background-color: #1883ba;
  border-radius: 6px;
  border: 1px solid #0016b0;
} */
.formItem{
  display: block;
  text-align: center;
  line-height: 150%;
}
</style>
@endsection

@section('content')
<br><br>
<div class="container">

		<div class="container col-6 mx-auto" id="sel_horario">
            <div class="card text-black bg-info mb-3" style="max-width: 100rem;">
                <div class="card-body text-Black text-center">
                  <h4 class="card-title">Buscar turnos por barrio</h4>
                </div>                  
            </div>
            
        </div>

        <form onsubmit="return miFuncion(this)" id="demoForm" class="needs-validation" novalidate method="post" action="{{ url('nuevoturno/turnoconfirmado')  }}">
            {{ csrf_field() }}
            <div id="horario"  class="">
                    <div class="form-group">
                        <div class="my-2 pb-1 barrapaso-uno" id="barra1"></div>    
                    </div>
                <div class="col col-sm-8 col-md-8 col-lg-8 col-xl-3 mx-auto">

                    <div class="form-group">
                        <label class="formItem" for="select_turno"> <b>Horario disponible</b></label>
                        <select name="select_turno" id="select_turno" class="form-control" required>
                            @foreach($turnos as $turno)
                                <option value="{{ $turno->id }}" offset="1">{{ $turno->hora }}</option>        
                            @endforeach
                        </select>
                    </div>
                    <br>
                    <div id="formulario" class="row d-flex justify-content-center">
                        <input type="button" id="visibilityHidden" class='btn btn-primary btn-lg' value="Siguiente">
                    </div>
                </div>
                
            </div>

            <!-- <label>&nbsp;</label> -->

            <div id="hide-me"  style="display: none">
                <div class="container col-6 mx-auto">
                    <div class="card text-black bg-info mb-3" style="max-width: 100rem;">
                        <div class="card-body text-Black text-center">
                            <h4 class="card-title">Ciudad: Berisso</h4>
                        </div>                  
                    </div>
                            
                </div>
                <p class="" style="">Por favor completá los siguientes datos. Todos los campos con * son obligatorios.</p>
                <div class="form-group">
                    <div class="my-2 pb-1 barrapaso-uno" id="barra1"></div>    
                </div>

                <div class="row g-3">
                    <div class="col-12 text-center" >
                        <div class="circulo uno" id="numeral1"><h3>1</h3></div>
                        <h2 style="color: #183a68;"><u>Datos del propietario</u></h2>
                    </div>
                    <div class="col-md-6">
                        <label for="apellido" class="form-label"><b>Apellido</b></label>
                        <input type="text" class="form-control" id="apellido" placeholder="ingrese su apellido" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nombre" class="form-label"><b>Nombre</b></label>
                        <input type="text" class="form-control" id="nombre" placeholder="ingrese su nombre" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edad" class="form-label"><b>Edad</b></label>
                        <input type="number" class="form-control" id="edad" placeholder="ingrese su edad" required>
                    </div>
                    <div class="col-md-6">
                        <label for="dni" class="form-label"><b>DNI</b></label>
                        <input type="number" class="form-control" id="dni" placeholder="ingrese su dni" required>
                    </div>
                    <div class="col-md-4">
                        <label for="ciudad" class="form-label"><b>Ciudad</b></label>
                        <input type="text" class="form-control" id="ciudad" value="Berisso" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="barrio" class="form-label"><b>Barrio</b></label>
                        <select id="barrio" class="form-select" required>
                            <option selected disabled value="">elegir...</option>
                            <option>...</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="cod_postal" class="form-label"><b>Codigo Postal</b></label>
                        <input type="text" class="form-control" id="cod_postal" value="1923" placeholder="ingrese su codigo postal" required>
                    </div>
                    <div class="col-md-4">
                        <label for="calle" class="form-label"><b>Calle</b></label>
                        <input type="text" class="form-control" id="calle" placeholder="ingrese su calle" required>
                    </div>
                    <div class="col-md-3">
                        <label for="numero" class="form-label"><b>Número</b></label>
                        <input type="text" class="form-control" id="numero" placeholder="ingrese su N° de domicilio" required>
                    </div>
                    <div class="col-md-3">
                        <label for="barrio" class="form-label"><b>Barrio</b></label>
                        <input type="text" class="form-control" id="barrio" placeholder="ingrese su barrio" required>
                    </div>
                    <div class="col-md-2">
                        <label for="manzana" class="form-label"><b>Manzana</b></label>
                        <input type="text" class="form-control" id="manzana" placeholder="ingrese su manzana" required>
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
                        <select id="especie" class="form-select" onchange="showDiv('interes_sanitario', this)" required>
                            <option selected disabled value="">elegir...</option>
                            <option value="ave">Ave</option>
                            <option value="canino">Canino</option>
                            <option value="conejo">Conejo</option>
                            <option value="felino">Felino</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="nom_animal" class="form-label"><b>Nombre</b></label>
                        <input type="text" class="form-control" id="nom_animal" placeholder="ingrese el nombre de su mascota" required>
                    </div>
                    <div class="col-md-2">
                        <label for="edad_animal" class="form-label"><b>Edad</b></label>
                        <input type="number" class="form-control" id="edad_animal" placeholder="ingrese la edad" required>
                    </div>
                    <div class="col-md-2">
                        <label for="sexo" class="form-label"><b>Sexo</b></label>
                        <select id="sexo" class="form-select" onchange="showDiv('interes_sanitario', this)" required>
                            <option selected disabled value="">elegir...</option>
                            <option value="hembra">Hembra</option>
                            <option value="macho">Macho</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="vacuna_antirrabica" class="form-label"><b>Recibió vacuna antirrábica el último año</b></label>
                        <select id="vacuna_antirrabica" class="form-select" required>
                            
                                    <option>NO</option>
                                    <option>SI</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="vacuna_sextuple" class="form-label"><b>Recibió vacuna sextuple/triple el último año</b></label>
                        <select id="vacuna_sextuple" class="form-select" required>
                            
                                    <option>NO</option>
                                    <option>SI</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="castrado" class="form-label"><b>Castrado</b></label>
                        <select id="castrado" class="form-select" required>
                            
                                    <option>NO</option>
                                    <option>SI</option>
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
                        <div class="row" id="canino_hembra" style="display: none">
                            <br>
                            <h6>*Canino hembra</h6>
                            <div class="col-md-8">
                                <label for="vacuna_sextuple" class="form-label"><b>¿Se cruzó alguna vez con algún macho intencionalmente o por accidente?</b></label>
                                <select id="vacuna_sextuple" class="form-select" required>
                                    
                                    <option>NO</option>
                                    <option>SI</option>
                                </select>
                            </div>    
                            <div class="col-md-8">
                                <label for="vacuna_sextuple" class="form-label"><b>¿Quedó preñada alguna vez?</b></label>
                                <select id="vacuna_sextuple" class="form-select" required>
                                    
                                    <option>NO</option>
                                    <option>SI</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label for="vacuna_sextuple" class="form-label"><b>¿Tuvo crías?</b></label>
                                <select id="vacuna_sextuple" class="form-select" required>
                                    
                                    <option>NO</option>
                                    <option>SI</option>
                                </select>
                            </div>    
                            <div class="col-md-8">
                                <label for="problema_parto" class="form-label"><b>¿Tuvo problemas de parto, crías muertas o débiles y murieron luego de nacer?</b></label>
                                <input type="text" class="form-control" id="problema_parto">
                            </div>

                        </div>
                        
                        <div class="row" id="canino_macho" style="display: none">
                            <br>
                            <h6>*Canino macho</h6>
                            <div class="col-md-8">
                                <label for="vacuna_sextuple" class="form-label"><b>¿Dio servicio o lo cruzo alguna vez con una hembra?</b></label>
                                <select id="vacuna_sextuple" class="form-select" required>
                                    
                                    <option>NO</option>
                                    <option>SI</option>
                                </select>
                            </div>    
                            <div class="col-md-8">
                                <label for="vacuna_sextuple" class="form-label"><b>Si dio servicios, ¿Logró la preñez de la hembra?</b></label>
                                <select id="vacuna_sextuple" class="form-select" required>
                                    
                                    <option>NO</option>
                                    <option>SI</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label for="vacuna_sextuple" class="form-label"><b>¿Tuvo o tiene inflamación de testículos, se lame o se lastima la zona?</b></label>
                                <select id="vacuna_sextuple" class="form-select" required>
                                    
                                    <option>NO</option>
                                    <option>SI</option>
                                </select>
                            </div>    
                        </div>
                        <br>
                        <div class="col-12">
                            <h6>*Canino sin importar sexo</h6>
                            <div class="col-md-8">
                                <label for="vacuna_sextuple" class="form-label"><b>¿Dificultad para caminar, dolor en la columna, se niega a subir escalones o a sillones o camas?</b></label>
                                <select id="vacuna_sextuple" class="form-select" required>
                                    
                                    <option>NO</option>
                                    <option>SI</option>
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
                                <select id="vacuna_sextuple" class="form-select" required>
                                    
                                    <option>NO</option>
                                    <option>SI</option>
                                </select>
                        </div> 
                        <div class="col-md-8">
                                <label for="vacuna_sextuple" class="form-label"><b>¿El perro proviene o viajo alguna vez de otra provincia o pais?</b></label>
                                <select id="vacuna_sextuple" class="form-select" required>
                                    
                                    <option>NO</option>
                                    <option>SI</option>
                                </select>
                        </div> 
                        <br>

                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Reservar Turno</button>
                    </div>
                </div>
            </div>            

        </form>

</div>
<br>
<br>
<!-- <div class="container">

    <button id="paso2" class="btn_personalizado"><b>2/3</b></button>
    <button id="paso3"  style="display: none" class="btn_personalizado"><b>3/3</b></button>
    <div id="sel_horario" class="justify-content-center" style="text-align:center;">
        <h1 style="color:#428bca">Seleccionar Horario</h1>
    </div>
    <div id="datos_personales" class="justify-content-center" style="text-align:center; display: none" >
        <h1 style="color:#428bca">Datos Personales</h1>
    </div>

    <hr>
        
    <form onsubmit="return miFuncion(this)" id="demoForm" class="needs-validation" novalidate method="post" action="{{ url('nuevoTurno/turnoConfirmado')  }}" data-toggle="validator" role="form" >
        {{ csrf_field() }}
        <div class="row justify-content-center align-items-center h-100">
            <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div id="horario">
                    <div class="form-group">
                        <label class="formItem" for="select_turno"> <b>Horario disponible</b></label>
                        <select name="select_turno" id="select_turno" class="form-control" required>
                            @foreach($turnos as $turno)
                                <option value="{{ $turno->id }}" offset="1">{{ $turno->hora }}</option>        
                            @endforeach
                        </select>
                    </div>
                    <div id="formulario" class="row d-flex justify-content-center">
                        <input type="button" id="visibilityHidden" class='btn btn-primary btn-lg' value="Siguiente">
                    </div>
                </div>
            </div>	
        </div>

        <div id="hide-me"  style="display: none">
            <div class="row">
                    <div class="form-group col-md-4">
                        <label class="formItem" for="nombre"><b>Nombre</b></label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
                        <div class="invalid-feedback">Ingresa tu nombre</div>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="formItem" for="apellido"><b>Apellido</b> </label>
                        <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" required>
                        <div class="invalid-feedback">Ingresa tu apellido</div>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="formItem" for="tipo_doc"><b>Tipo de Documento</b></label>
                        <select name="tipo_doc" id="tipo_doc" class="form-control" required>
                                {{-- <option selected="selected" >Seleccioná un tipo</option> --}}
                                <option value="">-Seleccionár el tipo-</option>
                                <option value="DE">DE</option>
                                <option value="DNI">DNI</option>
                                <option value="LC">LC</option>
                                <option value="LE">LE</option>
                            </select>
                            <div class="invalid-feedback">Selecciona un tipo de documento</div>
                    </div>
            </div>
            <div class="row">
                    <div class="form-group col-md-4">
                        <label class="formItem" for="nro_documento"><b>N° de Documento</b></label>
                        <input type="number" class="form-control" id="nro_documento" name="nro_documento" placeholder="Nro documento" min="1111111" max="99999999" required>
                        <div class="invalid-feedback">Ingresa tu numero de documento</div>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="formItem" for="telefono"><b>Telefono/celular</b></label>
                        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono/celular" required>
                        <div class="invalid-feedback">Ingresa tu telefono o celular</div>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="formItem" for="email"><b>Email</b></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" required>
                        <div class="invalid-feedback">Ingresa tu email</div>
                    </div>
            </div>  
            
            <hr>
            <div class="justify-content-center" style="text-align:center" >
                 <h1 style="color:#428bca">Domicilio</h1>
            </div>
            <div class="row">
                    <div class="form-group col-md-3">
                        <label class="formItem" for="calle"><b>Calle</b></label>
                        <input type="text" class="form-control" id="calle" name="calle" placeholder="Calle" required>
                        <div class="invalid-feedback">Ingresa la calle del domicilio donde vives</div>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="formItem" for="numero"><b>Número</b></label>
                        <input type="number" class="form-control" id="numero" name="numero" placeholder="Número" required>
                        <div class="invalid-feedback">Ingresa el numero de domicilio</div>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="formItem" for="piso"><b>Piso</b></label>
                        <input type="number" class="form-control" id="piso" name="piso" placeholder="Piso">
                    </div>
                    <div class="form-group col-md-3">
                        <label class="formItem" for="depto"><b>Departamento</b></label>
                        <input type="depto" class="form-control" id="depto" name="depto" placeholder="Departamento">
                    </div>

            </div>
            <div class="row justify-content-center align-items-center h-100">
                <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">
                    <div class="form-group" >
                        <div class='g-recaptcha' data-sitekey='6LfpoScUAAAAAA2usCdAwayw_KQiHe44y5e1Whk-'></div>
                        <div id='errorRecaptcha' style='display:none; color:#a94442'require>    <span class='glyphicon glyphicon-exclamation-sign'></span>    Por favor, verifica que no seas un robot.</div>
                    </div>
                    <div class="row d-flex justify-content-center">                      
                        <button type="submit" class="btn btn-primary btn-lg">Reservar turno</button>
                    </div>
                </div>
            </div>
    </form>
</div> -->
@endsection

@section('js')

<script src='https://www.google.com/recaptcha/api.js?hl=es' async defer> </script>
<script src="{{ asset('assets/moment/moment.min.js') }}"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script src="{{ asset('/assets/bootstrap-datepicker-1.7.1/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js') }}"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->



<script src="{{ asset('/assets/formvalidation/0.6.2-dev/js/formValidation.min.js') }}"></script>
<script src="{{ asset('assets/select2/select2.full.js') }}"></script>
<script src='{{ asset("assets/toastr/toastr.min.js") }}'></script>
<script src='{{ asset("assets/sweetalert/sweet-alert.min.js") }}'></script>
<script>
	$('#fecha_turno').datepicker({
		uiLibrary: 'bootstrap4',
		format: 'yyyy-mm-dd',
		locale: 'es',
		language: 'es',
		autoclose: true,
		todayHighlight: true,
		startDate: sumarDias(new Date()),
		//   endDate: new Date(),
	});
	$('#fecha_turno').datepicker("setDate", sumarDias(new Date()));

	function sumarDias(fecha){
			fecha.setDate(fecha.getDate());
			return fecha;
		}

	
</script>
<script>
        var select = document.getElementById('select_turno');
	        select.addEventListener('change', function(evt) {
	        this.setCustomValidity('');
	    });
	    select.addEventListener('invalid', function(evt) {
	    // Required
	    if (this.validity.valueMissing) {
		    this.setCustomValidity('Por favor seleccione un turno!');
	    }
	    });
        
</script>
<script>
    $('#visibilityHidden').click(function(e) {
        var cod = document.getElementById("select_turno").value;
        
        if(cod != "")
        {
            $('#hide-me').css('display', 'block');
            $("#horario").hide();
            $("#sel_horario").hide();
            $("#paso2").hide();
            $("#paso3").show();
            $("#datos_personales").show();
            $("#hide-me").show();
            
        }
        else{
        }
    });
</script>
<script>
function miFuncion(a) {
    var response = grecaptcha.getResponse();
    if(response.length == 0){
        // alert("Captcha no verificado");
        
        $("#errorRecaptcha").show();
        toastr.error("validar reCAPTCHA", 'VERIFICA QUE NO SOS UN ROBOT', {
                    // "progressBar": true,
                    "closeButton": true,
                    "positionClass": "toast-bottom-right",
                    "timeOut": "10000",
                });  
        return false;
      event.preventDefault();
    } else {
    //   alert("Captcha verificado");
      return true;
    }
  }
</script>

<script>
(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
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

@endsection