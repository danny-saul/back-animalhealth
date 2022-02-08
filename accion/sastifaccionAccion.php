<?php

require_once 'app/error.php';

class SastifaccionAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/sastifaccion/sastifaccionkpi') {
                    Route::get('/sastifaccion/sastifaccionkpi', 'sastifaccionController@sastifaccionkpi');
                } 
                         
            break;

            case 'post':
                 if ($ruta == '/sastifaccion/guardar') {
                    Route::post('/sastifaccion/guardar', 'sastifaccionController@guardarsastifaccion');
                }  
                         
            break;

           
  
        }
    }
}
