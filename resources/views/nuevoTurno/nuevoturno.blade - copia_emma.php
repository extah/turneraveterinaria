@extends('template/template')

@section('css')

<link href="{{ asset('/css/bastrap.css') }}" rel="stylesheet">
<link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">



<link href="{{ asset('/assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('/css/turnero.css') }}" rel="stylesheet">
<link href="{{ asset('/css/sweetalert.css') }}" rel="stylesheet">
<style type="text/css">
 


</style>
@endsection

@section('content')
<input type="hidden" name="veripaso" id="veripaso" value="0">
<hr style="margin-top: 0px">
<div class="row " style="min-height: 500px; width: 99%; background-color: white; " >	 
    <div class="row shortcut-row col-md-12" style=" margin-left: 20px ;" >
        <div class="col-md-3" style="text-align: center;">
            <button id="paso1" onclick="showPasos(1)" class="btn btn-default btn-circle btn-lg"><b>1</b></button><br>
            <h5>Trámite</h5>
            <div id="descripcion_paso1"><p class="btn btn-default btn-xs">---</p></div>
        </div>
        <div class="col-md-3" style="text-align: center;">
            <button id="paso2" onclick="showPasos(2)" class="btn btn-default btn-circle btn-lg"><b>2</b></button><br>
            <h5>Datos Personales</h5>
            <div id="descripcion_paso2"><p class="btn btn-default btn-xs">---</p></div>
        </div>
        <div class="col-md-3" style="text-align: center;">
            <button id="paso3" onclick="showPasos(3)"  class="btn btn-default btn-circle btn-lg"><b>3</b></button><br>
            <h5>Día y Hora</h5>
            <div id="descripcion_paso3"><p class="btn btn-default btn-xs">---</p></div>
        </div>
        <div class="col-md-3" style="text-align: center;">
            <button id="paso4" onclick="showPasos(4)"  class="btn btn-default btn-circle btn-lg"><b>4</b></button><br>
            <h5>Confirmar</h5>
            <div id="descripcion_paso4"><p class="btn btn-default btn-xs">---</p></div>
        </div>
         
    </div>

    <div id="_elegirTramite"  style="display: none; margin-left: 100px; ">
   
        <div class="row" style="margin-top: 50px">

            <div class="col-md-3">
                <h5><label class="control-label">Seleccioná el trámite que querés realizar</label></h5>
                <select id="select_tramite" class="form-control" onchange="selectTramite()">
                    <option selected="selected" value="0">Seleccioná un trámite</option>
                    @foreach($tarmites as $tarmite)
                        <option value="{{ $tarmite->id_tramite }}" offset="1">{{ $tarmite->tramite }}</option>
                    
                    @endforeach
                </select>
            </div>
        </div>
        <br>
        
        <div id="requisitos_tramite"  style="display:none;">
            <div class="row">
                <div class="col-md-12">
                <button type="button" class="btn btn-success" onclick="elegirTramite()">Confirmar</button>
                <div id="gif_cargando" class="gif_cargando" style="display: none"><img src="css/css_imgs/cargando.gif"></div>
                </div>
            </div>
            <br>    
            <!--<div class="row">
                <div class="col-md-10">
                    <div class="alert-spot alert-spot-info">
                        <span class="glyphicon glyphicon-file"></span>
                        <div class="alert-link-text">
                            <h4> Requisitos para realizar el trámite: </h4>
                            <div id="requisitos_texto"></div>
                        </div>
                    </div>
                </div>
            </div>      -->
            
            
        </div>
        <div id="_datospersonales_tramite"  style="display:none">
            <div class="row">
                <div class="col-md-10">
                    <div class="alert-spot alert-spot-info">
                        <span class="glyphicon glyphicon-file"></span>
                        <div class="alert-link-text">
                            <h4> Ingrese sus Datos: </h4>
                            
                        </div>
                    </div>
                </div>
            </div>      
            <br>
            <div class="row" id="div_inicio" >
                <div class="col-md-12" >
                <button type="button" class="btn btn-success" onclick="cargaDatos()">Confirmar</button>
                <div id="gif_cargando" class="gif_cargando" style="display: none"><img src="css/css_imgs/cargando.gif"></div>
                </div>
            </div>
        </div>
        

    </div> 
    <div id="_ingresarDatos" style="display: none; margin-left: 100px; padding-right: 0px">
    
        <div class="row col-md-12" style="margin-top: 0px">
            <div id="formDatosPersonales">
            </div>
        </div>
        
        <br>
        <div class="row col-md-12" style="margin-top: 20px" id="div_inicio_btn" name="div_inicio_btn">
            <button type="button" class="btn btn-success" onclick="validarDatosPersonales();">Confirmar</button>
            <br>
            <div id="gif_cargando" class="gif_cargando" style="display: none"><img src="css/css_imgs/cargando.gif"></div>
        </div>
    </div>
    <div id="_elegirTurno" style="display: none; margin-left: 100px; padding-right: 0px; margin-top: 20px">
        <h4>Seleccioná un día para ver los horarios disponibles</h4>
        <div style="overflow:hidden;">
            <div class="form-group">
                
                </br>
                <div class="row">
                    <div class="col-md-4">
                        <div id="datetimepickerTurno"></div>
                    </div>
                    <div class="gif_cargando_turnos col-md-8">
                        <div class="alert alert-info">
                            <img src="css/css_imgs/cargando.gif">
                                &nbsp; Cargando turnos
                        </div>
                    </div>
                    <div id="datosDiaSeleccionado" class="col-md-8" style="display:none">
                        <div id="turnosDisponibles" class="row">
                            <label class="control-label">Turnos disponibles: </label>
                            <div id="turnosDisponiblesListado">
                            </div>
                        </div>
                        <br>
                        <div id="advertencia_turno_seleccionado" style="display:none" class="row alert alert-info">
                        </div>
                        <br>
                        <div id="btn_confirmar" class="row" style="display:none" >
                            <button type="button" class="btn btn-success" onclick="confirmarTurno()">Confirmar</button>
                            <div id="gif_cargando" class="gif_cargando" style="display: none"><img src="css/css_imgs/cargando.gif"></div> 
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <div id="_confirmaTurno" style="display: none; margin-left: 100px; padding-right: 0px; margin-top: 110px">
        <h3>Verifica si los datos son correctos</h3>
        <div style="overflow:hidden;">
            <div class="form-group">
                
                </br>
                <div class="row" class="col-md-12" >
                    <form name='formconfirma' method='post' action=''>                    
                        <div id="datosDiaSeleccionado" class="col-md-12">
                           
                            <div id="espacio-datos" class="col-md-12" style="padding: 10px; margin-top: -20px; background: #D8D8D8; border-radius: 15px;">
                                
                                <!--cierra columna3-->
                                <!--<div style="width: 30%; margin-right: 30px; margin-left: 10px; float: left">-->

                                <div class='col-md-2'>
                                    <div class="filadatos">
                                        <span class="campos"><label for="tipo_documento">Tipo Documento</label></span> <span class="datos" id="s_tipo_doc"></span><input type="hidden" name="f_tipo_doc" id="f_tipo_doc" >
                                    </div>
                                </div>
                                <div class='col-md-3'>
                                    <div class="filadatos">
                                        <span class="campos"><label for="numero_documento">Número de Documento</label></span> <span class="datos" id="s_nro_doc"></span><input type="hidden" name="f_nro_doc" id="f_nro_doc">
                                    </div>
                                </div>
                                <div class='col-md-2'>
                                    <div class="filadatos">
                                        <span class="campos"><label for="primer_apellido">Apellido</label></span> <span class="datos" id="s_apellido"></span><input type="hidden" name="f_apellido" id="f_apellido">
                                    </div>
                                </div>
                                <div class='col-md-2'>
                                    <div class="filadatos">
                                        <span class="campos"><label for="primer_nombre">Nombre</label></span> <span class="datos" id="s_nombre"></span><input type="hidden" name="f_nombre" id="f_nombre">
                                    </div>
                                </div>
                                <div class='col-md-2'>
                                    <div class="filadatos">
                                        <span class="campos"><label for="s_telefono">Telefono</label></span> <span class="datos" id="s_telefono"></span><input type="hidden" name="f_telefono" id="f_telefono">
                                    </div>
                                </div>
                                <div class='col-md-2'>
                                    <div class="filadatos">
                                        <span class="campos"><label for="email">eMail</label></span> <span class="datos" id="s_email"></span><input type="hidden" name="f_email" id="f_email">
                                    </div>
                                </div>
                                <!--</div>-->
                                <!--cierra columna1-->
                                <!--<div style="width: 30%; margin-right: 20px; float: left">-->
                                <div class='col-md-2'>
                                    <div class="filadatos">
                                        <span class="campos"><label for="calle">Calle</label></span> <span class="datos" id="s_domicilio_calle"></span><input type="hidden" name="f_domicilio_calle" id="f_domicilio_calle">
                                    </div>
                                </div>
                                <div class='col-md-2'>
                                        <div class="filadatos">
                                        <span class="campos"><label for="numero_calle">Nro</label></span><span class="datos" id="s_domicilio_nro"></span><input type="hidden" name="f_domicilio_nro" id="f_domicilio_nro">
                                    </div>
                                </div>
                                <div class='col-md-2'>
                                    <div class="filadatos">
                                        <span class="campos"><label for="localidad">Sub-Nro</label></span><span class="datos" id="s_domicilio_subnro"></span><input type="hidden" name="f_domicilio_subnro" id="f_domicilio_subnro">
                                    </div>
                                </div>
                                <div class='col-md-2'>
                                    <div class="filadatos">
                                        <span class="campos"><label for="email">Piso</label></span> 
                                        <span class="datos" id="s_domicilio_piso"></span><input type="hidden" name="f_domicilio_piso" id="f_domicilio_piso">
                                    </div>
                                </div>
                                <div class='col-md-2'>
                                    <div class="filadatos">
                                        <span class="campos"><label for="telefono">Dpto.</label></span> <span class="datos" id="s_domicilio_dpto"></span><input type="hidden" name="f_domicilio_dpto" id="f_domicilio_dpto">
                                    </div>
                                </div>
                                <div class='col-md-2'>
                                    <div class="filadatos">
                                        <span class="campos"><label for="domicilio_mzna">Mzna.</label></span> <span class="datos" id="s_domicilio_mzna"></span><input type="hidden" name="f_domicilio_mzna" id="f_domicilio_mzna">
                                    </div>
                                </div>
                                <!--</div>-->
                                <!--cierra columna1-->
                                <!--<div style="width: 30%; margin-right: 30px; margin-left: 10px; float: left">-->
                                <div class='col-md-2'>
                                    <div class="filadatos">
                                        <span class="campos"><label for="tramite">Tramite:</label></span>
                                        <span class="datos" id="s_tramite"></span><input type="hidden" name="f_tramite" id="f_tramite">
                                    </div>
                                </div>
                                <div class='col-md-2'>
                                    <div class="filadatos">
                                        <span class="campos"><label for="turno">Turno Seleccionado:</label></span>
                                        <span class="datos" id="s_id_turno"></span><input type="hidden" name="f_id_turno" id="f_id_turno"> 
                                    </div>  
                                </div>
                                

                                <!--</div>-->
                            </div>
                            <div class='col-md-4'>
                                <div id="div_capcha" class="filadatos" style="margin-top: 10px">
                                   <div class='g-recaptcha' data-sitekey='6LfpoScUAAAAAA2usCdAwayw_KQiHe44y5e1Whk-'></div>
                                   <div id='errorRecaptcha' style='display:none; color:#a94442'>    <span class='glyphicon glyphicon-exclamation-sign'></span>    Por favor, clickeá en el recaptcha para poder reservar el turno.</div>
                                </div>
                            </div>
                        </div>

                         

                        <div class="col-md-12"  >
                             
                            <div id="advertencia_turno_seleccionado" class="row alert alert-info col-md-8" style="margin-left: 5px; margin-top: 15px;border-radius: 15px; text-align: center;">Al confirmar se generará la constancia de turno
                            </div>
                           
                            
                            <div id="btn_confirmar2" class="col-md-3" >
                                <button type="button" id="bt_grabar" name="bt_grabar" class="btn btn-success" style="margin-top: 25px; margin-left: 30px" onclick="save_all();">Confirmar</button>
                                 
                            </div> 
                            <div id="div_wait" style="display: none; margin-left: 50px">
                                <img src="{{ asset('/css/css_imgs/loader2.gif') }}" alt="HTML5 Icon" style="width:60px;height:60px; margin-left: 50px">
                            </div>
                        </div>
                             
                        
                    </form>
                </div>
            </div>
        </div>
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

    function justNumbers(e) {
            var keynum = window.event ? window.event.keyCode : e.which;
            if ((keynum == 8 || keynum == 48))
                return true;
            if (keynum <= 47 || keynum >= 58) return false;
            return /\d/.test(String.fromCharCode(keynum));
        } 

    function showPaso(nroPaso){
        if (pasoActual>= nroPaso) {
            $("#_elegirTramite").hide();
            $("#_datospersonales_tramite").hide();
            $("#_elegirTurno").hide();
            $("#_ingresarDatos").hide();
            $("#_confirmaTurno").hide();
             
            //var feriados = [];
            
            //iniciarTurnosDatePiker(feriados, "2017-08-01","2017-09-06");
             

            switch(nroPaso) {
                case 1:
                    $("#_elegirTramite").show();
                    marcarBotonMenu(1);
                    break;
                case 2:

                    $("#_ingresarDatos").show();
                    //$("#_datospersonales_tramite").show();
                    marcarBotonMenu(2);
                    break;
                case 3:                    
                    $("#_elegirTurno").show();
                    marcarBotonMenu(3);
                    break;
                case 4:                   
                    $("#_confirmaTurno").show();
                    marcarBotonMenu(4);
                    break;
                default:
                    //$("#_elegirTramite").show();
                    //marcarBotonMenu(1);
                    break;
            }
            hideErrores();
            $("html, body").animate({
                scrollTop: 0
            }, 300);
        }
    }

    function setInfoPasoN(numeroPaso,detalle){
        $("#descripcion_paso"+numeroPaso).empty();
        $("#descripcion_paso"+numeroPaso).append("<p class='btn btn-success btn-xs'>"+detalle+"</p>")
    }

    function marcarBotonMenu(nroPaso){
        $("#paso1").removeClass("btn-success");
        $("#paso1").addClass("btn-default");
        $("#paso2").removeClass("btn-success");
        $("#paso2").addClass("btn-default");
        $("#paso3").removeClass("btn-success");
        $("#paso3").addClass("btn-default");
        $("#paso4").removeClass("btn-success");
        $("#paso4").addClass("btn-default");
        $("#paso" + nroPaso).removeClass("btn-default");
        $("#paso" + nroPaso).addClass("btn-success");
    }

    function setInfoPaso1(){
        $("#descripcion_paso1").empty();
        $("#descripcion_paso1").append("<p class='btn btn-success btn-xs'>"+tramiteSeleccionado[1]+"</p>")
    }
