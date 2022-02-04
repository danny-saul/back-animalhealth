<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/inventarioModel.php';

class InventarioController
{

    private $cors;


    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function guardarIngresoProducto($id_transaccion, $detalles = [], $tipo)
    {
        $response = [];
        $extra = [];

        if (count($detalles) > 0) {
            foreach ($detalles as $item) {
                $nuevo = new Inventario;
                $producto_id = intval($item->producto_id);
                $aux = intval($item->cantidad);
                $cantidad = ($tipo == 'E') ? $aux : ((-1) * $aux);

                $nuevo->producto_id = $producto_id;
                $nuevo->transaccion_id = intval($id_transaccion);
                $nuevo->tipo = $tipo;
                $nuevo->cantidad = $cantidad;
                //verifica si existe un registro anterior del producto
                $existe = Inventario::where('producto_id', $producto_id)->get()->count();

                if ($existe == 0) { //primer registro
                    $nuevo->cantidad_disponible = $cantidad;
                    $extra = $this->tipo_inventario_first($tipo, $nuevo);
                } else { //segundo o mas registro registro
                    $extra = $this->tipo_inventario_mas_registro($tipo, $nuevo);
                }
            }
            $response = [
                'status' => true,
                'mensaje' => 'Inventario actualizado correctamente',
                'extra' => $extra,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se ha actualizado el inventario',
            ];
        }
        return $response;
    }

    private function tipo_inventario_first($tipo, Inventario $inventario)
    {
        $response = [];

        if ($tipo == 'E') {
            //guardar
            $inventario->save();

            $response = [
                'status' => true,
                'mensaje' => 'Primer movimiento del producto ' . $inventario->producto_id,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay productos en stock disponible, realice compras',
            ];
        }
        return $response;
    }

    private function tipo_inventario_mas_registro($tipo, Inventario $inventario)
    {
        $response = [];
        $ultimo = Inventario::where('producto_id', $inventario->producto_id)
            ->orderBy('id', 'DESC')->get()->first();

        $cantidad = $inventario->cantidad + $ultimo->cantidad_disponible; //suma
        $inventario->cantidad_disponible = $cantidad;

        if ($tipo == 'S') { //salida
            $cantidad = ($inventario->cantidad * (-1)) - $ultimo->cantidad_disponible; //resta
            $inventario->cantidad_disponible = abs($cantidad);
        }

        if ($inventario->save()) {
            $response = [
                'status' => true,
                'mensaje' => 'Inventario actualizado ' . $inventario->producto_id,
                'inventario' => $inventario,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se pudo actualizar el inventario',
                'inventario' => $inventario,
            ];
        }
        return $response;
    }

    public function verinventario($params)
    {
        $this->cors->corsJson();
        $id_producto = intval($params['id_producto']);
        $dataInventario = Inventario::where('producto_id',$id_producto)->get();
        $data = [];   $i = 1;

        foreach($dataInventario as $inv){
            $inv->producto;
            $inv->transaccion;

            $entrada = []; $salida = []; $tipo = ''; $fecha = date_format($inv->created_at,'Y-m-d');

            if($inv->transaccion->tipo_movimiento == 'E'){
                $entrada = [0 => $inv->cantidad];   $salida = [0 => ''];   $tipo = 'Entrada';
            }else{
                $salida = [0 => abs($inv->cantidad)];   $entrada = [0 => ''];   $tipo = 'Salida';
            }

            $data [] = [
                0 => $i,
                1 => $fecha,
                2 => $tipo,
                3 => $entrada[0],
                4 => $salida[0],
                5 => $inv->cantidad_disponible
            ];
            $i++;
        }
        $result = [
            'sEcho' => 1,
            'iTotalRecords' => count($dataInventario),
            'iTotalDisplayRecords' => count($dataInventario),
            'aaData' => $data,
        ];
        echo json_encode($result); 

    }
}
