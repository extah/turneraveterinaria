@extends('template/template')

@section('css')

<style type="text/css">
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
        	<h1 style="color:#428bca">Menu</h1>
    	</div>
		<hr>
		<div class="row justify-content-center align-items-center h-100">
    		<div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">
				{{-- <form id="demoForm" method="post" action="{{ url('administrador/calendario')  }}" data-toggle="validator" role="form">
					{{ csrf_field() }} --}}


                    <div class="form-group">
						<a href="{{ route('turnosadmin.turnosasignados') }}"><input type="submit" class='btn btn-primary btn-lg form-control' value="Ver Turnos"></a>
					</div>
                    <div class="form-group">
						<a href="{{ route('turnosadmin.generarturnos') }}"><input type="submit" class='btn btn-primary btn-lg form-control' value="Generar Turnos"></a>
					</div>
                    <div class="form-group">
						<a href="{{ route('turnosadmin.generarferiados') }}"><input type="submit" class='btn btn-primary btn-lg form-control' value="Generar Feriados"></a>
					</div>

				{{-- </form> --}}
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


<script>
    @if ($status_ok)
            toastr.success(" {{ $message }}", '', {
                // "progressBar": true,
                "closeButton": true,
                "positionClass": "toast-bottom-right",
                "timeOut": "10000",
            });   
    @endif 
</script>


@endsection