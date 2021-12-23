<?php

require_once 'app/error.php';

class RolAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
              if ($ruta == '/rol/listar' && $params) {
                    Route::get('/rol/listar/:id', 'rolController@listarID',$params);
                } else
                if ($ruta == '/rol/listar') {
                    Route::get('/rol/listar', 'rolController@getRoles');
                }else
                if ($ruta == '/rol/listarcliente') {
                    Route::get('/rol/listarcliente', 'rolController@getRolesClientes');
                }
                

                
                break;

            case 'post':
                if ($ruta == '/rol/guardar') {
                    Route::post('/rol/guardar', 'rolController@guardar');
                }
                
     
                break;
  
        }
    }
}
