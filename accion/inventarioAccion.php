<?php

require_once 'app/error.php';

class InventarioAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
              if ($ruta == '/inventario/ver' && $params) {
                    Route::get('/inventario/ver/:id_producto', 'inventarioController@verinventario', $params);
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
