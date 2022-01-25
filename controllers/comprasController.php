<?php
require_once 'core/conexion.php';
require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'app/helper.php';
require_once 'models/comprasModel.php';
require_once 'controllers/detalle_compraController.php';

class ComprasController
{

    private $cors;
    private $limite = 5;
    private $conexion;
    public function __construct()
    {
        $this->cors = new Cors();
        $this->conexion = new Conexion();
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

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $datarequestcompra = $request->input('compra');
        $datarequestdetallecompra = $request->input('detalle_compra');
        $response = [];
        $nuevohelper = new Helper();
        $nuevonumerocompra = $nuevohelper->generate_key($this->limite);

        if ($datarequestcompra) {
            $existecodigocompra = Compras::where('numero_compra', $nuevonumerocompra)->get()->first();
            if ($existecodigocompra) {
                $response = [
                    'status' => false,
                    'mensaje' => 'El numero de la compra ya existe',
                    'compra' => null,
                ];
            } else {
                $nuevacompra = new Compras();
                $nuevacompra->proveedor_id = intval($datarequestcompra->proveedor_id);
                $nuevacompra->usuario_id = intval($datarequestcompra->usuario_id);
                $nuevacompra->numero_compra = $nuevonumerocompra;
                $nuevacompra->descuento = floatval($datarequestcompra->descuento);
                $nuevacompra->subtotal = floatval($datarequestcompra->subtotal);
                $nuevacompra->iva = floatval($datarequestcompra->iva);
                $nuevacompra->total = floatval($datarequestcompra->total);
                $nuevacompra->iva = floatval($datarequestcompra->iva);
                $nuevacompra->fecha_compra = $datarequestcompra->fecha_compra;
                $nuevacompra->estado = 'A';

                if ($nuevacompra->save()) {
                    $detallecompracontroller = new Detalle_CompraController();
                    $det_compra = $detallecompracontroller->guardar_detallecompra($nuevacompra->id, $datarequestdetallecompra);

                    $response = [
                        'status' => true,
                        'mensaje' => 'La compra se ha guardado',
                        'compra' => $nuevacompra,
                        'detalle_compra' => $det_compra,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'La compra no se ha guardado',
                        'compra' => null,
                    ];
                }
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'compra' => $response,
            ];
        }

        echo json_encode($response);
    }

    public function datatable()
    {
        $this->cors->corsJson();
        $datavercompra = Compras::where('estado', 'A')->orderBy('fecha_compra','desc')->get();
        $data = [];
        $i = 1;

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

    public function getcomprasid($params)
    {
        $this->cors->corsJson();
        $id = intval($params['id']);
        $response = [];
        $compras = Compras::find($id);

        if ($compras) {

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
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no ahi datos',
                'compra' => null,
            ];
        }
        echo json_encode($response);
    }

    public function comprastotales()
    {
        $this->cors->corsJson();
        $meses = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre',
        ];
        $posicionMes = intval(date('m')) - 1;
        $diahoy = date('Y-m-d');
        $inicioMes = date('Y') . '-' . date('m') . '-01';
        $compras = Compras::where('estado', 'A')->where('fecha_compra', '>=', $inicioMes)->where('fecha_compra', '<=', $diahoy)->get();
        $response = [];
        $total = 0;
        if ($compras) {
            foreach ($compras as $pache) {
                $aux = $total += $pache->total;
                $total = round($aux, 2);
            }
            $response = [
                'status' => true,
                'mensaje' => 'hay datos',
                'total' => $total,
                'mes' => $meses[$posicionMes],
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no hay datos',
                'total' => 0,
                'mes' => $meses[$posicionMes],
            ];
        }
        echo json_encode($response);
    }

    public function rcomprasmensuales($params)
    {
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
            $sql = "SELECT SUM(total) as total, SUM(subtotal) as subtotal , SUM(iva) as iva, fecha_compra FROM compras where MONTH(fecha_compra) =($i) and estado ='A'";

            $compramensuales = $this->conexion->database::select($sql)[0];

            $subtotal = (isset($compramensuales->subtotal)) ? (round($compramensuales->subtotal, 2)) : 0;
            $iva = (isset($compramensuales->iva)) ? (round($compramensuales->iva, 2)) : 0;
            $total = (isset($compramensuales->total)) ? (round($compramensuales->total, 2)) : 0;
            $fecha = (isset($compramensuales->fecha_compra)) ? $compramensuales->fecha_compra : '-';
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



    public function mascomprada($params){
        $this->cors->corsJson();
        $inicio = $params['inicio']; 
        $fin = $params['fin']; 
        $limite = intval($params['limite']);
        
        $compras = Compras::where('fecha_compra', '>=',$inicio)->where('fecha_compra','<=',$fin)->where('estado','A')->take($limite)->get();
        $productos_id = []; $productos2=[];
        foreach($compras as $c){
            $dc=$c->detalle_compra;
            foreach($dc as $item ){
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

            $precioC = $producto->precio_compra;
            $afCantidad = $af->cantidad;

            $total = ($precioC * $afCantidad);
            $tg= $total_gobal += $total;
           
         //   $tgl = round($tg,2);
            $totalporcentaje += $af->cantidad;

            $aux=[
                'producto'=>$producto,
                'cantidad'=>$af->cantidad,
                'total'=>$total,

            ];
            $arrayfinal[]= (object) $aux;
            
        }

        //armar grafico cantidad de  producto mas vendidos
        $mascomprada = [];
        $labels =[];
        $porcentaje = [];

        foreach($arrayfinal as $item){
            $labels[]= $item->producto->nombre;
            $mascomprada[]= $item->cantidad;
            $porce = round((100 * $item->cantidad) / $totalporcentaje,2);
            $porcentaje[]=$porce;

        }
        $response = [
            'lista'=>$arrayfinal,
            'data'=>[
                'mascomprada' => $mascomprada,
                'labels'=> $labels,

            ],
            'porcentaje'=>[
                'porcen'=>$porcentaje,
                'labels'=>$labels,
            ],
            'totalgeneral'=> $tg,
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
