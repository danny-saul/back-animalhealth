<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/horarios_citasModel.php';

class Horarios_CitasController{

    private $cors;
  

    public function __construct()
    {
        $this->cors = new Cors();

    }
    public function listarHorarios_Citas(){
        $this->cors->corsJson();
        $response=[];
        $dataHorarioCitas = Horarios_Citas::where('estado','A')->where('status','N')->get();
        
        if($dataHorarioCitas){
            $response=[
                'status'=>true,
                'mensaje'=>'Si hay datos',
                'horarios_citas'=>$dataHorarioCitas
            ];

        }else{
            $response=[
                'status'=>false,
                'mensaje'=>'No hay datos',
                'horarios_citas'=>null
            ];
        }
        echo json_encode($response);


    }   


}