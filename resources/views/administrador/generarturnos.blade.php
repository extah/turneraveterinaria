@extends('template/template')

@section('css')


<link href="{{ asset('/assets/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet"/>


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
		<div class="d-flex justify-content-center">
        	<h1 style="color:#428bca">Generar Turnos</h1>
    	</div>
		<hr>
				<form id="demoForm" method="post" action="{{ url('administrador/generarturnos')  }}" data-toggle="validator" role="form">
					{{ csrf_field() }}

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label class="formItem" for="fecha_desde"> <b>Fecha Desde</b></label>
                            <input class="form-control" data-date-format="dd/mm/yyyy" id="fecha_desde" name="fecha_desde" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="formItem" for="fecha_hasta"> <b>Fecha Hasta</b></label>
                            <input class="form-control" data-date-format="dd/mm/yyyy" id="fecha_hasta" name="fecha_hasta" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="formItem" for="lapzo_tiempo"> <b>Lapzo de tiempo</b></label>
                            <input type="number" class="form-control" id="lapzo_tiempo" name="lapzo_tiempo" placeholder="Lapzo de tiempo en minutos entre turnos" min="1" max="99999999" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label class="formItem" for="hora_desde"> <b>Horario: inicio de atención</b></label>
                            <div class="input-group date" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" id="hora_desde" name="hora_desde"/>
                                <div class="input-group-append" id="hora_desde" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-clock"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="formItem" for="hora_hasta"> <b>Horario: fin de atención</b></label>
                            <div class="input-group date" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" id="hora_hasta" name="hora_hasta"/>
                                <div class="input-group-append" id="hora_hasta" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-clock"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="formItem" for="tipo_turno"> <b>Tipo de turno</b></label>
                            <select name="tipo_turno" id="tipo_turno" class="form-control" required>
                                    <option>1-RECAUDACIONES</option>
                                    <option>2-COMERCIO</option>
                                    <option>3-INGRESOS BRUTOS</option>
                                    <option>4-FISCALIZACION</option>
                                    <option>5-CONTROL DE DEUDA</option>
                                </select>
                            
                        </div>
                    </div>

					<label>&nbsp;</label>
	
					<div class="row d-flex justify-content-center">
						<input type="submit" class='btn btn-primary btn-lg' value="Agregar Turnos">
					</div>
				</form>
</div>
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
{{-- <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script> --}}


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
    @if ($status)
        toastr.success('TURNOS GENERADOS', 'OK', {
        // "progressBar": true,
        "closeButton": true,
        "positionClass": "toast-bottom-right",
        "timeOut": "10000",
    }); 
    @endif  
</script>
<script>
    jQuery(function(){
        $('#fecha_desde').datepicker(
		{
			dateFormat: 'dd/mm/yy', 
			weekStart: 1,
            language: 'es',
            locale: 'es',
			// daysOfWeekHighlighted: "6,0",
			// autoclose: true,
			// setDate : new Date(),
			// startDate: new Date(),
			// beforeShowDay: new Date(),
            
            minDate: sumarDias(new Date()),

		});
        $('#fecha_desde').datepicker("setDate", new Date());

        function sumarDias(fecha){
            fecha.setDate(fecha.getDate() + 1);
                return fecha;
            }
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


    });

</script>

<script>
    jQuery(function(){
        $('#fecha_hasta').datepicker(
            {
                dateFormat: 'dd/mm/yy', 
                weekStart: 1,
                language: 'es',
                locale: 'es',
                // daysOfWeekHighlighted: "6,0",
                // autoclose: true,
                // setDate : new Date(),
                // startDate: new Date(),
                // beforeShowDay: new Date(),
                
                minDate: sumarDias(new Date()),
    
            });
            $('#fecha_hasta').datepicker("setDate", new Date());
    
            function sumarDias(fecha){
                fecha.setDate(fecha.getDate() + 1);
                    return fecha;
                }
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
    
    
        });
    
</script>

<script>
    $(document).ready(function(){
        $('#hora_desde').timepicker({
            timeFormat: 'HH:mm',
        interval: 60,
        minTime: '08',
        maxTime: '8:00pm',
        defaultTime: '8',
        startTime: '8:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
        });
    });
</script>
<script>
        $(document).ready(function(){
            $('#hora_hasta').timepicker({
                timeFormat: 'HH:mm',
            interval: 60,
            minTime: '08',
            maxTime: '8:00pm',
            defaultTime: '14',
            startTime: '8:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
            });
        });
</script>
@endsection