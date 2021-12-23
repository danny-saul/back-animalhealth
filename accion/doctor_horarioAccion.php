<?php

require_once 'app/error.php';

class Doctor_HorarioAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                /* if ($ruta == '/doctor_horario/verTodo') {
                    Route::get('/doctor_horario/verTodo', 'doctor_horarioController@verTodo');
                }  */
              
                break;

            case 'post':                     
                break;
  
        }
    }
}
