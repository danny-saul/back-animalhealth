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
    private $limite=5;

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
        $nuevohelper=new Helper();
        $nuevonumerocompra= $nuevohelper->generate_key($this->limite);
        
        if($datarequestcompra){
            $existecodigocompra=Compras::where('numero_compra',$nuevonumerocompra)->get()->first();
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
                $nuevacompra->numero_compra= $nuevonumerocompra;
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

    public function datatable()
    {     
        $this->cors->corsJson();
        $datavercompra = Compras::where('estado', 'A')->get();
        $data = [];   $i = 1;

        foreach ($datavercompra as $dc) {
    
            $icono = $dc->estado == 'I' ? '<i class="fa fa-check-circle fa-lg"></i>' : '<i class="fa fa-trash fa-lg"></i>';
            $clase = $dc->estado == 'I' ? 'btn-success btn-sm' : 'btn-dark btn-sm';
            $other = $dc->estado == 'A' ? 0 : 1;

            $botones = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm" onclick="ver_detalleCompra(' . $dc->id . ')">
                            <i class="fas fa-vote-yea"></i>
                            </button>
                        
                        </div>';

            $data[] = [
                0 => $i,
                1 => $dc->fecha_compra,
                2 => $dc->numero_compra,
                3 => $dc->proveedor->razon_social,
                4 => $dc->total,
                5 => $botones,
            ];
            $i++;
        }

        $result = [
            'sEcho' => 1,
            'iTotalRecords' => count($data),
            'iTotalDisplayRecords' => count($data),
            'aaData' => $data,
        ];
        echo json_encode($result);

    }

    public function getcomprasid($params){
        $this->cors->corsJson();
        $id = intval($params['id']);
        $response = [];
        $compras = Compras::find($id);

        if($compras){

            $compras->proveedor;
            $compras->usuario->persona;

            foreach ($compras->detalle_compra as $subbuscar) { 
                $subbuscar->producto;
            }


            $response = [
                'status' => true,
                'mensaje' => 'hay datos',
                'compra' => $compras,
                'detalle_compra' => $compras->detalle_compra,
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'no ahi datos',
                'compra' => null
            ];
        }
        echo json_encode($response);
    }
}