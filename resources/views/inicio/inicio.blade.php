@extends('template/template')

@section('css')

            <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
            <link rel="stylesheet" href="{{ asset('css/login.css') }}">
            <style type="text/css">
              .a {
                 color: #183a68;
                 text-decoration: none;
                 background-color: transparent;
             }
             .barrapaso-uno {
                    border-top: 10px solid #37BBED;
                    padding-top: 10px;
                }
                .uno {
                    background: #37BBED;
                }
                body {
                    /* font-family: 'Encode Sans';font-size: 22px; */
                    font-size: 22px;
                }
             </style>
@endsection             
@section('content')
    <br>
    <div class="container-fluid">
        <div class="justify-content-center" style="text-align:center;">
            <h1 style="color:#183a68"> <b>Bienvenido al sistema de turnos para atención primaria de su mascota</b></h1>
        </div>
        
        <div class="form-group">
            <div class="my-2 pb-1 barrapaso-uno" id="barra1"></div>    
        </div>
    
        <div class="d-flex justify-content-around">
            <div class="col-xs-6 text-center" >

                
                <div class="card text-white bg-success mb-3 border-dark" style="max-width: 18rem;">
                    <div class="card-header bg-transparent border-dark">
                        <h3 class="card-title">Nuevo Turno</h3>
                    </div>
                    <div class="card-body text-light">
                        <p class="card-text">para obtener un nuevo turno para su mascota, presione " Buscar "</p>
                        <a class="btn btn-success btn-circle btn-xl border-light" href="nuevoTurno" role="button"><h2>Buscar</h2></a>
                    </div>
                
                </div>
            </div>
            <div class="col-xs-6 text-center">
                    
                    <div class="card border-dark text-white mb-3 bg-danger" style="max-width: 18rem;">
                        <div class="card-header border-dark">
                            <h3>Cancelar Turno</h3>
                        </div>
                        <div class="card-body text-light">
                            <p class="card-text">para cancelar un turno para su mascota, presione " Cancelar "</p>
                            <a class="btn btn-danger btn-circle btn-xl border-light" href="cancelarTurno" role="button"><h2>Cancelar</h2></a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <br>
    <br>    
@endsection

@section('js')

<script>
    $(function() {
        $(".btn1").click(function() {
            $(".form-signin").toggleClass("form-signin-left");
        $(".form-signup").toggleClass("form-signup-left");
        $(".frame").toggleClass("frame-long");
        $(".signup-inactive").toggleClass("signup-active");
        $(".signin-active").toggleClass("signin-inactive");
        $(".forgot").toggleClass("forgot-left");   
        $(this).removeClass("idle").addClass("active");
        });
    });

</script>
<script>
    @if (Session::get('status_error'))
            toastr.error( '{{ session('message') }}', 'ERROR', {
                // "progressBar": true,
                "closeButton": true,
                "positionClass": "toast-bottom-right",
                "timeOut": "10000",
            });   
    @endif 
</script>

<script>
    @if (Session::get('status_info'))
            toastr.info( '{{ session('message') }}', 'Informar', {
                // "progressBar": true,
                "closeButton": true,
                "positionClass": "toast-bottom-right",
                "timeOut": "10000",
            });   
    @endif 
</script>

<script>
(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()
</script>
@endsection