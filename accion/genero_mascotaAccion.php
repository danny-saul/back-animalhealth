<?php

require_once 'app/error.php';

class Genero_MascotaAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/genero_mascota/listar') {
                    Route::get('/genero_mascota/listar', 'genero_mascotaController@getGenero_mascota');
                } 
                
                break;

            case 'post':                     
                break;
  
        }
    }
}
