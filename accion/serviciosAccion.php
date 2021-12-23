<?php

require_once 'app/error.php';

class ServiciosAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
              if ($ruta == '/servicios/listar') {
                    Route::get('/servicios/listar', 'serviciosController@listarServicios');
                }  
                
                break;

            case 'post':
              /*   if ($ruta == '/rol/guardar') {
                    Route::post('/rol/guardar', 'rolController@guardar');
                } */
                
     
                break;
  
        }
    }
}
