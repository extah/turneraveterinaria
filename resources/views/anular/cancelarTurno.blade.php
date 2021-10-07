@extends('template/template')

@section('css')

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
		<button id="paso1" class="btn_personalizado"><b>1/2</b></button>
		<div class="d-flex justify-content-center">
        	<h1 style="color:#d1391f">Cancelar turno</h1>
    	</div>
<hr>
        <form onsubmit="return miFuncion(this)" id="demoForm" class="needs-validation" novalidate method="post" action="{{ route('cancelarTurno.buscarCancelar')  }}" data-toggle="validator" role="form">
            {{ csrf_field() }}

            <div class="row">
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
                <div class="form-group col-md-4">
                    <label class="formItem" for="nro_documento"><b>N° de documento</b></label>
                    <input type="number" class="form-control" id="nro_documento" name="nro_documento" placeholder="Ingrese su n° de documento"  min="1111111" max="99999999" required>
                    <div class="invalid-feedback">Ingresa tu numero de documento</div>
                </div>
                <div class="form-group col-md-4">
                    <label class="formItem" for="nro_comprobante"><b>N° de comprobante</b></label>
                    <input type="number" class="form-control" id="nro_comprobante" name="nro_comprobante" placeholder="ingrese su n° de comprobante" min="1" max="99999999" required>
                    <div class="invalid-feedback">Ingresa tu numero de comprobante</div>
                </div>

            </div>
            <div class="row">
                    <div class="form-group col-md-4" >
                        <div class='g-recaptcha' data-sitekey='6LfpoScUAAAAAA2usCdAwayw_KQiHe44y5e1Whk-'></div>
                        <div id='errorRecaptcha' style='display:none; color:#a94442'require>    <span class='glyphicon glyphicon-exclamation-sign'></span>    Por favor, verifica que no seas un robot.</div>
                    </div>
            </div>
            <div class="row d-flex justify-content-center">  
                    <input type="submit" class='btn btn-danger btn-lg' value="Cancelar Turno">
                </div>
            </div>

            <!-- <div class="row">   
                <div class="">                      
                        <button type="submit" class="btn btn-primary">Buscar Turnos</button>
                </div>
            </div>   -->


        </form>

</div>
@endsection

@section('js')

<script src='https://www.google.com/recaptcha/api.js?hl=es' async defer> </script>
<script src="{{ asset('assets/moment/moment.min.js') }}"></script>
<script src="{{ asset('/assets/bootstrap-datepicker-1.7.1/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js') }}"></script>
<script src="{{ asset('/assets/formvalidation/0.6.2-dev/js/formValidation.min.js') }}"></script>
<script src="{{ asset('assets/select2/select2.full.js') }}"></script>
<script src='{{ asset("assets/toastr/toastr.min.js") }}'></script>
<script src='{{ asset("assets/sweetalert/sweet-alert.min.js") }}'></script>


<!-- <script>
		$('#fecha_turno').datepicker({
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
	
</script> -->


<script>
        @if ($status_error)
                toastr.error(" {{ $message }}", 'ERROR', {
                    // "progressBar": true,
                    "closeButton": true,
                    "positionClass": "toast-bottom-right",
                    "timeOut": "10000",
                });   
		@endif 
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