@extends('template/template')

@section('css')
<link href="{{ asset('/css/formulario.css') }}" rel="stylesheet">
<!-- <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet"> -->



<!-- <link href="{{ asset('/assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet"> -->
<link href="{{ asset('/css/turnero.css') }}" rel="stylesheet">
<link href="{{ asset('/css/sweetalert.css') }}" rel="stylesheet">


<link href='{{ asset("css/sweetalert.css") }}' rel="stylesheet">
<link href="{{ asset('/assets/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('/assets/toastr/toastr.min.css') }}" rel="stylesheet">

<link href="{{ asset('/assets/bootstrap-datepicker-1.7.1/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>
<style type="text/css">
 
 .btn_personalizado{
  text-decoration: none;
  padding: 10px;
  font-weight: 600;
  font-size: 20px;
  color: #ffffff;
  background-color: #1883ba;
  border-radius: 6px;
  border: 1px solid #0016b0;
}
.formItem{
  display: block;
  text-align: center;
  line-height: 150%;
  /* font-size: .85em; */
}
</style>
@endsection

@section('content')

<div class="container">

    <button id="paso2" class="btn_personalizado"><b>2/3</b></button>
    <button id="paso3"  style="display: none" class="btn_personalizado"><b>3/3</b></button>
    <!-- <div id="sel_horario" class="form-group col-md-12" style="text-align:center;">
            
            <h1 style="color:#428bca">Seleccionar Horario</h1>
    </div> -->
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
                            {{-- <option selected="selected" >Seleccioná un horario</option> --}}
                            <!-- <option value="">-Seleccioná un trámite-</option> -->
                            @foreach($turnos as $turno)
                                <option value="{{ $turno->id_turno }}" offset="1">{{ $turno->hora }}</option>        
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
</div>
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
(() => {
  'use strict';

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation');

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms).forEach((form) => {
    form.addEventListener('submit', (event) => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();
</script>

@endsection