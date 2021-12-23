<?php

require_once 'app/error.php';

class SexoAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/sexo/listar') {
                    Route::get('/sexo/listar', 'sexoController@getSexo');
                } 
                
                break;

            case 'post':                     
                break;
  
        }
    }
}
