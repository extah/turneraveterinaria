@extends('template/template')

@section('css')

<!-- <link href="{{ asset('/css/formulario.css') }}" rel="stylesheet"> -->
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
		<button id="paso1" class="btn_personalizado"><b>2/2</b></button>
		<div class="d-flex justify-content-center">
        	<h1 style="color:#d1391f">Turno cancelado</h1>
    	</div>
        <hr>
        <div class="row justify-content-center align-items-center h-100">

            <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">
    
                <div class="form-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><b>N° DE DOCUMENTO: </b>  &nbsp; {{ $nro_documento }}</div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><b>PERSONA: </b>  &nbsp; {{ $apeynombre }}</div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><b> FECHA: </b> &nbsp; {{ $date }}</div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><b>HORA: </b>  &nbsp; {{ $hora }}</div>
                    </div>
                </div>
            </div>
        </div>
<hr>


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


{{-- <script>
        @if ($status_error)
                toastr.error(" {{ $message }}", 'ERROR', {
                    // "progressBar": true,
                    "closeButton": true,
                    "positionClass": "toast-bottom-right",
                    "timeOut": "10000",
                });   
		@endif 
</script> --}}

@endsection