</script>


<script type="text/javascript">

    var pasoActual = 1; // Paso actual en la reserva del turno
    var requisitoTramite = new Array();
    var terminoTramite = new Array();
    var usaTerminosTramite = new Array();
     // Se precargan los tramites.
                    requisitoTramite[1]='<h3>Licencia Original</h3><h4>REQUISITOS</h4><ul><li><a href="libredeuda"  target="_blank">Certificado de Libre Deuda de Faltas (puede consultarse de manera Online en la página de inicio de este Sistema de Turnos). Entregar sólo el original. Cabe destacar que el horario de la mencionada oficina es de 8 a 12 hs, teniéndolo en cuenta para la facilidad de la tramitación.</a></li><li>Documento de Identidad (DNI), original y 1 copia de ambos lados. Quienes tramiten su licencia por primera vez no podrán obtener las clases profesionales.</li><li>Grupo sanguíneo (firmado por bioquímico).</li>  <li>Quienes obtengan su primera licencia de conducir deberán circular por seis (6) meses con el cartel indicador de Principiante con los límites que marca la ley no podrán conducir en rutas, autopistas o semiautopistas. Además, los principiantes particulares clases A, B y G con 18 años de edad esperarán hasta los 21 años de edad para acceder a la clase de tipo profesional y en caso de ser principiante mayor de 21 años, el solicitante está impedido por un año al acceso de la clase profesional.</li><li>En cualquier caso deberán realizar el correspondiente examen psicofísico y la prueba de aptitud acorde a las categorías solicitadas.</li></ul><br /><h4>EXCEPCIONES A MENORES</h4><ul><li>Los menores con 21 años de edad sólo podrán solicitar licencias de conducir para motos de hasta 50 cc. autos y camionetas por un año con autorización de los padres, con el impedimento de acceder a clases profesionales hasta los 21 años cumplidos.</li><li>Los menores con 21 años de edad sólo podrán solo podrán ampliar sus licencias de conducir para motos de hasta 150 cc., teniendo una antigüedad de 2 años con menor cilindrada o siendo mayor a 21 años.</li><li>Las autorizaciones son ante Escribano Público o Juez de Paz.</li></ul><br /><h4>VIGENCIA DE LAS LICENCIAS OTORGADAS</h4><ul>  <li>Menores con 16 años cumplidos, 1 año vigente con autorización de los padres.</li>  <li>Menores con 18 años cumplidos, 1 año vigente con autorización de los padres.</li>  <li>Mayores de entre 18 y 64 años, 5 años vigentes.</li>  <li>Mayores de entre 65 y 69 años, 3 años vigentes.</li>  <li>Adultos mayores de 70 años en adelante, 1 año vigente.</li>  <li>Conductores de vehículos adaptados, de 1 a 3 años vigentes, según criterios médicos.</li></ul>';
                    requisitoTramite[2]='<h3>Renovación de Licencia</h3><ul><li>Documento de Identidad (DNI), original y 1 copia (en buen estado Ley 17.671)</li><li><a href="libredeuda"  target="_blank">Certificado de Libre Deuda de Faltas (puede consultarse de manera Online en la página de inicio de este Sistema de Turnos). Entregar sólo el original. Cabe destacar que el horario de la mencionada oficina es de 8 a 12 hs, teniéndolo en cuenta para la facilidad de la tramitación.</a></li><li>En caso de renovación de una Licencia expedida en otro municipio de la provincia de Buenos Aires, deberá presentar un certificado de Legalidad, expedido por la Municipalidad correspondiente. De esa manera, estaría demostrando no ser principiante.</li><li>Fotocopia de ambos lados de la Licencia de Conducir.</li><li>Concurrir con Licencia de Conducir si aún está en vigencia.</li><li>Pasados los 90 días de la fecha de vencimiento de la licencia, el solicitante deberá hacer una licencia original con los mismos requisitos de los aspirantes (ver requisitos en LICENCIA ORIGINAL).</li><li>El costo total del trámite dependerá de renovación acorde a la edad y la clase habilitante que se pretende. En caso de pretender habilitación para conducir clases de tipo profesional C, D, y E, (siempre que no sea principiante) se deberá presentar certificación y fotocopia que acredite encontrarse libre de antecedentes, expedida por el Registro Nacional de Reincidencias y Estadística Criminal y Carcelaria, sito en calle 13 entre 34 y 35 de La Plata, el que tiene 30 días de validez a partir de su otorgamiento. Además, deberán ser mayores de 21 años de edad.</li><li>A partir de los 65 años deberán rendir nuevamente examen PRÁCTICO.</li></ul>';
                    requisitoTramite[3]='<h3>Cambios de Domicilio y/o datos</h3><ul><li>Todo cambio de datos en el DNI, tiene que ser declarado en la Licencia, dentro de los 90 días, pasado ese tiempo se deberá realizar un exámen teórico de todas las clases que figuren en la Licencia.</li><li>En caso de renovación de una Licencia expedida en otro municipio de la provincia de Buenos Aires, deberá presentar un certificado de Legalidad, expedido por la Municipalidad correspondiente.</li><li>Documento de Identidad (DNI), original y 1 fotocopia de ambos lados (en buen estado Ley 17.671).</li><li><a href="libredeuda"  target="_blank">Certificado de Libre Deuda de Faltas (puede consultarse de manera Online en la página de inicio de este Sistema de Turnos). Entregar sólo el original. Cabe destacar que el horario de la mencionada oficina es de 8 a 12 hs, teniéndolo en cuenta para la facilidad de la tramitación.</a></li><li>Fotocopia de ambos lados de la Licencia de Conducir.</li><li>Concurrir con Licencia de Conducir si aún está en vigencia.</li></ul>';
                    requisitoTramite[4]='<h3>Duplicado de Licencias</h3><ul><li>Los trámites por duplicado de licencias, robo y/o extravíos, NO NECESITAN SOLICITAR TURNOS.</li><li>Se deberán presentar con los requisitos solicitados de 8 a 13 hs., siempre y cuando sea hasta un mes antes del vencimiento que se encuentra en la parte posterior del dicha licencia. En caso que este dentro del período de renovación, deberán solicitar turno.</li><li>Documento de Identidad (DNI), original y fotocopia de primera y segunda hoja y último cambio de domicilio (en buen estado Ley 17.671)</li><li><a href="libredeuda"  target="_blank">Certificado de Libre Deuda de Faltas (puede consultarse de manera Online en la página de inicio de este Sistema de Turnos). Entregar sólo el original. Cabe destacar que el horario de la mencionada oficina es de 8 a 12 hs, teniéndolo en cuenta para la facilidad de la tramitación.</a></li><li>Grupo sanguíneo (firmado por bioquímico)</li><li>En caso de duplicación por robo o extravío deberá presentar la denuncia ante autoridad Control Urbano (Avenida Montevideo y calle 8). Original y copia.</li><li>En caso de duplicación por deterioro deberá entregar la Licencia en mal estado.</li><li>En el caso de poseer clases profesionales se deberá presentar Certificado de Reincidencias, original y fotocopia, expedida por el Registro Nacional de Reincidencias y Estadística Criminal y Carcelaria, sito en calle 13 entre 34 y 35 de La Plata, el que tiene 30 días de validez a partir de su otorgamiento. Además, deberán ser mayores de 21 años de edad.</li></ul>';
                    requisitoTramite[5]='<h3>Ampliación de Licencia</h3><ul><li>Documento de Identidad (DNI), original y fotocopia de primera y segunda hoja y último cambio de domicilio (en buen estado Ley 17.671)</li><li><a href="libredeuda"  target="_blank">Certificado de Libre Deuda de Faltas (puede consultarse de manera Online en la página de inicio de este Sistema de Turnos). Entregar sólo el original. Cabe destacar que el horario de la mencionada oficina es de 8 a 12 hs, teniéndolo en cuenta para la facilidad de la tramitación.</a></li><li>Fotocopia de ambos lados de la Licencia de Conducir.</li><li>Concurrir con Licencia de Conducir si aún está en vigencia.</li><li>En cualquier caso deberán realizar el correspondiente exámen psicofísico y la prueba de aptitud acorde a las nuevas categorías solicitadas.</li><li>Sólo para profesionales, si solicita ampliar para algunas de las categorías clase C, D, y E descriptas y no se encuentra habilitado con anterioridad para ninguna de las comprendidas, deberá presentar Certificado de Reincidencias, original y fotocopia, expedida por el Registro Nacional de Reincidencias y Estadística Criminal y Carcelaria, sito en calle 13 entre 34 y 35 de La Plata, el que tiene 30 días de validez a partir de su otorgamiento. Además, deberán ser mayores de 21 años de edad.</li></ul>';
                    
            usaTerminosTramite[1]='1';
            terminoTramite[4]='';
                var sedes = new Array();
    var contentSedes = new Array();
    //Formato tramiteSeleccionado = [id,detalle,offset]
    var tramiteSeleccionado;
    //Formato sedeSeleccionada = [id,detalle]
    var sedeSeleccionada;

    //Formato turnoSeleccionado = [id,idGrupoPuesto,turnoHora,diaHoraTurno]
    var turnoSeleccionado;
    //Formato diaSeleccionado = ["YYYY-MM-DD",date()]
    var diaSeleccionado;
    var accion;
    
    $(document).ready(function() {
        $("#boton_inicio").removeClass("active");
        showPaso(pasoActual);
                            accion = "nuevo"; // Persiste la variable de javascript en modo nuevo turno
            });

    function pushSedes(id, nombre, direccion, disponible){
        contentSedes.push({id: id, nombre: nombre, direccion: direccion, disponible: disponible});
    }

    function precargarSedeYTramite(idTramiteSeleccionado, idSedeSeleccionada){


        /* Se preselecciona el trámite */
        $('#select_tramite option[value="0"]').removeAttr("selected");
        $('#select_tramite option[value="'+idTramiteSeleccionado+'"]').attr("selected","selected");
        selectTramite();
        /* Se checkea el checkbox de requisitos */
        $("#check_requisitos").attr("checked", true);
        /* Se setea la información del trámite seleccionado */
        var offsetTramiteSeleccionado = $("#select_tramite option:selected").attr('offset');
        tramiteSeleccionado = [idTramiteSeleccionado, $('select option[value="' + idTramiteSeleccionado + '"]').html(),offsetTramiteSeleccionado]
        setInfoPaso1();

        /* Se cargan las sedes */
        hidratarSedes(contentSedes);
        /* Se preselecciona la sede */
        $('#select_sede option[value="0"]').removeAttr("selected");
        $('#select_sede option[value="'+idSedeSeleccionada+'"]').attr("selected","selected");
        selectSede();
    }

    var onloadCallback = function() {
        grecaptcha.reset();
    };

    function hideErrores(){
        $("#erroresNuevoTurno").children("div").each(function() {
            $( this ).hide();
        });
    }

    function mostrarErrorGenerico(){
        $("#errorSistema").show();
    }
