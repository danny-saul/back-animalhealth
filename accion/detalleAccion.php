<?php

require_once 'app/error.php';

class DetalleAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/detalle/listardetalle') {
                    Route::get('/detalle/listardetalle', 'detalleController@listardetalle');
                } 
                         
            break;

            case 'post':
              /*    if ($ruta == '/sastifaccion/guardar') {
                    Route::post('/sastifaccion/guardar', 'sastifaccionController@guardarsastifaccion');
                }   */
                         
            break;

           
  
        }
    }
}
