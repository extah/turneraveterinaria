<?php

namespace App\Libraries\ePagos;

/**
 * Description of ConstanteServicioPago
 * 
 */
class ConstanteServicioPago {

    // Cambiar para pasar de prod a dev (dev/prod)
    const AMBIENTE_SERVICIOS = 'prod';

    /* CREDENCIALES */
    const USUARIO = "API Berisso";
    const ID_ORGANISMO = 114;
    
//    SANDBOX
//    const ID_USUARIO = 923;
///    const PASSWORD = "740ecf5c8c9c3bf02adec606208ff20b";
 //   const HASH = "0e246ba55ebc45f3df4aa733b507d13a";
    
//    PROD
    const ID_USUARIO = 9855;
    const PASSWORD = "4565fb4cd28bd6ec83870248b685328f";
    const HASH = "9b90ce912cbedd457c868e9ec7291f83";

//    const ID_USUARIO = 9855;
//    const PASSWORD = "9b90ce912cbedd457c868e9ec7291f83";
//    const HASH = "4565fb4cd28bd6ec83870248b685328f";

 
    
    //
    const CONVENIO_HOMEBANKING = "00114";
    const CONVENIO_EFECTIVO = "10114";
    const CONVENIO_TARJETA_CREDITO = "20114";
    const CONVENIO_E_TRANSFERENCIA = "30114";
    const CONVENIO_TARJETA_DEBITO = "40114";
    
    const FORMA_PAGO_COMBINADO = 34;
    
    //
    const URL_OK = "https://postsandbox.epagos.com.ar/tests/ok.php";
    const URL_ERROR = "https://postsandbox.epagos.com.ar/tests/error.php";
    //
    /*
     *  02001   Correcta  Pago acreditado
     *  02002   Correcta  Pago pendiente
     *  02003   Error     Error al validar el token
     *  02004   Error     Pago cancelado / rechazado
     *  02005   Error     Error interno al intentar procesar el pago
     *  02006   Error     Error al validar el parámetro: [_parametro_]
     *  02007   Error     El usuario canceló el pago
     *  02008   Error     No coinciden los montos y los detalles
     *  02009   Error     La forma de pago [_parametro_] no se encuentra disponible
     *  02010   Error     Error del proveedor de servicios online
     */
    const E_PAGOS_RESP_PAGO_ACREDITADO = "02001";
    const E_PAGOS_RESP_PAGO_PENDIENTE = "02002";

}
