<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'models/personaModel.php';
require_once 'models/doctor_HorarioModel.php';

class Doctor_HorarioController{

    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function guardardoctorhorario($doctor, $doctor_id, $horarios_atencion_id){
        if($doctor){
            $nuevodoctorHorario = new Doctor_Horario();
            $nuevodoctorHorario->doctor_id= $doctor_id;
            $nuevodoctorHorario->horarios_atencion_id= $horarios_atencion_id;
            $nuevodoctorHorario->estado= 'A';
            $nuevodoctorHorario->save();

            return $nuevodoctorHorario;

        }else{
            return null;
        }

    }


}