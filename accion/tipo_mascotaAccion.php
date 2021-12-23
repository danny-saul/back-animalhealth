<?php

require_once 'app/error.php';

class Tipo_MascotaAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/tipo_mascota/listar') {
                    Route::get('/tipo_mascota/listar', 'tipo_mascotaController@getTipo_mascota');
                } 
                
                break;

            case 'post':                     
                break;
  
        }
    }
}