</script>

<script>
    function selectTramite(){
         
        var idTramiteSeleccionado = $( "#select_tramite").val();
        document.getElementById("f_tramite").value = "";
        document.getElementById("s_tramite").innerHTML = "";

        if (idTramiteSeleccionado != 0) {
            document.getElementById("f_tramite").value = idTramiteSeleccionado;
            document.getElementById("s_tramite").innerHTML = $('select option[value="' + idTramiteSeleccionado + '"]').html();

            $("#modalBodyTerminos").empty();
            //$("#requisitos_texto").empty();
            //$("#requisitos_texto").append(requisitoTramite[idTramiteSeleccionado]);
            if(usaTerminosTramite[idTramiteSeleccionado] == 1) {
                $("#modalBodyTerminos").append(terminoTramite[idTramiteSeleccionado]); 
            }
            
            $("#requisitos_tramite").show();
            var xalto = $("#requisitos_tramite").height() + 300;
            xalto = xalto + 'px';
            
            document.getElementById('div_inicio').style.height = xalto;


        } else {
            $("#requisitos_texto").empty();
            $("#requisitos_tramite").hide();
            document.getElementById('div_inicio').style.height = '300px';
        }
        $("#check_requisitos").prop('checked', false);
    }

    function validarCheckRequisitos(){

        $("#advertencia_requisitos").hide();
        if ($("#check_requisitos").is(':checked')){
            return true;
        } else {
            $("#advertencia_requisitos").show();
            return false;
        }
    }

    function validarCheckTerminos(){
        var idTramiteSeleccionado = $( "#select_tramite").val();

        $("#advertencia_terminos").hide();
        if (usaTerminosTramite[idTramiteSeleccionado] == 0 || $("#check_terminos").is(':checked')){
            return true;
        } else {
            $("#advertencia_terminos").show();
            return false;
        }
    }

    function mostrarTerminos(){
        $("#modalTerminos").modal("show");
    }

    function aceptarTerminos(){
        $("#check_terminos").prop('checked', true);
        $("#modalTerminos").modal("hide");
    }

    function elegirTramite() {
     
        desactivarBotones();
        var idTramiteSeleccionado = $("#select_tramite").val();
        
        //var offsetTramiteSeleccionado = $("#select_tramite option:selected").attr('offset');
        var offsetTramiteSeleccionado = idTramiteSeleccionado == 1 ? 1:2;
        
        pasoActual = 2;
        showPaso(2)
        tramiteSeleccionado = [idTramiteSeleccionado, $('select option[value="' + idTramiteSeleccionado + '"]').html(),offsetTramiteSeleccionado];
       
        setInfoPaso1();
        activarBotones();
        carga_datosPersonales();

    }
    function elegirTramite_old() {

        if (validarCheckRequisitos() && validarCheckTerminos()) {
            desactivarBotones();
            var idTramiteSeleccionado = $("#select_tramite").val();
            var offsetTramiteSeleccionado = $("#select_tramite option:selected").attr('offset');

            var url = '/verSedes/-1';
            url = url.replace("-1", idTramiteSeleccionado);

            $.ajax({
                type: "GET",
                dataType: 'json',
                url: url,
                async: true
            })
                    .done(function (json_response) {
                        if (json_response.error == "0") {
                            pasoActual = 2;
                            showPaso(2);
                            tramiteSeleccionado = [idTramiteSeleccionado, $('select option[value="' + idTramiteSeleccionado + '"]').html(),offsetTramiteSeleccionado];
                            setInfoPaso1();
                            var sedesContent = json_response.sedes;
                            hidratarSedes(sedesContent);
                        } else if (json_response.error == "6"){
                            $("#errorTramiteNoDisponible").show();
                            $("html, body").animate({
                                scrollTop: 0
                            }, 300);
                        } else {
                            $("#errorServicioNoDisponible").show();
                            $("html, body").animate({
                                scrollTop: 0
                            }, 300);
                        }
                        activarBotones();
                    })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        mostrarErrorGenerico();
                        activarBotones();
                    });


        }
    }
   
    function carga_datosPersonales(){

        if ($("[name='form']").length == 0) {
            
            var url ="{{ URL::to('/nuevoTurno/formdatospersonales') }}/"+$('#select_tramite').val();
           
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: url,
                async: true
            })
                    .done(function (json) {
                        if (json.error == 0) {
                            template = json.content;
                            
                            $('#formDatosPersonales').html(template);
                            pasoActual = 2;
                            showPaso(2);
                            document.getElementById('div_inicio').style.height = '550px';
                            //$("#form_idTurno").val(turnoSeleccionado[0]);
                            
                        } else {
                            mostrarErrorGenerico()
                        }
                        activarBotones();
                    })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        
                        mostrarErrorGenerico();
                        activarBotones();
                    });
        } else {
           
            activarBotones();
            pasoActual = 2;
            showPaso(2);
            //$("#form_idTurno").val(turnoSeleccionado[0]);
            grecaptcha.reset();
        }
    }



