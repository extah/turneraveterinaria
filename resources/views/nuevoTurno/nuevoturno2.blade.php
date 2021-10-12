@extends('template/template')

@section('css')

<link href="{{ asset('/css/turnero.css') }}" rel="stylesheet">
<link href="{{ asset('/css/sweetalert.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/barrapasoYcirculo.css') }}">

<link href='{{ asset("css/sweetalert.css") }}' rel="stylesheet">
<link href="{{ asset('/assets/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('/assets/toastr/toastr.min.css') }}" rel="stylesheet">

<link href="{{ asset('/assets/bootstrap-datepicker-1.7.1/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('/assets/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet"/>

{{-- <link href="{{ asset('/css/datepickk.min.css') }}" rel="stylesheet"> --}}

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
                  <h4 class="card-title">Seleccionar una Fecha</h4>
                </div>                  
            </div>
            
        </div>
		<br>
		<div class="form-group">
            <div class="my-2 pb-1 barrapaso-uno" id="barra1"></div>    
        </div>
		<div class="row justify-content-center align-items-center h-100">
    		<div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">
				<form id="demoForm" method="post" action="{{ url('nuevoturno/turnosdisponibles')  }}" data-toggle="validator" role="form">
					{{ csrf_field() }}

					<div class="form-group">
                        <label class="formItem" for="select_barrio_nombre"> <b>Barrio</b></label>
                        <input  class="form-control" type="text" name="select_barrio_nombre" id="select_barrio_nombre" value="{{ $nombrebarrio}}" disabled>
					</div>
                    <input id="select_barrio" name="select_tramite" type="hidden" value="{{ $id_barrio}}">

					<div class="form-group">
						<label class="formItem" for="fecha_turno"> <b>Fecha</b></label>
						<input class="form-control" data-date-format="dd/mm/yyyy" id="fecha_turno" name="fecha_turno" required>
					</div>
					{{-- <div class="form-group">
						<label class="formItem" for="fecha_turno"> <b>Fecha</b></label>
						<input class="form-control" data-date-format="yyyy/mm/dd" id="fecha_turno" name="fecha_turno">
					</div> --}}
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
<!-- 
<div class="container">
		{{-- <button id="paso1" class="btn_personalizado"><b>1/3</b></button>
		<div class="d-flex justify-content-center">
        	<h1 style="color:#428bca">Buscar turnos</h1>
    	</div> --}}
		{{-- <hr> --}}
		<div class="container col-6 mx-auto">
            <div class="card text-black bg-info mb-3" style="max-width: 100rem;">
                {{-- <div class="card-header">Header</div> --}}
                <div class="card-body text-Black text-center">
                  <h4 class="card-title">Buscar turnos por barrio</h4>
                </div>                  
            </div>
            
        </div>
		<div class="row justify-content-center align-items-center h-100">
    		<div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">
				<form id="demoForm" method="post" action="{{ url('nuevoturno/turnosdisponibles')  }}" data-toggle="validator" role="form">
					{{ csrf_field() }}

					<div class="form-group">
                        <label class="formItem" for="select_barrio_nombre"> <b>Barrio</b></label>
                        <input  class="form-control" type="text" name="select_barrio_nombre" id="select_barrio_nombre" value="{{ $nombrebarrio}}" disabled>
					</div>
                    <input id="select_barrio" name="select_tramite" type="hidden" value="{{ $id_barrio}}">

					<div class="form-group">
						<label class="formItem" for="fecha_turno"> <b>Fecha</b></label>
						<input class="form-control" data-date-format="dd/mm/yyyy" id="fecha_turno" name="fecha_turno" required>
					</div>
					{{-- <div class="form-group">
						<label class="formItem" for="fecha_turno"> <b>Fecha</b></label>
						<input class="form-control" data-date-format="yyyy/mm/dd" id="fecha_turno" name="fecha_turno">
					</div> --}}
					<label>&nbsp;</label>
	
					<div class="row d-flex justify-content-center">
						<input type="submit" class='btn btn-primary btn-lg' value="Buscar Turnos">
					</div>
				</form>
			</div>	
  		</div>
</div> -->
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

{{-- <script src="{{ asset("js/datepickk.min.js") }}"></script> --}}

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



{{-- <script type="text/javascript">
    $('#fecha_turno').datepicker({
		
		locale: 'es',
		language: 'es',
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
		startDate: sumarDias(new Date()),
    });
    $('#fecha_turno').datepicker("setDate", new Date());

	function sumarDias(fecha){
			fecha.setDate(fecha.getDate());
			return fecha;
		}
</script> --}}

<script>
	var select = document.getElementById('select_tramite_nombre');
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

<script>
	jQuery(function(){
    
    // var enableDays = ["08/06/2021","09/06/2021","10/06/2021","12/06/2021"];
    var enableDays =  {!! json_encode($fechasDisp) !!};
    function enableAllTheseDays(date) {
        var sdate = $.datepicker.formatDate( 'dd/mm/yy', date)
        console.log(sdate)
        if($.inArray(sdate, enableDays) != -1) {
            return [true];
        }
        return [false];
    }

	function sumarDias(fecha){
		fecha.setDate(fecha.getDate());
		return fecha;
	}
    
    $('#fecha_turno').datepicker(
		{
			dateFormat: 'dd/mm/yy', 
			weekStart: 1,
			// daysOfWeekHighlighted: "6,0",
			// autoclose: true,
			todayHighlight: true,
			// setDate : new Date(),
			// startDate: new Date(),
			beforeShowDay: enableAllTheseDays,
			// startDate: sumarDias(new Date()),

		});

		$.datepicker.regional['es'] = {
			closeText: 'Cerrar',
			prevText: '<Ant',
			nextText: 'Sig>',
			currentText: 'Hoy',
			monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
			dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
			dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
			weekHeader: 'Sm',
			dateFormat: 'dd/mm/yy',
			firstDay: 1,
			isRTL: false,
			showMonthAfterYear: false,
			yearSuffix: ''
		};

		$.datepicker.setDefaults($.datepicker.regional['es']);
		// $('#fecha_turno').datepicker("setDate", new Date()); //dia actual
        $('#fecha_turno').datepicker("setDate", {!! json_encode($fechasDisp[0]) !!});
		

});



</script>
@endsection