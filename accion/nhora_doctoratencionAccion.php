<?php

require_once 'app/error.php';

class Nhora_DoctoratencionAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/nhora_doctoratencion/listar') {
                    Route::get('/nhora_doctoratencion/listar', 'nhora_doctoratencionController@getHoradoctoratencion');
                } 
                
                break;

            case 'post':                     
                break;
  
        }
    }
}
