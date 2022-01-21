<?php

require_once 'app/error.php';

class ConfiguracionAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/configuracion/listar' && $params) {
                    Route::get('/configuracion/listar/:id', 'configuracionController@configuracionlistar',$params);
                } 
                         
            break;

            case 'post':
             
                if($ruta == '/configuracion/editar'){
                    Route::post('/configuracion/editar', 'configuracionController@editar');
                }else 
                  if($ruta == '/configuracion/actualizarprecioventa'){
                    Route::post('/configuracion/actualizarprecioventa', 'configuracionController@actualizarpventa');
                }       
                         
            break;

           
  
        }
    }
}
