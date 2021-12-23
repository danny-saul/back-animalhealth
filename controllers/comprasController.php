<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'app/helper.php';
require_once 'models/comprasModel.php';
require_once 'controllers/detalle_compraController.php';

class ComprasController
{

    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();

    }

    

    public function listarcompras()
    {
        $this->cors->corsJson();
        $response = [];
        $datacompras = Compras::where('estado', 'A')->get();

        if ($datacompras) {
            foreach ($datacompras as $compr) {
                $compr->proveedor;
                $compr->usuario;

            }
            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'compras' => $datacompras,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existen datos',
                'compras' => null,
            ];
        }
        echo json_encode($response);
    }

    public function guardar(Request $request){
        $this->cors->corsJson();
        $datarequestcompra = $request->input('compra');
        $datarequestdetallecompra = $request->input('detalle_compra');
        $response=[];
        $numero_compra= $datarequestcompra->numero_compra;
        if($datarequestcompra){
            $existecodigocompra=Compras::where('numero_compra',$numero_compra)->get()->first();
            if($existecodigocompra){
                $response=[
                    'status'=>false,
                    'mensaje'=>'El numero de la compra ya existe',
                    'compra'=>null,
                ];
            }else{
                $nuevacompra= new Compras();
                $nuevacompra->proveedor_id=intval($datarequestcompra->proveedor_id);
                $nuevacompra->usuario_id=intval($datarequestcompra->usuario_id);
                $nuevacompra->numero_compra=$datarequestcompra->numero_compra;
                $nuevacompra->descuento=floatval($datarequestcompra->descuento);
                $nuevacompra->subtotal=floatval($datarequestcompra->subtotal);
                $nuevacompra->iva=floatval($datarequestcompra->iva);
                $nuevacompra->total=floatval($datarequestcompra->total);
                $nuevacompra->iva=floatval($datarequestcompra->iva);
                $nuevacompra->fecha_compra= $datarequestcompra->fecha_compra;
                $nuevacompra->estado='A';

                if($nuevacompra->save()){
                    $detallecompracontroller = new Detalle_CompraController();
                    $det_compra = $detallecompracontroller->guardar_detallecompra($nuevacompra->id, $datarequestdetallecompra);
                    
                    $response=[
                        'status'=>true,
                        'mensaje'=>'La compra se ha guardado',
                        'compra'=>$nuevacompra,
                        'detalle_compra'=>$det_compra,
                    ];   
                }else{
                    $response=[
                        'status'=>false,
                        'mensaje'=>'La compra no se ha guardado',
                        'compra'=>null,
                    ];

                }
 

            }
        }else{
            $response=[
                'status'=>false,
                'mensaje'=>'No hay datos para procesar',
                'compra'=>$response,
            ];
        }

        echo json_encode($response);

    }
}