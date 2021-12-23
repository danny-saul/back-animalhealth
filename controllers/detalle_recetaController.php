<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'models/productoModel.php';
require_once 'models/detalle_recetaModel.php';


class Detalle_RecetaController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function guardar_detallereceta($receta_id, $detalle=[]){
        $response =[];
        if(count($detalle) > 0){
            foreach ($detalle as $det){
                $nuevo = new Detalle_Receta();
                $nuevo->receta_id=intval($receta_id);
                $nuevo->producto_id=intval($det->producto_id);
                $nuevo->cantidad=intval($det->cantidad);
                $nuevo->total=intval($det->total);
                $nuevo->save();

                $stock = $nuevo->cantidad * (-1);
                //actualizar producto
                $this->actualizar_producto($det->producto_id, $stock);
            }
        }else{
            $response=[
                'status'=>false,
                'mensaje'=>'no hay productos para guardar',
                'detalle_receta'=>null
            ];
        }
        return $response;
    }

    protected function actualizar_producto($producto_id, $stock){
        $producto=Producto::find($producto_id);
        $producto->stock += $stock;
        $producto->save();       
    }

}