</script>
<script type="text/javascript">
    function desactivarBotones() {
        $("button[type='button']").not('#btn-collapse')
                .val("Por favor espere...")
                .attr('disabled', 'disabled')
                .hide();
        $(".gif_cargando").show();
    }
</script>
<script type="text/javascript">

    function activarBotones() {
        $("button[type='button']").not('#btn-collapse')
                .removeAttr("disabled")
                .show();
        $(".gif_cargando").hide();
    }
</script>


<script>

    function iniciarTurnosDatePiker(diasNoHabilitados, minDate, maxDate, primero){
         moment.locale('es', {
            week: { dow: 0 } // Monday is the first day of the week
        });
   
        $('#datetimepickerTurno').datetimepicker({
            inline: true,
            sideBySide: true,
            locale: 'es',
            format: 'DD/MM/YYYY',
            minDate: minDate ,
            maxDate: maxDate ,
            defaultDate: primero, 
            daysOfWeekDisabled: [0]
            //disabledDates:diasNoHabilitados
        });
        //Si cambia de dia
         
        $("#datetimepickerTurno").on("dp.change", function (e) {           
            seleccionDiaDateTimePicker(e);
        });
        //Si cambia de mes/anio
        $("#datetimepickerTurno").on("dp.update", function (e) {
            var fecha = e.viewDate.toDate();
            $("#advertencia_turno_seleccionado").hide();
            $("#btn_confirmar").hide();
            cargarCalendarioConDiasHabilitados(fecha, maxDate);
            deshabilitarDiasMesAjeno()
        }); 
    }
 
    function resetDateTimePicker(){
        if ($('#datetimepickerTurno').data("DateTimePicker") && $('#datetimepickerTurno').data("DateTimePicker") != null)
            $('#datetimepickerTurno').data("DateTimePicker").destroy();
    }

    function seleccionDiaDateTimePicker(e){
        var fecha = e.date.toDate();

        $("#advertencia_turno_seleccionado").hide();
        $("#btn_confirmar").hide();
        cargarTurnosDisponibles(fecha);
        deshabilitarDiasMesAjeno();
    }

    function actualizarCalendario(diasNoHabilitados){
        $("#datetimepickerTurno").data("DateTimePicker").disabledDates(diasNoHabilitados);
        deshabilitarDiasMesAjeno();
    }

    function deshabilitarDiasMesAjeno(){
        $(".new").removeAttr('data-action');
        $(".old").removeAttr('data-action');
    }

    function cargarTurnosDisponibles(fecha){
        
        desactivarBotones();
        limpiarTurnosDisponibles();

        var idTramiteSeleccionado = tramiteSeleccionado[0];
        //var idSedeSeleccionada =  sedeSeleccionada[0];
        
        var mes=('0'+(fecha.getMonth()+1)).slice(-2);
        var anio = fecha.getFullYear();
        var dia = ("0" + fecha.getDate()).slice(-2);
        var fechaFormato = dia+"/"+mes+"/"+anio;
        diaSeleccionado=[fechaFormato,fecha];
        var xfec = anio+'-'+mes+'-'+dia;
        var url = 'nuevoTurno/disponibles/-1/-2';
        url = url.replace("-1", idTramiteSeleccionado);
        url = url.replace("-2", xfec);
        //alert (url);
        //console.log(url);

        $.ajax({
            type: "GET",
            dataType: 'json',
            url: url,
            async: true
        })
                .done(function (json_response) {
                    if (json_response.error == "0") {
                        var horariosContent = json_response.content;
                       // alert(horariosContent);
                        procesarHorariosHabilitados(horariosContent);

                    } else {
                        alert("no entro");
                        mostrarErrorGenerico();
                    }
                    $(".gif_cargando_turnos").hide();
                    $("#datosDiaSeleccionado").show();
                    activarBotones();
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    alert("no entro 2");
                    mostrarErrorGenerico();
                    $(".gif_cargando_turnos").hide();
                    $("#datosDiaSeleccionado").show();
                    activarBotones();

                });
    }

    function limpiarTurnosDisponibles(){
        $("#turnosDisponiblesListado").empty();
        $("#bandasHorarias").empty();
        $(".gif_cargando_turnos").show();
        $("#datosDiaSeleccionado").hide();
    }

    function procesarHorariosHabilitados(contentHorarios){
        var horariosHabilitados = [];

        for (var i = 0; i < contentHorarios.turnos.length; i++){
            horariosHabilitados[i] = contentHorarios.turnos[i];
        }

        setInfoTurnosDisponibles(horariosHabilitados);
        //setInfoBandasHorarias(contentHorarios.bandasHorarias);
    }

    function obtenerAnioMes(fecha){
        var mes=('0'+(fecha.getMonth()+1)).slice(-2);
        var anio = fecha.getFullYear();
        return anio+mes;
    }

    function obtenerDatosFechaFormato(fecha, barra){
        var datosFecha=[];
        var mes=('0'+(fecha.getMonth()+1)).slice(-2);
        var anio = fecha.getFullYear();
        var dia = ("0" + fecha.getDate()).slice(-2)
        var fechaFormato;
        if (barra){
            fechaFormato = dia+"/"+mes+"/"+anio;
        }else{
            fechaFormato = anio+"-"+mes+"-"+dia;
        }
        datosFecha[0]=fechaFormato;
        datosFecha[1]=dia;
        datosFecha[2]=mes;
        datosFecha[3]=anio;
        return datosFecha;
    }

    function cargarCalendarioConDiasHabilitados(fecha, fechaMaxima){
        desactivarBotones();
        limpiarTurnosDisponibles();
        var datosFecha = obtenerDatosFechaFormato(fecha,false);
        var mes = datosFecha[2];
        var anio = datosFecha[3];
        var idTramiteSeleccionado = tramiteSeleccionado[0];
        var idSedeSeleccionada =  sedeSeleccionada[0];
        var url = '/verDiasDisponibles/-1/-2/-3/-4';
        url = url.replace("-1", idTramiteSeleccionado);
        url = url.replace("-2", idSedeSeleccionada);
        url = url.replace("-3", anio);
        url = url.replace("-4", mes);
       // console.log(url);
        $.ajax({
            type: "GET",
            dataType: 'json',
            url: url,
            async: true
        })
                .done(function (json_response) {
                    if (json_response.error == "0") {
                        var diasContent = json_response.content;
                        // Se pasa a deshabilitar la fecha máxima como workaround al bug del datetimePicker.
                        // Ver detalles en procesarDiasNoHabilitados();
                        procesarDiasNoHabilitados(diasContent, fechaMaxima);
                        var diasActivos = $(".day").filter(".active").length;
                        if (diasActivos == 0){
                            $(".day:not(.disabled):not(.old):not(.weekend)").first().addClass("active");
                        }
                        diasActivos = $(".day").filter(".active").length;
                        if (diasActivos != 0) {
                            var fechaString = $(".active").attr("data-day");
                            var arrayDatosFecha = fechaString.split("/");
                            var fecha = moment([arrayDatosFecha[2], arrayDatosFecha[1] - 1, arrayDatosFecha[0]]).toDate();
                            cargarTurnosDisponibles(fecha);
                        } else {
                            $(".gif_cargando_turnos").hide();
                        }
                    } else {
                        mostrarErrorGenerico()
                    }
                    activarBotones();
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    mostrarErrorGenerico();
                    activarBotones();
                });

    }

    function  setInfoBandasHorarias(bandasHorarias){
        $("#bandasHorarias").empty();
        for (var i = 0; i < bandasHorarias.length; i++){
            var banda = bandasHorarias[i];
            $("#bandasHorarias").append("<p>"+banda+"</p>");
        }
    }

    function procesarDiasNoHabilitados(contentDias, fechaMaxima){
        var diasNoHabilitados = [];

        for (var i = 0; i < contentDias.length; i++){
            var fechaStr = contentDias[i].fecha;
            var vals = fechaStr.split('-');
            var year = vals[0];
            var month = vals[1];
            var day = vals[2];
            var date = moment([year, month - 1, day]).toDate();
            diasNoHabilitados[i] = date;
        }
        diasNoHabilitados.push(fechaMaxima);
        // Se deshabilita el día de la fecha máxima proveida por el server +1
        // Razón? DatetimePicker tiene un bug, muestra bien las fechas deshabilitadas
        // luego de la fecha máxima especificada, pero no deja seleccionar la fecha
        // máxima misma.
        actualizarCalendario(diasNoHabilitados);

    }

    function setInfoTurnosDisponibles(turnos){
        $("#turnosDisponiblesListado").empty();
        
        if(turnos.length > 0){
            $("#turnosDisponibles").show();
            for (var i = 0; i < turnos.length; i++){
                var turno = turnos[i];
                $("#turnosDisponiblesListado").append("<button id='btn_"+turno.id_turno+"' type='button' class='btn btn-default btn-horario' onclick='selectHorario(\""+turno.hora+"\""+","+turno.id_turno+","+turno.Nro_Turno+")'>"+turno.hora+"</button>");
            }
        }else{
             
            $("#turnosDisponibles").hide();
            $("#turnosDisponiblesListado").append("<p>No hay turnos disponibles para esta fecha</p>");
            $("#turnosDisponibles").show();
        }

    }

    function obtenerFechaProximoTurno(){

        var idTramiteSeleccionado = tramiteSeleccionado[0];
        var idSedeSeleccionada =  sedeSeleccionada[0];
        var arrayFechasMinimaYMaxima = false;
        var url = '/rangoDiasDisponibles/-1/-2';
        url = url.replace("-1", idTramiteSeleccionado);
        url = url.replace("-2", idSedeSeleccionada);

        $.ajax({
            type: "GET",
            dataType: 'json',
            url: url,
            async: false
        })
                .done(function (json_response) {
                    if (json_response.error == "0") {
                        var fechaProxima = moment(json_response.content.fechaMinima).toDate();
                        var fechaMaxima = moment(json_response.content.fechaMaxima).add(1, 'd').toDate();
                        arrayFechasMinimaYMaxima = [fechaProxima, fechaMaxima];

                    } else {
                        mostrarErrorGenerico();
                        activarBotones();
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    mostrarErrorGenerico();
                    activarBotones();
                });
        return arrayFechasMinimaYMaxima;
    }

    function confirmarTurno(){
        desactivarBotones();
        var descripcionTurno = turnoSeleccionado[3];
        $("#descripcion_paso3").empty();
       // $("#descripcion_paso3").text(descripcionTurno);
        
        $("#descripcion_paso3").append("<p class='btn btn-success btn-xs'>"+descripcionTurno+"</p>")
        
        Carga_form();

        pasoActual = 4;
        showPaso(4);
        activarBotones();
        //setInfoPasoN(3,descripcionTurno);
        //elegirTurno(turnoSeleccionado[0]);
    }

    function elegirTurno(){

        if ($("[name='form']").length == 0) {
            var url = "/datosPersonales";

            $.ajax({
                type: "GET",
                dataType: 'json',
                url: url,
                async: true
            })
                    .done(function (json) {
                        if (json.error == 0) {
                            template = json.content;
                            $('#formDatosPersonales').html(template);
                            pasoActual = 4;
                            showPaso(4);
                           // $("#form_idTurno").val(turnoSeleccionado[0]);
                            if (accion == "modificar"){
                                precargarDatosPersonales();
                            }
                        } else {
                            mostrarErrorGenerico()
                        }
                        activarBotones();
                    })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        mostrarErrorGenerico();
                        activarBotones();
                    });
        } else {
            activarBotones();
            pasoActual = 4;
            showPaso(4);
            //$("#form_idTurno").val(turnoSeleccionado[0]);
            grecaptcha.reset();
        }
    }

    function selectHorario(turnoHora,turnoId,turnoIdGrupoPuesto){

        $("#advertencia_turno_seleccionado").hide();
        $("#btn_confirmar").hide();
        if(turnoSeleccionado != null){
            $("#btn_"+turnoSeleccionado[0]).removeClass("btn-success");
            $("#btn_"+turnoSeleccionado[0]).addClass("btn-default");
        }
        var diaHoraTurno = diaSeleccionado[0]+" - "+turnoHora+"hs";
        turnoSeleccionado = [turnoId,turnoIdGrupoPuesto,turnoHora, diaHoraTurno];
        $("#btn_"+turnoId).removeClass("btn-default");
        $("#btn_"+turnoId).addClass("btn-success");
        $("#advertencia_turno_seleccionado").empty();
        $("#advertencia_turno_seleccionado").append(" <p><i class='glyphicon glyphicon-info-sign'></i>  Seleccionaste turno para el "+diaSeleccionado[0]+" a las "+turnoHora+"hs </p>");

        //document.getElementById("f_nro_turno").value = turnoIdGrupoPuesto;
        document.getElementById("f_id_turno").value = turnoId;
        document.getElementById("s_id_turno").innerHTML = turnoSeleccionado[3];

        $("#advertencia_turno_seleccionado").show();
        $("#btn_confirmar").show();
    } 
    function exitmain($a,$b){
      
     //window.location="{{URL::to('inicio')}}";
     $url = "{{URL('nuevoTurno/boletapdf/')}}";
     $url += "/"+$a+"/"+$b;
      
     window.location=$url;
    
    }

    $('#formconfirma').one('submit', function() {
        document.getElementById("bt_grabar").disabled = true;
    });
</script>
@endsection