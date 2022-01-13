<?php

require_once 'app/error.php';

class CitasAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/citas/listar' && $params) {
                    Route::get('/citas/listar/:id', 'citasController@getcitasId',$params);
                } else
                if ($ruta == '/citas/datatable') {
                    Route::get('/citas/datatable', 'citasController@datatablecita');
                }else //listar citas pendientes
                if ($ruta == '/citas/pendientes' && $params) {
                    Route::get('/citas/pendientes/:persona_id/:estado_id', 'citasController@listarcitasPendientes',$params);
                }else 
                if ($ruta == '/citas/actualizar_cita' && $params) {
                    Route::get('/citas/actualizar_cita/:id_cita/:estado_id', 'citasController@actualizarCitaPendientes',$params);
                }else 
                if ($ruta == '/citas/cancelar' && $params) {
                    Route::get('/citas/cancelar/:id_cita/:estado_id', 'citasController@cancelar',$params);
                }                
            break;

            case 'post':
                if($ruta == '/citas/guardar'){
                    Route::post('/citas/guardar', 'citasController@guardar');
                } 
                /*else
                if($ruta == '/citas/editar'){
                    Route::post('/citas/editar', 'citasController@editar');
                } */                       
            break; 
  
        }
    }
}
