<?php

require_once 'app/error.php';

class Historial_ClinicoAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/historial_clinico/generar_codigos' && $params) {
                    Route::get('/historial_clinico/generar_codigos/:tipos', 'historial_clinicoController@generar_codigos',$params);
                }
                         
            break;

            case 'post':
                if ($ruta == '/historial_clinico/guardarhistorial_clinico') {
                    Route::post('/historial_clinico/guardarhistorial_clinico', 'historial_clinicoController@guardarhistorial_clinico');
                } else 
                if ($ruta == '/historial_clinico/aumentar') {
                    Route::post('/historial_clinico/aumentar', 'historial_clinicoController@aumentarCodigo');
                }
                         
            break;

           
  
        }
    }
}
