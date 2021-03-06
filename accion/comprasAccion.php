<?php

require_once 'app/error.php';

class ComprasAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/compras/listar' && $params) {
                    Route::get('/compras/listar/:id', 'comprasController@getcomprasid',$params);
                }else  
                if ($ruta == '/compras/comprasmensuales' && $params) {
                    Route::get('/compras/comprasmensuales/:fecha_inicio/:fecha_fin', 'comprasController@rcomprasmensuales',$params);
                }else
                if ($ruta == '/compras/datatable') {
                    Route::get('/compras/datatable', 'comprasController@datatable');
                }else //listar cliente sin parametro
                if ($ruta == '/compras/listar') {
                    Route::get('/compras/listar', 'comprasController@listarcompras');
                }            
                else  
                if ($ruta == '/compras/totales') {
                    Route::get('/compras/totales', 'comprasController@comprastotales');
                } 
                else  
                if ($ruta == '/compras/mascomprada' && $params) {
                    Route::get('/compras/mascomprada/:inicio/:fin/:limite', 'comprasController@mascomprada', $params);
                }else
                if($ruta == '/compras/grafica_compra'){
                    Route::get('/compras/grafica_compra', 'comprasController@grafica_compra');
                } else
                if($ruta == '/compras/grafica_general'){
                    Route::get('/compras/grafica_general', 'comprasController@grafica_general');
                }      

                 
            break;

            case 'post':
                if($ruta == '/compras/guardar'){
                    Route::post('/compras/guardar', 'comprasController@guardar');
                } else
                if($ruta == '/compras/eliminar'){
                    Route::post('/compras/eliminar', 'comprasController@eliminar');
                }else
                if($ruta == '/compras/editar'){
                    Route::post('/compras/editar', 'comprasController@editar');
                }                       
            break; 
  
        }
    }
}
