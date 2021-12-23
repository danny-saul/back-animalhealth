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
