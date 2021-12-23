<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/genero_mascotaModel.php';

class Genero_MascotaController{

    private $cors;
  

    public function __construct()
    {
        $this->cors = new Cors();

    }
    public function getGenero_mascota(){
        $this->cors->corsJson();
        $response=[];
        $dataGeneroMascota = Genero_Mascota::where('estado','A')->get();

        if($dataGeneroMascota){
            $response=[
                'status'=>true,
                'mensaje'=>'Si hay datos',
                'genero_mascota'=>$dataGeneroMascota
            ];

        }else{
            $response=[
                'status'=>false,
                'mensaje'=>'No hay datos',
                'genero_mascota'=>null
            ];
        }
        echo json_encode($response);


    }   


}