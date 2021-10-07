@extends('template/template')

@section('css')


<link href="{{ asset('/assets/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet"/>


<style type="text/css">

</style>
@endsection

@section('content')

<div class="container">
    <div class="d-flex justify-content-center">
        <h1 style="color:#428bca">Listado de turnos</h1>
    </div>
    <hr>


        <div class="col-lg-12">
            <button id="btnBuscar" type="button" class="btn btn-info" data-toggle="modal"><i class="fas fa-search-plus"></i> Buscar por fechas </button>
    
        </div>
        <br>

        <div class="col-lg-12"> 
            <div class="table-responsive">  
                <table id="tablaturnos" class="table table-striped table-hover table-bordered display" cellspacing="0" style="width:100%">
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <thead class="thead-dark text-center">
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Turno</th>
                        <th>Libre</th>
                        <th>Apellido y Nombre</th>
                        <th>Documento</th>
                        <th>Tramite</th>
                        <th>Telefono</th>
                        <th>Email</th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>    
        </div>        
</div>

<!--Modal para CRUD-->
<div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formTurnos">    
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label class="formItem" for="fecha_desde"> <b>Fecha Desde</b></label>
                            <input class="form-control" data-date-format="dd/mm/yyyy" id="fecha_desde" name="fecha_desde" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="formItem" for="fecha_hasta"> <b>Fecha Hasta</b></label>
                            <input class="form-control" data-date-format="dd/mm/yyyy" id="fecha_hasta" name="fecha_hasta" required>
                        </div>  
                    </div>              
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btnGuardar" class="btn btn-dark">Buscar</button>
                </div>
            </form>    
        </div>
    </div>
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
<script src='{{ asset("assets/toastr/toastr.min.js") }}'></script>
<script src='{{ asset("assets/validity/jquery.validity.min.js") }}'></script>
<script src='{{ asset("assets/validity/jquery.validity.lang.es.js") }}'></script>
<script src='{{ asset("assets/sweetalert/sweet-alert.min.js") }}'></script>


<script>
    
$(document).ready(function() {
    // DataTable initialisation
  //order: default sıralama
  //paging: datapagination
  //responsive:
  var opcion;
  opcion = 2;
  tablaturnos = $('#tablaturnos').DataTable(
        {

        // "dom": '<"dt-buttons"Bf><"clear">lirtp',
        // "ajax":{            
        //                 "headers": { 'X-CSRF-TOKEN': $('meta[name="csrf-token_entrada"]').attr('content') },    
        //                 "url": "{{route('turnosadmin.turnosasignadosdatatable')}}", 
        //                 "method": 'post', //usamos el metodo POST
        //                 "data":{
        //                     // '_token': $('input[name=_token]').val(),
        //                     opcion:opcion}, //enviamos opcion 1 para que haga un SELECT
        //                 "dataSrc":""
        //             },
        // "ajax": "{{route('turnosadmin.turnosasignadosdatatable')}}",
        "columns": [
                        { data: "fecha" },
                        { data: "hora" },
                        { data: "Nro" },
                        { data: "libre" },
                        { data: "Apyn" },
                        { data: "doc" },
                        { data: "tram" },
                        { data: "telefono" },
                        { data: "email" },
                        
                        // { data: "Apellido" },
                    ],
        "autoWidth": true,
         "order": [[ 0, "asc" ]],
         "paging":   true,
         "ordering": true,
         "responsive":true,
         "info":     false,
         "dom": 'Bfrtilp',
        //  "data": dataSet,

        //  "buttons": [ 'copy', 'csv', 'excel', 'pdf', 'print' ],
         "language": {
                        "sProcessing":     "Procesando...",
                        "sLengthMenu":     "Mostrar _MENU_ registros",
                        "sZeroRecords":    "No se encontraron resultados",
                        "sEmptyTable":     "Ningún dato disponible en esta tabla",
                        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                        "sSearch":         "Buscar:",
                        "sInfoThousands":  ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst":    "Primero",
                            "sLast":     "Último",
                            "sNext":     "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        },
                        "buttons": {
                            "copy": "Copiar",
                            "colvis": "Visibilidad"
                        }
                    },

            "buttons":[
                {
                    extend:    'excelHtml5',
                    text:      '<i class="fas fa-file-excel"></i> EXCEL ',
                    titleAttr: 'Exportar a Excel',
                    className: 'btn btn-success'
                },
                {
                    extend:    'pdfHtml5',
                    text:      '<i class="fas fa-file-pdf"></i> PDF',
                    titleAttr: 'Exportar a PDF',
                    className: 'btn btn-danger'
                },
                {
                    extend:    'print',
                    text:      '<i class="fa fa-print"></i> IMPRIMIR',
                    titleAttr: 'Imprimir',
                    className: 'btn btn-info'
                },
             ]                 
        });



        var fila;
        $('#formTurnos').submit(function(e){                         
                e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
                fecha_desde = $.trim($('#fecha_desde').val());    
                fecha_hasta = $.trim($('#fecha_hasta').val());


                $('#tablaturnos').DataTable().clear().draw();
                // $('#tablaturnos').DataTable().destroy();
 
                $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{route('turnosadmin.turnosasignadosdatatable')}}",
                type: "POST",
                datatype:"json",    
                data:  {
                    '_token': $('input[name=_token]').val(),
                    opcion:opcion, fecha_desde:fecha_desde, fecha_hasta:fecha_hasta}, 

                success: function(data) {
                    // console.log(data);

                    var text = data;
                    var data = JSON.parse(text);

                    tablaturnos.rows.add(data).draw();

                    // swal("Se genero el feriado con Exito!", "", "success"); 
                },


                });
		        
            $('#modalCRUD').modal('hide');											     			
        });

                        //buscar
        $("#btnBuscar").click(function(){
            opcion = 1; //busqueda           
            fila = $(this).closest("tr");	        

            // fecha_desde = fila.find('td:eq(0)').text();
            // fecha_hasta = fila.find('td:eq(1)').text();
            // alert(fecha_desde);
            $(".modal-header").css( "background-color", "#17a2b8");
            $(".modal-header").css( "color", "white" );
            $(".modal-title").text("Buscador de turnos");
            $('#modalCRUD').modal('show');	  

            
              
        });
     
 });
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
            
            // minDate: sumarDias(new Date()),

		});
        $('#fecha_desde').datepicker("setDate", new Date());


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
                
                // minDate: sumarDias(new Date()),
    
            });
            $('#fecha_hasta').datepicker("setDate", new Date());
    

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
@endsection