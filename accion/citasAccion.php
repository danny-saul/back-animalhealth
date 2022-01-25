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
                else
                if ($ruta == '/citas/datatableclientecitaId' && $params ) {
                    Route::get('/citas/datatableclientecitaId/:cliente_id', 'citasController@datatableclientecitaId',$params);
                }else
                if ($ruta == '/citas/serviciomasAdquirido' && $params) {
                    Route::get('/citas/serviciomasAdquirido/:inicio/:fin/:limite','citasController@serviciomasAdquirido',$params);
                }            
                else
                if ($ruta == '/citas/citasagendamientospordoctor' && $params) {
                    Route::get('/citas/citasagendamientospordoctor/:inicio/:fin/:doctor_id','citasController@agendamientospormedicos',$params);
                }      
                else
                if ($ruta == '/citas/mascotasmasantendidas' && $params) {
                    Route::get('/citas/mascotasmasantendidas/:inicio/:fin/:cliente_id','citasController@mascotasmasatendidas',$params);
                }  
            break;
            
            
            case 'post':
                if($ruta == '/citas/guardar'){
                    Route::post('/citas/guardar', 'citasController@guardar');
                } 
                else
                if($ruta == '/citas/guardar2'){
                    Route::post('/citas/guardar2', 'citasController@guardarcliente');
                }                      
            break; 
  
        }
    }
}
