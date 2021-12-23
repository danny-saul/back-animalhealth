<?php

require_once 'app/error.php';

class DoctorAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/doctor/listar' && $params) {
                    Route::get('/doctor/listar/:id', 'doctorController@getDoctorId',$params);
                }else
                if ($ruta == '/doctor/listar') {
                    Route::get('/doctor/listar', 'doctorController@getDoctor');
                }else
                if ($ruta == '/doctor/listarArray') {
                    Route::get('/doctor/listarArray', 'doctorController@listarArray');
                }
                else
                if ($ruta == '/doctor/datatable') {
                    Route::get('/doctor/datatable', 'doctorController@getDoctordatatable');
                }else
                if ($ruta == '/doctor/search' && $params) {
                    Route::get('/doctor/search/:texto', 'doctorController@searchDoctor', $params);
                }                   
            break;

            case 'post':
                if($ruta == '/doctor/eliminar'){
                    Route::post('/doctor/eliminar', 'doctorController@eliminar');
                }else
                if($ruta == '/doctor/editar'){
                    Route::post('/doctor/editar', 'doctorController@editar');
                }                       
            break;
  
        }
    }
}
