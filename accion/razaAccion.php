<?php

require_once 'app/error.php';

class RazaAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/raza/listar') {
                    Route::get('/raza/listar', 'razaController@getRaza');
                }else 
                if ($ruta == '/raza/buscar' && $params) {
                    Route::get('/raza/buscar/:texto', 'razaController@BuscarRaza',$params );
                }  
                
                break;

            case 'post':                     
                break;
  
        }
    }
}
