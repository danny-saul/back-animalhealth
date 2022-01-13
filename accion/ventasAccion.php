<?php

require_once 'app/error.php';

class VentasAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/ventas/listar' && $params) {
                    Route::get('/ventas/listar/:id', 'ventasController@getventasid',$params);
                }else
                if ($ruta == '/ventas/datatable') {
                    Route::get('/ventas/datatable', 'ventasController@datatable');
                }else //listar cliente sin parametro
                if ($ruta == '/ventas/listar') {
                    Route::get('/ventas/listar', 'ventasController@listarventas');
                }            
            break;

            case 'post':
                if($ruta == '/ventas/guardar'){
                    Route::post('/ventas/guardar', 'ventasController@guardar');
                } else
                if($ruta == '/ventas/eliminar'){
                    Route::post('/ventas/eliminar', 'ventasController@eliminar');
                }else
                if($ruta == '/ventas/editar'){
                    Route::post('/ventas/editar', 'ventasController@editar');
                }                       
            break; 
  
        }
    }
}
