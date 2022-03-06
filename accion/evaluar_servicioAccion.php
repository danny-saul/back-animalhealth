<?php

require_once 'app/error.php';

class Evaluar_ServicioAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/evaluar_servicio/evaluar_serviciokpi') {
                    Route::get('/evaluar_servicio/evaluar_serviciokpi', 'evaluar_servicioController@servicioevaluarkpi');
                } 
                         
            break;

            case 'post':
                 if ($ruta == '/evaluar_servicio/guardar') {
                    Route::post('/evaluar_servicio/guardar', 'evaluar_servicioController@guardarevaluarservicio');
                }  
                         
            break;

           
  
        }
    }
}
