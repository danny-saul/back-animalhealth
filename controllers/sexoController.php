<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/sexoModel.php';

class SexoController{

    private $cors;
  

    public function __construct()
    {
        $this->cors = new Cors();

    }
    public function getSexo(){
        $this->cors->corsJson();
        $response=[];
        $datasexo = Sexo::where('estado','A')->get();

        if($datasexo){
            $response=[
                'status'=>true,
                'mensaje'=>'Si hay datos',
                'sexo'=>$datasexo
            ];

        }else{
            $response=[
                'status'=>false,
                'mensaje'=>'No hay datos',
                'sexo'=>null
            ];
        }
        echo json_encode($response);


    }   


}