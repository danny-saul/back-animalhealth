<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/nhora_doctoratencionModel.php';

class Nhora_DoctoratencionController{

    private $cors;
  

    public function __construct()
    {
        $this->cors = new Cors();

    }
    public function getHoradoctoratencion(){
        $this->cors->corsJson();
        $response=[];
        $datahoradoctoratencion = Nhora_Doctoratencion::where('estado','A')->get();

        if($datahoradoctoratencion){
            $response=[
                'status'=>true,
                'mensaje'=>'Si hay datos',
                'nhora_doctoratencion'=>$datahoradoctoratencion
            ];

        }else{
            $response=[
                'status'=>false,
                'mensaje'=>'No hay datos',
                'nhora_doctoratencion'=>null
            ];
        }
        echo json_encode($response);


    }   


}