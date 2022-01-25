<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'app/helper.php';
require_once 'models/ventasModel.php';
require_once 'controllers/detalle_ventaController.php';
require_once 'models/productoModel.php';


class VentasController
{

    private $cors;
    private $limite=5;

    public function __construct()
    {
        $this->cors = new Cors();
        $this->conexion = new Conexion();

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

    public function rventasmensuales($params){
        $this->cors->corsJson();
        $fecha_inicio = $params['fecha_inicio'];
        $fecha_fin = $params['fecha_fin'];

        $meses = Helper::MESES();

        $fecha_inicio = new DateTime($fecha_inicio);
        $fecha_fin = new DateTime($fecha_fin);

        $mes_inicio = intval(explode('-', $params['fecha_inicio'])[1]);
        $mes_fin = intval(explode('-', $params['fecha_fin'])[1]);

        $data = []; $label = []; $datatotal = [];  $dataiva = []; $datasubtotal = [];
        $totalgeneral = 0; $ivageneral = 0;  $subtotalgeneral = 0;

        for ($i = $mes_inicio; $i <= $mes_fin; $i++) {
            $sql = "SELECT SUM(total) as total, SUM(subtotal) as subtotal , SUM(iva) as iva, fecha_venta FROM ventas where MONTH(fecha_venta) =($i) and estado ='A'";

            $ventamensuales = $this->conexion->database::select($sql)[0];

            $subtotal = (isset($ventamensuales->subtotal)) ? (round($ventamensuales->subtotal, 2)) : 0;
            $iva = (isset($ventamensuales->iva)) ? (round($ventamensuales->iva, 2)) : 0;
            $total = (isset($ventamensuales->total)) ? (round($ventamensuales->total, 2)) : 0;
            $fecha = (isset($ventamensuales->fecha_venta)) ? $ventamensuales->fecha_venta : '-';
            $mes = $meses[$i - 1];

            $aux = ['fecha' => $fecha, 'mes' => $mes, 'subtotal' => $subtotal, 'iva' => $iva, 'total' => $total];
            $aux2 = ['meses' => $meses[$i - 1], 'data' => $aux];
            $data[] = $aux2;
            $label[] = ucfirst($meses[$i - 1]);
            $datatotal[] = $total;
            $dataiva[] = $iva;
            $datasubtotal[] = $subtotal;
            $totalgeneral += $total;
            $ivageneral += $iva;
            $subtotalgeneral += $subtotal;
        }
        $ivageneral = round($ivageneral,2);
        
        $response = [
            'lista' => $data,
            'totales' => [
                'total' => $totalgeneral,
                'iva' => $ivageneral,
                'subtotal' => $subtotalgeneral,
            ],
            'barra' => [
                'labels' => $label,
                'datatotal' => $datatotal,
                'datasubtotal' => $datasubtotal,
                'dataiva' => $dataiva,

            ],
        ];
        echo json_encode($response);
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

    public function masvendido($params){
        $this->cors->corsJson();
        $inicio = $params['inicio']; 
        $fin = $params['fin']; 
        $limite = intval($params['limite']);
        
        $ventas = Ventas::where('fecha_venta', '>=',$inicio)->where('fecha_venta','<=',$fin)->where('estado','A')->take($limite)->get();
        $productos_id = []; $productos2=[];
        foreach($ventas as $v){
            $dv=$v->detalle_venta;
            foreach($dv as $item ){
                $aux= [
                    'id'=>$item->producto_id,
                    'cantidad'=>$item->cantidad, 
                ];
                $productos_id[]=(object) $aux;
                $productos2[]= $item->producto_id;

            }
        }
        $norepetidos = array_values(array_unique($productos2));
        $nuevoarray = []; $contador =0;
        for ($i=0; $i < count($norepetidos); $i++) { 
            foreach($productos_id as $pi){
                if($pi->id === $norepetidos[$i]){
                    $contador += $pi->cantidad;
                }
            }

            $aux =[
                'productos_id'=>$norepetidos[$i],
                'cantidad'=>$contador,

            ];
            $contador = 0;
            $nuevoarray[]=(object) $aux;
            $aux=[];

        }
        $arrayproducto = $this->ordenarArray($nuevoarray);
        $arrayproducto = Helper::invertir_array($arrayproducto);

        $arraysemifinal = [];
        if(count($arrayproducto) < $limite){
            $arraysemifinal = $arrayproducto;    
        }else if(count($arrayproducto) == $limite){
            $arraysemifinal = $arrayproducto;
        }else if(count($arrayproducto) > $limite){
            for ($i=0; $i < $limite; $i++) { 
                $arraysemifinal[] = $arrayproducto[$i];
            }
        }

        $arrayfinal= [];
        $total_gobal = 0; $totalporcentaje=0;
        
        foreach($arraysemifinal as $af){
            $producto = Producto::find($af->productos_id);
            $total=$producto->precio_venta * $af->cantidad;
            $total_gobal += $total;
            $totalporcentaje += $af->cantidad;

            $aux=[
                'producto'=>$producto,
                'cantidad'=>$af->cantidad,
                'total'=>$total,

            ];
            $arrayfinal[]= (object) $aux;
            
        }

        //armar grafico cantidad de  producto mas vendidos
        $masvendidos = [];
        $labels =[];
        $porcentaje = [];

        foreach($arrayfinal as $item){
            $labels[]= $item->producto->nombre;
            $masvendidos[]= $item->cantidad;
            $porce = round((100 * $item->cantidad) / $totalporcentaje,2);
            $porcentaje[]=$porce;

        }
        $response = [
            'lista'=>$arrayfinal,
            'data'=>[
                'masvendidos' => $masvendidos,
                'labels'=> $labels,

            ],
            'porcentaje'=>[
                'porcen'=>$porcentaje,
                'labels'=>$labels,
            ],
            'totalgeneral'=> $total_gobal,
        ];
        
        echo json_encode($response); die();

    
    }

    function ordenarArray($array){
        for ($i=1; $i < count($array); $i++) { 
            for ($j=0; $j < count($array) - $i; $j++) { 
                if($array[$j]->cantidad > $array[$j + 1]->cantidad){
                    $chelas = $array[$j + 1];
                    $array[$j + 1] = $array[$j];
                    $array[$j] = $chelas;
                }
            }
            
        }
        return $array;
    } 
}