<?php

require_once 'app/error.php';

class MascotaAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/mascota/listarmascota' && $params) {//listar mascota + cliente
                    Route::get('/mascota/listarmascota/:id', 'mascotaController@listarmascotaId', $params);
                }else
                if ($ruta == '/mascota/cargarMascotaCliente' && $params) {
                    Route::get('/mascota/cargarMascotaCliente/:cliente_id', 'mascotaController@cargarMascotaCliente', $params);    
                }else
                if ($ruta == '/mascota/datatable') {
                    Route::get('/mascota/datatable', 'mascotaController@getMascotadatatable');
                }else
                if ($ruta == '/mascota/listarmascota') {//listar todo
                    Route::get('/mascota/listarmascota', 'mascotaController@listarmascota');
                } else   
                if ($ruta == '/mascota/cantidad') {
                    Route::get('/mascota/cantidad', 'mascotaController@cantidad');
                }  
                         
            break;

            case 'post':
                if($ruta == '/mascota/guardar'){
                    Route::post('/mascota/guardar', 'mascotaController@guardar');
                } else
                if ($ruta == '/mascota/fichero') {
                    Route::post('/mascota/fichero', 'mascotaController@subirFichero', true);
                }else 
                if($ruta == '/mascota/eliminar'){
                    Route::post('/mascota/eliminar', 'mascotaController@eliminarmascota');
                }                     
            break;
  
        }
    }
}
