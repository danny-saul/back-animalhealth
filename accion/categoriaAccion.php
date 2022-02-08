<?php

require_once 'app/error.php';

class CategoriaAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/categoria/datatablecategoria') {
                    Route::get('/categoria/datatablecategoria', 'categoriaController@datatablecategoria');
                }else
                if ($ruta == '/categoria/listar') {
                    Route::get('/categoria/listar', 'categoriaController@listarcategoria');
                }else
                if($ruta == '/categoria/grafica_porcentaje'){
                    Route::get('/categoria/grafica_porcentaje', 'categoriaController@grafica_porcentaje');
                }
                else
                if ($ruta == '/categoria/buscarCategoriaProducto' && $params) {
                    Route::get('/categoria/buscarCategoriaProducto/:id', 'categoriaController@buscarCategoriaProducto', $params);
                }   else   
                if ($ruta == '/categoria/cantidad') {
                    Route::get('/categoria/cantidad', 'categoriaController@cantidad');
                }    
                         
            break;

            case 'post':
                if ($ruta == '/categoria/guardarcategoria') {
                    Route::post('/categoria/guardarcategoria', 'categoriaController@guardarcategoria');
                } 
                         
            break;

           
  
        }
    }
}
