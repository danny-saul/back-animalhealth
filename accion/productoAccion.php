<?php

require_once 'app/error.php';

class ProductoAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {
        switch ($metodo_http) {
            case 'get':
                if($ruta == '/producto/listar' && $params){
                    Route::get('/producto/listar/:id', 'productoController@listarproductoId',$params);
                }else
                if ($ruta == '/producto/listarproducto') {//listar mascota + cliente
                    Route::get('/producto/listarproducto', 'productoController@listarproducto');
                }else
                if ($ruta == '/producto/datatableproducto') {
                    Route::get('/producto/datatableproducto', 'productoController@datatableproducto');
                } else
                if ($ruta == '/producto/grafica_stock') {
                    Route::get('/producto/grafica_stock', 'productoController@graficaStock');
                }         
            break;

            case 'post':
                if ($ruta == '/producto/guardarproducto') {
                    Route::post('/producto/guardarproducto', 'productoController@guardarproducto');
                } else
                if ($ruta == '/producto/fichero') {
                    Route::post('/producto/fichero', 'productoController@subirFichero', true);
                } else
                if ($ruta == '/producto/editarproducto') {
                    Route::post('/producto/editarproducto', 'productoController@editarProducto');
                } else
                if ($ruta == '/producto/eliminarproducto') {
                    Route::post('/producto/eliminarproducto', 'productoController@eliminarproducto');
                }
                
                         
            break;

           
  
        }
    }
}
