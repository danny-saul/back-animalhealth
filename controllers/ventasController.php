<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'app/helper.php';
require_once 'models/ventasModel.php';
require_once 'controllers/detalle_ventaController.php';


class VentasController
{

    private $cors;
    private $limite=5;

    public function __construct()
    {
        $this->cors = new Cors();

    }


    public function listarventas()
    {
        $this->cors->corsJson();
        $response = [];
        $dataventas = Ventas::where('estado', 'A')->get();

        if ($dataventas) {
            foreach ($dataventas as $vent) {
                $vent->cliente;
                $vent->usuario;

            }
            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'ventas' => $dataventas,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existen datos',
                'ventas' => null,
            ];
        }
        echo json_encode($response);
    }

    public function guardar(Request $request){
        $this->cors->corsJson();
        $datarequestventa = $request->input('venta');
        $datarequestdetalleventa = $request->input('detalle_venta');
        $response=[];
        $nuevohelper=new Helper();
        $nuevonumeroventa= $nuevohelper->generate_key($this->limite);
        
        if($datarequestventa){
            $existecodigoventa=Ventas::where('numero_venta',$nuevonumeroventa)->get()->first();
            if($existecodigoventa){
                $response=[
                    'status'=>false,
                    'mensaje'=>'El numero de la venta ya existe',
                    'venta'=>null,
                ];
            }else{
                $nuevaventa= new Ventas();
                $nuevaventa->cliente_id=intval($datarequestventa->cliente_id);
                $nuevaventa->usuario_id=intval($datarequestventa->usuario_id);
                $nuevaventa->descuento=floatval($datarequestventa->descuento);
                $nuevaventa->subtotal=floatval($datarequestventa->subtotal);
                $nuevaventa->iva=floatval($datarequestventa->iva);
                $nuevaventa->total=floatval($datarequestventa->total);
                $nuevaventa->fecha_venta= $datarequestventa->fecha_venta;
                $nuevaventa->estado='A';
                $nuevaventa->numero_venta= $nuevonumeroventa;
               // $nuevaventa->iva=floatval($datarequestventa->iva);

                if($nuevaventa->save()){
                    $detalleventacontroller = new Detalle_VentaController();
                    $det_venta = $detalleventacontroller->guardar_detalleventa($nuevaventa->id, $datarequestdetalleventa);
                    
                    $response=[
                        'status'=>true,
                        'mensaje'=>'La venta se ha guardado',
                        'venta'=>$nuevaventa,
                        'detalle_venta'=>$det_venta,
                    ];   
                }else{
                    $response=[
                        'status'=>false,
                        'mensaje'=>'La venta no se ha guardado',
                        'venta'=>null,
                    ];

                }
 

            }
        }else{
            $response=[
                'status'=>false,
                'mensaje'=>'No hay datos para procesar',
                'venta'=>$response,
            ];
        }

        echo json_encode($response);

    }

    public function getventasid($params){
        $this->cors->corsJson();
        $id = intval($params['id']);
        $response = [];
        $ventas = Ventas::find($id);
     /*    if($ventas){
            foreach($ventas->detalle_venta as $item ){
                $item->producto;
            } 
            $response = [
                'status'=>true,
                'mensaje'=>'existe datos',
                'ventas'=>$ventas,
                'detalle_ventas'=>$ventas->detalle_venta,
            ]; 
        }else{

        } */
 
         if($ventas){

            $ventas->cliente->persona;
            $ventas->usuario->persona;

            foreach ($ventas->detalle_venta as $subbuscar) { 
                $subbuscar->producto;
            }


            $response = [
                'status' => true,
                'mensaje' => 'hay datos',
                'venta' => $ventas,
                'detalle_venta' => $ventas->detalle_venta,
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'no hay datos',
                'venta' => null
            ];
        } 
        echo json_encode($response);
    }

    public function datatable()  {     
        $this->cors->corsJson();
        $dataverventas = Ventas::where('estado', 'A')->orderBy('fecha_venta','desc')->get();
        $data = [];   $i = 1;

        foreach ($dataverventas as $dc) {
    
            $icono = $dc->estado == 'I' ? '<i class="fa fa-check-circle fa-lg"></i>' : '<i class="fa fa-trash fa-lg"></i>';
            $clase = $dc->estado == 'I' ? 'btn-success btn-sm' : 'btn-dark btn-sm';
            $other = $dc->estado == 'A' ? 0 : 1;

            $botones = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm" onclick="ver_detalleVenta(' . $dc->id . ')">
                            <i class="fas fa-vote-yea"></i>
                            </button>
                        
                        </div>';

            $data[] = [
                0 => $i,
                1 => $dc->fecha_venta,
                2 => $dc->numero_venta,
                3 => $dc->cliente->persona->cedula,
                4 => $dc->cliente->persona->nombre,
                5 => $dc->cliente->persona->apellido,
                6 => $dc->total,
                7 => $botones,
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

    public function ventastotales(){
        $this->cors->corsJson();
        $meses = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        $posicionMes = intval(date('m')) -1;
        $diahoy = date('Y-m-d');
        $inicioMes = date('Y').'-'.date('m').'-01';
        $ventas = Ventas::where('estado','A')->where('fecha_venta','>=',$inicioMes)->where('fecha_venta','<=',$diahoy)->get();
        $response = []; $total=0;
        if($ventas){
            foreach($ventas as $uess){
                $aux =$total += $uess->total;
                $total = round($aux,2);
                
            }
            $response = [
                'status'=>true,
                'mensaje'=>'hay datos',
                'total'=>$total,
                'mes'=>$meses[$posicionMes],
            ];

        }else{
            $response = [
                'status'=>false,
                'mensaje'=>'no hay datos',
                'total'=>0,
                'mes'=>$meses[$posicionMes],
            ];
        }
        echo json_encode($response);
    }
}