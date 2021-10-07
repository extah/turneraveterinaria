@extends('template/template')

@section('css')


<link href="{{ asset('/css/sweetalert.css') }}" rel="stylesheet">
<link href="{{ asset('/assets/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet"/>

<style type="text/css">
 table.dataTable thead {
    background: #007bff;
    color:white;
}

</style>
@endsection

@section('content')

<div class="container">
    <div class="d-flex justify-content-center">
        <h1 style="color:#428bca">Listado de feriados</h1>
    </div>
    <hr>

    <div class="col-lg-12">
        <button id="btnNuevo" type="button" class="btn btn-info" data-toggle="modal"><i class="fas fa-calendar-plus"></i> Agregar feriado </button>

    </div>
    <br>

    
    {{-- <div class="d-flex justify-content-center">
        <a href="{{ route('turnosadmin.exportlistado') }}"><input type="submit" class='btn btn-primary btn-lg form-control' value="IMPRIMIR"></a>
    </div> --}}

        <div class="col-lg-12"> 
            <div class="table-responsive">  
                <table id="tablaferiados" class="table table-striped table-hover table-bordered display" cellspacing="0" style="width:100%">
                    <meta name="csrf-token_feriado" content="{{ csrf_token() }}">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th>Fecha Feriado</th>
                            <th>Descripción Feriado</th>
                            <th>Acciones</th>
                        </tr>    
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
        <form id="formFeriados">    
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                    {{-- <div class="form-group">
                        <label for="fecha" class="col-form-label">Fecha:</label>
                        <input type="text" class="form-control" id="fecha">
                    </div> --}}
                        <div class="form-group">
                            <label class="formItem" for="fecha"> <b>Fecha</b></label>
                            <input class="form-control"  data-date-format="yyyy/mm/dd" id="fecha" name="fecha" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                        {{-- <label for="descripcion" class="col-form-label">Descripción</label> --}}
                            <label class="formItem" for="descripcion"> <b>Descripción</b></label>
                            <input type="text" class="form-control" id="descripcion" required>
                        </div> 
                    </div>    
                </div>              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btnGuardar" class="btn btn-dark">Guardar</button>
            </div>
        </form>    
        </div>
    </div>
</div>  
@endsection

@section('js')
<script src="{{ asset('assets/moment/moment.min.js') }}"></script>
<script src='{{ asset('/assets/jquery-ui/jquery-ui.min.js') }}'></script>
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
        var fecha, opcion;
        opcion = 4;
            
        tablaferiados = $('#tablaferiados').DataTable(
        {
            // "dom": '<"dt-buttons"Bf><"clear">lirtp',
            // "ajax": ({
            //     headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            //     url: "{{route('turnosadmin.feriadoseliminareditar')}}",
            //     type: "POST",
            //     )}
                "ajax":{        
                        "headers": { 'X-CSRF-TOKEN': $('meta[name="csrf-token_feriado"]').attr('content') },    
                        "url": "{{route('turnosadmin.feriadoseliminareditar')}}", 
                        "method": 'POST', //usamos el metodo POST
                        "data":{
                            '_token': $('input[name=_token]').val(),
                            opcion:opcion}, //enviamos opcion 4 para que haga un SELECT
                        "dataSrc":""
                    },

            "columns": [
                            { data: "fecha" },
                            { data: "descripcion" },
                            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btn-sm btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='fas fa-trash-alt'></i></button></div></div>"},
                        ],
            "autoWidth": true,
            "order": [[ 0, "desc" ]],
            "paging":   true,
            "ordering": true,
            "responsive":true,
            "info":     false,
            // "dom": 'Bfrtilp',
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
                    
            });    

        var fila; //captura la fila, para editar o eliminar
        //submit para el Alta y Actualización
        $('#formFeriados').submit(function(e){                         
                e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
                fecha = $.trim($('#fecha').val());    
                descripcion = $.trim($('#descripcion').val());
                          
                $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{route('turnosadmin.feriadoseliminareditar')}}",
                type: "POST",
                datatype:"json",    
                data:  {
                    '_token': $('input[name=_token]').val(),
                    fecha:fecha, descripcion:descripcion, opcion:opcion},    
                success: function(data) {
                    tablaferiados.ajax.reload(null, false);
                    swal("Exito!", "", "success"); 
                }
                });			        
            $('#modalCRUD').modal('hide');											     			
        });
                
        

        //para limpiar los campos antes de dar de Alta una Persona
        $("#btnNuevo").click(function(){
            opcion = 1; //alta           
            fila = $(this).closest("tr");

            // $("#formFeriados").trigger("reset");
            $(".modal-header").css( "background-color", "#17a2b8");
            $(".modal-header").css( "color", "white" );
            $(".modal-title").text("Alta de Feriado");
            $('#modalCRUD').modal('show');	  

            
              
        });

        //Editar        
        $(document).on("click", ".btnEditar", function(){		        
            opcion = 2;//editar
            fila = $(this).closest("tr");	        
            // user_id = parseInt(fila.find('td:eq(0)').text()); //capturo el ID		            
            fecha = fila.find('td:eq(0)').text();
            descripcion = fila.find('td:eq(1)').text();
            // last_name = fila.find('td:eq(3)').text();
            // gender = fila.find('td:eq(4)').text();
            // password = fila.find('td:eq(5)').text();
            // status = fila.find('td:eq(6)').text();
            $("#fecha").val(fecha);
            $("#descripcion").val(descripcion);
            // $("#last_name").val(last_name);
            // $("#gender").val(gender);
            // $("#password").val(password);
            // $("#status").val(status);
            $(".modal-header").css("background-color", "#007bff");
            $(".modal-header").css("color", "white" );
            $(".modal-title").text("Editar Feriado");		
            $('#modalCRUD').modal('show');		   
        });

        //Borrar
        $(document).on("click", ".btnBorrar", function(){
            fila = $(this);          
            fecha = $(this).closest('tr').find('td:eq(0)').text();
            opcion = 3; //eliminar 

            swal({
			  title: "Esta Seguro de Eliminar la Fecha "+fecha+"?",			  
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: "#DD6B55",
			  confirmButtonText: "SI",
			  cancelButtonText: "NO",
			  closeOnConfirm: false
            },
            function(isConfirm){
                if (isConfirm) {
			                          
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        url: "{{route('turnosadmin.feriadoseliminareditar')}}",
                        type: "POST",
                        datatype:"json",      
                        data:  {
                            '_token': $('input[name=_token]').val(),
                            opcion:opcion, fecha:fecha},    
                        success: function() {
                            tablaferiados.row(fila.parents('tr')).remove().draw(); 
                            swal("Eliminado!", "", "success");                 
                        }
                    });
                }
                else{
                    swal("No Eliminado!", "", "error");
                }
            } )   
        }) 
    });                
</script>
<script>
    jQuery(function(){
        

        $('#fecha').datepicker(
            {
                dateFormat: 'yy/mm/dd', 
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
            
            $('#fecha').datepicker("setDate", new Date());

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
                dateFormat: 'dd/mm/yyyy',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            };
                $.datepicker.setDefaults($.datepicker.regional['es']);
    
    
        });
    
</script>
@endsection