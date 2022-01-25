<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/perscripcionModel.php';

class PerscripcionController{

    private $cors;
  

    public function __construct()
    {
        $this->cors = new Cors();

    }

    public function guardarPerscripcion($historial_clinico_id, $perscripcion = []){

        $response = [];
        if(count($perscripcion) > 0){
            foreach($perscripcion as $per){
                $nuevoPerscripcion = new Perscripcion();
                $nuevoPerscripcion->historial_clinico_id = intval($historial_clinico_id);
                $nuevoPerscripcion->descripcion = $per->descripcionP;
                $nuevoPerscripcion->estado = 'A';
                $nuevoPerscripcion->save();

            }
            $response = [
                'status' => true,
                'mensaje' => 'guardando datos',
                'perscripcion' => $nuevoPerscripcion
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No ahi datos para guardar',
                'perscripcion' => null
            ]; 
        }

        return $response;

    }

    

}