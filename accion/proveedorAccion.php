<?php

require_once 'app/error.php';

class ProveedorAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/proveedor/listar' && $params) {
                    Route::get('/proveedor/listar/:id', 'proveedorController@getProveedorid',$params);
                }else
                if ($ruta == '/proveedor/datatable') {
                    Route::get('/proveedor/datatable', 'proveedorController@datatable');
                }else //listar cliente sin parametro
                if ($ruta == '/proveedor/listar') {
                    Route::get('/proveedor/listar', 'proveedorController@listarproveedor');
                }
                else   
                if ($ruta == '/proveedor/cantidad') {
                    Route::get('/proveedor/cantidad', 'proveedorController@cantidad');
                }                   
            break;

            case 'post':
                if($ruta == '/proveedor/guardar'){
                    Route::post('/proveedor/guardar', 'proveedorController@guardar');
                } else
                if($ruta == '/proveedor/eliminar'){
                    Route::post('/proveedor/eliminar', 'proveedorController@eliminar');
                }else
                if($ruta == '/proveedor/editar'){
                    Route::post('/proveedor/editar', 'proveedorController@editar');
                }                       
            break; 
  
        }
    }
}
