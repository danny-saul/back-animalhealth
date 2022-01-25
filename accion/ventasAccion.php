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
                if ($ruta == '/ventas/ventasmensuales' && $params) {
                    Route::get('/ventas/ventasmensuales/:fecha_inicio/:fecha_fin', 'ventasController@rventasmensuales',$params);
                }else
                if ($ruta == '/ventas/datatable') {
                    Route::get('/ventas/datatable', 'ventasController@datatable');
                }else //listar cliente sin parametro
                if ($ruta == '/ventas/listar') {
                    Route::get('/ventas/listar', 'ventasController@listarventas');
                }  
                else  
                if ($ruta == '/ventas/totales') {
                    Route::get('/ventas/totales', 'ventasController@ventastotales');
                }else  
                if ($ruta == '/ventas/masvendido' && $params) {
                    Route::get('/ventas/masvendido/:inicio/:fin/:limite', 'ventasController@masvendido', $params);
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
