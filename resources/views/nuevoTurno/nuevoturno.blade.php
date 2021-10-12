@extends('template/template')

@section('css')

<link rel="stylesheet" href="{{ asset('css/barrapasoYcirculo.css') }}">

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
<br><br>
<div class="container">
		{{-- <button id="paso1" class="btn_personalizado"><b>1/3</b></button> --}}
		{{-- <div class="d-flex justify-content-center">
        	<h1 style="color:#428bca">Buscar turnos</h1>
    	</div> --}}
		<div class="container col-6 mx-auto">
            <div class="card text-black bg-info mb-3" style="max-width: 100rem;">
                {{-- <div class="card-header">Header</div> --}}
                <div class="card-body text-Black text-center">
                  <h4 class="card-title">Buscar turnos por barrio</h4>
                </div>                  
            </div>
            
        </div>
		<br>
		<div class="form-group">
            <div class="my-2 pb-1 barrapaso-uno" id="barra1"></div>    
        </div>
		<div class="row justify-content-center align-items-center h-100">
    		<div class="col col-sm-8 col-md-8 col-lg-8 col-xl-3">
				<form id="demoForm" method="post" action="{{ url('nuevoturno/fechasdisponibles')  }}" data-toggle="validator" role="form">
					{{ csrf_field() }}

					<div class="form-group">
						<label class="formItem" for="select_tramite"> <b>Barrio</b></label>
						<select name="select_barrio" id="select_barrio" class="form-control" required>
							<option value="">-Seleccioná un barrio-</option>
							@foreach($barrios as $barrio)
								<option value="{{ $barrio->id }}" offset="1">{{ $barrio->barrio }}</option>
							
							@endforeach
						</select>
					</div>
					<label>&nbsp;</label>
	
					<div class="row d-flex justify-content-center">
						<input type="submit" class='btn btn-primary btn-lg' value="Buscar Turnos">
					</div>
				</form>
			</div>	
  		</div>
</div>
<br>
<br>
@endsection

@section('js')

<script src="{{ asset('assets/moment/moment.min.js') }}"></script>
{{-- <script src="{{ asset('/assets/bootstrap-datepicker-1.7.1/js/bootstrap-datepicker.min.js') }}"></script> --}}
<script src='{{ asset('/assets/jquery-ui/jquery-ui.min.js') }}'></script>
{{-- <script src="{{ asset('/assets/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js') }}"></script> --}}
<script src="{{ asset('/assets/formvalidation/0.6.2-dev/js/formValidation.min.js') }}"></script>
<script src="{{ asset('assets/select2/select2.full.js') }}"></script>
<script src='{{ asset("assets/toastr/toastr.min.js") }}'></script>
<script src='{{ asset("assets/sweetalert/sweet-alert.min.js") }}'></script>

<script>
	var select = document.getElementById('select_tramite');
	select.addEventListener('change', function(evt) {
	this.setCustomValidity('');
	});
	select.addEventListener('invalid', function(evt) {
	// Required
	if (this.validity.valueMissing) {
		this.setCustomValidity('Por favor seleccione un tramite!');
	}
	});

</script>

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

@endsection