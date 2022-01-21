<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'models/productoModel.php';
require_once 'models/detalle_compraModel.php';


class Detalle_CompraController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function guardar_detallecompra($compras_id, $detalle=[]){
        $response =[];
        if(count($detalle) > 0){
            foreach ($detalle as $det){
                $nuevo = new Detalle_Compra();
                $nuevo->compras_id=intval($compras_id);
                $nuevo->producto_id=intval($det->producto_id);
                $nuevo->cantidad=intval($det->cantidad);
                $nuevo->precio_compra=doubleval($det->precio_compra);
                $nuevo->total=doubleval($det->total);
                $nuevo->save();

                $stock = $nuevo->cantidad;
                //actualizar producto
                $this->actualizar_producto($det->producto_id, $stock, $det->precio_compra);
            }
        }else{
            $response=[
                'status'=>false,
                'mensaje'=>'no hay productos para guardar',
                'detalle_compra'=>null
            ];
        }
        return $response;
    }

    protected function actualizar_producto($producto_id, $stock, $precio_compra){
        $producto=Producto::find($producto_id);
        $producto->stock += $stock;
        $producto->precio_compra = $precio_compra;
        $producto->save();       
    }

}