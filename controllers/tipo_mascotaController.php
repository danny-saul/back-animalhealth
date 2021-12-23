<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/tipo_mascotaModel.php';

class Tipo_MascotaController{

    private $cors;
  

    public function __construct()
    {
        $this->cors = new Cors();

    }
    public function getTipo_mascota(){
        $this->cors->corsJson();
        $response=[];
        $dataTipoMascota = Tipo_Mascota::where('estado','A')->get();

        if($dataTipoMascota){
            $response=[
                'status'=>true,
                'mensaje'=>'Si hay datos',
                'tipo_mascota'=>$dataTipoMascota
            ];

        }else{
            $response=[
                'status'=>false,
                'mensaje'=>'No hay datos',
                'tipo_mascota'=>null
            ];
        }
        echo json_encode($response);


    }   


}