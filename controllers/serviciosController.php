<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/serviciosModel.php';

class ServiciosController{

    private $cors;
  

    public function __construct()
    {
        $this->cors = new Cors();

    }
    public function listarServicios(){
        $this->cors->corsJson();
        $response=[];
        $dataServicios = Servicios::where('estado','A')->get();
        
        if($dataServicios){
            $response=[
                'status'=>true,
                'mensaje'=>'Si hay datos',
                'servicios'=>$dataServicios
            ];

        }else{
            $response=[
                'status'=>false,
                'mensaje'=>'No hay datos',
                'servicios'=>null
            ];
        }
        echo json_encode($response);


    }   


}