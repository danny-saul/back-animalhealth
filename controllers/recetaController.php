<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/recetaModel.php';
require_once 'controllers/detalle_recetaController.php';
require_once 'core/conexion.php';
require_once 'models/productoModel.php';


class RecetaController{

    private $cors;
    private $conexion;
  
    public function __construct()
    {
        $this->cors = new Cors();
        $this->conexion = new Conexion();
    }

    public function guardarreceta(Request $request){
        $this->cors->corsJson();
        $datarequestreceta = $request->input('receta');
        $detallereceta = $request->input('detalle_receta');
        $response=[];

        if($datarequestreceta){
            $cita_id = intval($datarequestreceta->cita_id);
            $doctor_id = intval($datarequestreceta->doctor_id);
            $total = floatval($datarequestreceta->total);
            $descripcion = ucfirst($datarequestreceta->descripcion);

            $nuevareceta= new Receta;
            $nuevareceta->cita_id=$cita_id;
            $nuevareceta->doctor_id=$doctor_id;
            $nuevareceta->pagado='N';
            $nuevareceta->fecha=date('Y-m-d');
            $nuevareceta->total = $total;
            $nuevareceta->descripcion = $descripcion;
            $nuevareceta->estado = 'A';
          
            if($nuevareceta->save()){
                //guarda en detalle receta
                $detallerecetacontroller = new Detalle_RecetaController();
                $det_reseta = $detallerecetacontroller->guardar_detallereceta($nuevareceta->id, $detallereceta);
                
                $response=[
                    'status'=>true,
                    'mensaje'=>'guardando datos',
                    'receta'=>$nuevareceta, 
                    'detalle_receta'=>$det_reseta,
                ];
            }else{
                $response=[
                    'status'=>false,
                    'mensaje'=>'no se pudo guardar los datos',
                    'receta'=>null, 
                    'detalle_receta'=>null,
                ];
            }
        }else{
            $response=[
                'status'=>false,
                'mensaje'=>'no hay datos para procesar',
                'receta'=>null, 
                'detalle'=>null,
            ];
        }
      echo json_encode($response);
    }


    public function listarrecetas()
    {
        $this->cors->corsJson();
        $response = [];
        $datarecetas = Receta::where('estado', 'A')->get();

        if ($datarecetas) {
            foreach ($datarecetas as $vent) {
                $vent->cliente;
                $vent->usuario;

            }
            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'recetas' => $datarecetas,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existen datos',
                'recetas' => null,
            ];
        }
        echo json_encode($response);
    }

    public function getrecetasid($params){
        $this->cors->corsJson();
        $id = intval($params['id']);
        $response = [];
        $recetas = Receta::find($id);

         if($recetas){

         //   $recetas->cliente->persona;
            $recetas->doctor->persona;
       

            foreach ($recetas->detalle_receta as $subbuscar) { 
                $subbuscar->producto;
            } 


            $response = [
                'status' => true,
                'mensaje' => 'hay datos',
                'receta' => $recetas,
                'detalle_receta' => $recetas->detalle_receta,
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'no hay datos',
                'detalle_receta' => null
            ];
        } 
        echo json_encode($response);
    }

   


 
   


}