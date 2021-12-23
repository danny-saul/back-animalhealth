<?php

use Illuminate\Support\Facades\Response;

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/razaModel.php';

class RazaController{

    private $cors;
  

    public function __construct()
    {
        $this->cors = new Cors();

    }
    public function getRaza(){
        $this->cors->corsJson();
        $response=[];
        $dataRaza = Raza::where('estado','A')->get();

        if($dataRaza){
            $response=[
                'status'=>true,
                'mensaje'=>'Si hay datos',
                'raza'=>$dataRaza
            ];

        }else{
            $response=[
                'status'=>false,
                'mensaje'=>'No hay datos',
                'raza'=>null
            ];
        }
        echo json_encode($response);


    }   

    public function BuscarRaza($params){
        $this->cors->corsJson();
        $texto= strtolower($params['texto']);
        $dataraza = Raza::where('raza','like','%'. $texto .'%')->where('estado','A')->get();
        $response=[];
        if($texto == ""){
            $response=[
                'status'=>true,
                'mensaje'=>'todos los registros',
                'raza'=> $dataraza,
            ];
        }else{
            if(count($dataraza)>0){
                $response=[
                    'status' => true,
                    'mensaje'=>'coincidencias encontradas',
                    'raza'=> $dataraza,
                ];
                
            }else{
                $response=[
                    'status' => false,
                    'mensaje'=>'no hay registros',
                    'raza'=> null,
                ];
            }
        }
        echo json_encode($response);
    }


}