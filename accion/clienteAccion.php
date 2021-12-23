<?php

require_once 'app/error.php';

class ClienteAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/cliente/listar' && $params) {
                    Route::get('/cliente/listar/:id', 'clienteController@getClienteId',$params);
                }else
                if ($ruta == '/cliente/datatable') {
                    Route::get('/cliente/datatable', 'clienteController@datatable');
                }else //listar cliente sin parametro
                if ($ruta == '/cliente/listar') {
                    Route::get('/cliente/listar', 'clienteController@listarCliente');
                }                
            break;

            case 'post':
                if($ruta == '/cliente/guardar'){
                    Route::post('/cliente/guardar', 'clienteController@guardar');
                }else
                if($ruta == '/cliente/eliminar'){
                    Route::post('/cliente/eliminar', 'clienteController@eliminar');
                }else
                if($ruta == '/cliente/editar'){
                    Route::post('/cliente/editar', 'clienteController@editar');
                }                       
            break; 
  
        }
    }
}
