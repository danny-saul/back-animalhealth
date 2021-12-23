<?php

require_once 'app/error.php';

class Horarios_CitasAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
              if ($ruta == '/horarios_citas/listar') {
                    Route::get('/horarios_citas/listar', 'horarios_citasController@listarHorarios_Citas');
                }  
                
                break;

            case 'post':
              /*   if ($ruta == '/rol/guardar') {
                    Route::post('/rol/guardar', 'rolController@guardar');
                } */
                
     
                break;
  
        }
    }
}
