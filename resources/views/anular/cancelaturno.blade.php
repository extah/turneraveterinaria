@extends('template/template')

@section('css')

<link href="{{ asset('/css/bastrap.css') }}" rel="stylesheet">
<link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
 
<link href="{{ asset('/css/turnero.css') }}" rel="stylesheet">
<link href="{{ asset('/css/sweetalert.css') }}" rel="stylesheet">
<style type="text/css">
 


</style>
@endsection

@section('content')

<div class="main-container">
    <div class="container">
        <div id="flashMessagesId">
        </div>
    	<h3>Cancelar Turno</h3>
		<p>Ingresá los siguientes datos para buscar tu turno:</p>
		{!!html_entity_decode($mensajeerror)!!}

			{!!html_entity_decode($form_html)!!}
    </div>
</div>

@endsection

@section('js')
<script type="text/javascript" src="{{ asset('/assets/bootstrap-datetimepicker/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('/assets/bootstrap-datetimepicker/js/locales/es.js') }}"></script>
<script type="text/javascript" src="{{ asset('/assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>

<script type="text/javascript" src="{{ asset('/assets/sweetalert/sweet-alert.min.js') }}"></script>

<script type="text/javascript" src="js/jquery.form.js"></script> 

<script>

	function buscar(){
	    desactivarBotones();
	    $("form[name=form]").submit();
	}
    function anular(){
        desactivarBotones();
        $("form[name=form]").submit();
    }
    function volver(){
        window.location="{{URL::to('inicio')}}";
    }

	function desactivarBotones() {
        $("button[type='button']").not('#btn-collapse')
                .val("Por favor espere...")
                .attr('disabled', 'disabled')
                .hide();
        $(".gif_cargando").show();
    }
    function activarBotones() {
        $("button[type='button']").not('#btn-collapse')
                .removeAttr("disabled")
                .show();
        $(".gif_cargando").hide();
    }
</script>
@endsection
