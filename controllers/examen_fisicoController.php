<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/examen_fisicoModel.php';

class Examen_FisicoController{

    private $cors;
  

    public function __construct()
    {
        $this->cors = new Cors();

    }

    public function guardarExamenFisico($historial_clinico_id, $examenFisico = []){

        $response = [];
        if(count($examenFisico) > 0){
            foreach($examenFisico as $ef){
                $nuevoExamenFisico = new Examen_Fisico();
                $nuevoExamenFisico->historial_clinico_id = intval($historial_clinico_id);
                $nuevoExamenFisico->temperatura = intval($ef->temperatura);
                $nuevoExamenFisico->peso = intval($ef->peso);
                $nuevoExamenFisico->hidratacion = intval($ef->hidratacion);
                $nuevoExamenFisico->frecuencia_cardiaca = intval($ef->frecuencia_cardiaca);
                $nuevoExamenFisico->pulso = intval($ef->pulso);
                $nuevoExamenFisico->frecuencia_respiratoria = intval($ef->frecuencia_respiratoria);
                $nuevoExamenFisico->diagnostico = $ef->diagnostico;
                $nuevoExamenFisico->tratamiento = $ef->tratamiento;
                $nuevoExamenFisico->estado = 'A';
                $nuevoExamenFisico->save();

            }
            $response = [
                'status' => true,
                'mensaje' => 'guardando datos',
                'examen_fisico' => $nuevoExamenFisico
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No ahi datos para guardar',
                'examen_fisico' => null
            ]; 
        }

        return $response;

    }

    

}