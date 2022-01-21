<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'models/productoModel.php';
require_once 'models/detalle_ventaModel.php';


class Detalle_VentaController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function guardar_detalleventa($ventas_id, $detalle=[]){
        $response =[];
        if(count($detalle) > 0){
            foreach ($detalle as $det){
                $nuevo = new Detalle_Venta();
                $nuevo->ventas_id=intval($ventas_id);
                $nuevo->producto_id=intval($det->producto_id);
                $nuevo->cantidad=intval($det->cantidad);
                $nuevo->precio_venta=doubleval($det->precio_venta);
                $nuevo->total=doubleval($det->total);
                $nuevo->save();

                $stock = $nuevo->cantidad;
                //actualizar producto
                $this->actualizar_producto($det->producto_id, $stock, $det->precio_venta);
            }
        }else{
            $response=[
                'status'=>false,
                'mensaje'=>'no hay productos para guardar',
                'detalle_venta'=>null
            ];
        }
        return $response;
    }

    protected function actualizar_producto($producto_id, $stock, $precio_venta){
        $producto=Producto::find($producto_id);
        $producto->stock -= $stock;
        $producto->precio_venta = $precio_venta;
    
        $producto->save();       
    }

}