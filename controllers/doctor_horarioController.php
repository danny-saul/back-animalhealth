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

    public function listarDoctorHorario($params){
        $this->cors->corsJson();
        $response = []; $aaff= []; 
        $doctor_id = intval($params['id_doctor']);
        
        $doctor_horario = Doctor_Horario::where('doctor_id',$doctor_id)->get();

        if(count($doctor_horario) > 0){
            foreach($doctor_horario as $key){
                $key->doctor;
                $ha = $key->horarios_atencion;

                $aux1 = [
                    'id' => $ha->id,
                    'fecha' => $ha->fecha,
                    'horario' =>$ha->horario,
                    'libre' => $ha->libre 
                ];

                $aux2 = [
                    'fecha' =>$ha->fecha,
                ];
              
                $aahh[] = (object)$aux1;
                $aaff[] = (object)$aux2;

            }
            
            for ($i=0; $i < count($aaff) ; $i++) { 
                $fecha_padre[] =  $aaff[$i];                 
            }
            
            $au = array_unique($fecha_padre,SORT_REGULAR);

           $disponibles = Horarios_Atencion::where('libre','S')->where('estado','A')->get(); 

        
            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'doctor_horario' => $doctor_horario,
                'fecha' => $au,
                'horario' => $aahh,
                'disponibles' => $disponibles
            ];
            
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'no existen datos',
                'doctor_horario' => null
            ];
        }
        echo json_encode($response);

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

    public function verhorariod() {     
        $this->cors->corsJson();
        $dataverhorario = Doctor_Horario::where('estado', 'A')->get();
        $data = [];   $i = 1;

        foreach ($dataverhorario as $dc) {
    
            $icono = $dc->estado == 'I' ? '<i class="fa fa-check-circle fa-lg"></i>' : '<i class="fa fa-trash fa-lg"></i>';
            $clase = $dc->estado == 'I' ? 'btn-success btn-sm' : 'btn-dark btn-sm';
            $other = $dc->estado == 'A' ? 0 : 1;

            $botones = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm" onclick="editar_horaAdoctor(' . $dc->id . ')">
                                <i class="fa fa-edit fa-lg"></i>
                            </button>
                            <button class="btn ' . $clase . '" onclick="eliminar_horaAdoctor(' . $dc->id . ',' . $other . ')">
                                ' . $icono . '
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => $dc->doctor->persona->nombre,
                2 => $dc->doctor->persona->apellido,
                3 => $dc->horarios_atencion->horaE,
                4 => $dc->horarios_atencion->horaS,
                5 => $dc->horarios_atencion->fecha,
                6 => $botones,
            ];
            $i++;
        }

        $result = [
            'sEcho' => 1,
            'iTotalRecords' => count($data),
            'iTotalDisplayRecords' => count($data),
            'aaData' => $data,
        ];
        echo json_encode($result);

    }

    



}