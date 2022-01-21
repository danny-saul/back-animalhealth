<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/configuracionesModel.php';
require_once 'models/productoModel.php';

class ConfiguracionController{

    private $cors;
  

    public function __construct()
    {
        $this->cors = new Cors();

    }

    public function configuracionlistar($params){
        $this->cors->corsJson();
        $id = intval($params['id']);
        $response = [];
        $configuracion = Configuraciones::find($id);

        if($configuracion){
 
            $response = [
                'status' => true,
                'mensaje' => 'hay datos',
                'configuracion' => $configuracion
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'no hay datos',
                'configuracion' => null
            ];
        }
        echo json_encode($response);

    }

    public function editar(Request $request)
    {
        $this->cors->corsJson();
        $configuracionrequest = $request->input('configuracion');
        $idconfiguracion = intval($configuracionrequest->id);
 
        $configuraciondata = Configuraciones::find($idconfiguracion);
        $response = [];

        if ($configuracionrequest) {
            if ($configuraciondata) {

                $configuraciondata->iva = $configuracionrequest->iva;
                $configuraciondata->porcentaje_ganancia = $configuracionrequest->porcentaje_ganancia;
                $configuraciondata->save();

                $response = [
                    'status' => true,
                    'mensaje' => 'Se han actualizado los datos',
                ];
            }else{
                $response = [
                    'status' => false,
                    'mensaje' => 'No se ha actualizado los datos',
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
            ];
        }
        echo json_encode($response);
    }

    public function actualizarpventa(Request $request){
        $this->cors->corsJson();

        $configuracionrequest = $request->input('producto');
        $id = intval($configuracionrequest->id);
 
        $configuraciondata = Producto::find($id);
        $response = [];

        if ($configuracionrequest) {
            if ($configuraciondata) {

                $configuraciondata->precio_venta = $configuracionrequest->precio_venta;
                $configuraciondata->save();

                $response = [
                    'status' => true,
                    'mensaje' => 'Se han actualizado los datos',
                ];
            }else{
                $response = [
                    'status' => false,
                    'mensaje' => 'No se ha actualizado los datos',
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
            ];
        }
        echo json_encode($response);


    }

   
   
}