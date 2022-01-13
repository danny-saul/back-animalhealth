<?php

require_once 'app/error.php';

class ClienteoAccion
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
             
                if ($ruta == '/clienteo/guardarRolCliente') {
                    Route::post('/clienteo/guardarRolCliente', 'clienteoController@guardarRolCliente'); 
                }else {
                    ErrorClass::e(404, "La ruta no existe");
                }                      
            break; 
  
        }
    }
}
