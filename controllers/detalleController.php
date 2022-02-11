
<?php

use Illuminate\Support\Facades\Response;

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/detalleModel.php';

class DetalleController{

    private $cors;
  

    public function __construct()
    {
        $this->cors = new Cors();

    }
    public function listardetalle(){
        $this->cors->corsJson();
        $response=[];
        $datadetallekpi = Detalle::where('estado','A')->get();

        if($datadetallekpi){
            $response=[
                'status'=>true,
                'mensaje'=>'Si hay datos',
                'detalle'=>$datadetallekpi
            ];

        }else{
            $response=[
                'status'=>false,
                'mensaje'=>'No hay datos',
                'detalle'=>null
            ];
        }
        echo json_encode($response);


    }   



}