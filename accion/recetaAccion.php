<?php

require_once 'app/error.php';

class RecetaAccion
{

    public function __construct()
    {
         
    }

    //Configurar rutas y controllers
    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                /* if ($ruta == '/receta/listar' && $params) {
                    Route::get('/receta/listar/cita_id','recetaController@recetasId',$params);
                }  */
                break;

            case 'post':
                if ($ruta == '/receta/guardar') {
                    Route::post('/receta/guardar', 'recetaController@guardarreceta'); 
                }  
                break;

        }
    }
}
