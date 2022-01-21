<?php

require_once 'app/error.php';

class Doctor_HorarioAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/doctor_horario/listarDoctorHorario' && $params) {
                    Route::get('/doctor_horario/listarDoctorHorario/:id_doctor/:dia', 'doctor_horarioController@listarDoctorHorario',$params);
                }else
                if ($ruta == '/doctor_horario/verhorario') {
                    Route::get('/doctor_horario/verhorario', 'doctor_horarioController@verhorariod');
                }
                else
                if ($ruta == '/doctor_horario/buscarDoctor') {
                    Route::get('/doctor_horario/buscarDoctor', 'doctor_horarioController@buscarDoctor');
                }
              
                break;

            case 'post':                     
                break;
  
        }
    }
}
