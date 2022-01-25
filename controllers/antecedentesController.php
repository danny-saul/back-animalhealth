<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/antecedentesModel.php';

class AntecedentesController{

    private $cors;
  

    public function __construct()
    {
        $this->cors = new Cors();

    }

    public function guardarAntecedentes($historial_clinico_id, $antecedentes = []){
        $response = [];
        if(count($antecedentes) > 0){
            foreach($antecedentes as $ant){
                $nuevoAntecedentes = new Antecedentes();
                $nuevoAntecedentes->historial_clinico_id = intval($historial_clinico_id);
                $nuevoAntecedentes->cirugias = $ant->cirugias;
                $nuevoAntecedentes->descripcion = $ant->descripcion;
                $nuevoAntecedentes->fecha_cirugia = $ant->fecha_cirugia;
                $nuevoAntecedentes->estado = 'A';
                $nuevoAntecedentes->save();
            }

            $response = [
                'status' => true,
                'mensaje' => 'guardando datos',
                'antecedentes' => $nuevoAntecedentes
            ];   
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No ahi datos para guardar',
                'antecedentes' => null
            ]; 
        }

        return $response;

    }

}