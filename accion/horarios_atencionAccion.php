<?php

require_once 'app/error.php';

class Horarios_AtencionAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/horarios_atencion/listar') {
                    Route::get('/horarios_atencion/listar', 'horarios_atencionController@Horarioatencion');
                } else
                if ($ruta == '/horarios_atencion/libre' && $params) {
                    Route::get('/horarios_atencion/libre/:asignacion', 'horarios_atencionController@horarioAtencionlibre', $params);
                }else
                if ($ruta == '/horarios_atencion/doctor' && $params) {
                    Route::get('/horarios_atencion/doctor/:id', 'horarios_atencionController@doctorHorario', $params);
                }else
                if ($ruta == '/horarios_atencion/listarH' && $params) {
                    Route::get('/horarios_atencion/listarH/:id', 'horarios_atencionController@horarioAlistar', $params);
                }else
                if ($ruta == '/horarios_atencion/listarHorasdatatable') {
                    Route::get('/horarios_atencion/listarHorasdatatable', 'horarios_atencionController@listarHorasDoctorDt');
                }
                
                break;

            case 'post': 
                if ($ruta == '/horarios_atencion/guardar') {
                    Route::post('/horarios_atencion/guardar', 'horarios_atencionController@guardar');
                }else
                if ($ruta == '/horarios_atencion/saveDoctorHorarioAtencion') {
                    Route::post('/horarios_atencion/saveDoctorHorarioAtencion', 'horarios_atencionController@saveDoctorHorarioAtencion');
                }else
                if ($ruta == '/horarios_atencion/editarDoctorHorarioAtencion') {
                    Route::post('/horarios_atencion/editarDoctorHorarioAtencion', 'horarios_atencionController@editarDoctorHorarioAtencion');
                }
                else
                if ($ruta == '/horarios_atencion/eliminarHorasDotor') {
                    Route::post('/horarios_atencion/eliminarHorasDotor', 'horarios_atencionController@eliminarhorasdoctor');
                }                    
                break;

                case 'delete':
                    if ($params) {
                        if ($ruta == '/horarios_atencion/eliminarDoctorHorarioAtencion') {
                            Route::delete('/horarios_atencion/eliminarDoctorHorarioAtencion/:id_horario_atencion/:id_doctor', 'horarios_atencionController@eliminarDoctorHorarioAtencion', $params);
                        } 
                    } else {
                        ErrorClass::e('400', 'No ha enviado parámetros por la url');
                    }
                    break;
  
        }
    }
}
