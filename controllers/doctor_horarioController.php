<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'models/personaModel.php';
require_once 'models/doctor_HorarioModel.php';
require_once 'models/horarios_atencionModel.php';

class Doctor_HorarioController
{

    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function listarDoctorHorario($params)
    {
        $this->cors->corsJson();

        $doctor_id = intval($params['id_doctor']);
        $dia = intval($params['dia']);

        $hoA = [];
        $nuevoArray = [];
        $fecha = [];
        $response = [];
        $dh = Doctor_Horario::where('doctor_id', $doctor_id)->get();

        foreach ($dh as $key) {
            $id_doctor = intval($key->doctor->id);
            $hoA[] = $key->horarios_atencion;
        }

        for ($i = 0; $i < count($hoA); $i++) {
            $id_horario_atencion = $hoA[$i]->id;
            $fechaFin = $hoA[$i]->fecha;
            $fechasubdiaFin = intval(substr($fechaFin, 8));

            $fechaInicio = $hoA[0]->fecha;
            $fechasubdiaInicio = intval(substr($fechaInicio, 8));

            $buscar = Horarios_Atencion::where('libre','S')->whereDay('fecha', $dia)->whereDay('fecha', '>=', $fechasubdiaInicio)->whereDay('fecha', '<=', $fechasubdiaFin)->get();
        
        }

        if ((count($buscar) > 0) && ($id_doctor == 1)) {
            $response = [
                'status' => true,
                'mensaje' => 'si hay dias disponibles',
                'datos' => $buscar,
            ];
        } else if ((count($buscar) > 0) && ($id_doctor == 2)) {
            $response = [
                'status' => true,
                'mensaje' => 'si hay dias disponibles para el doctor 2',
                'datos' => $buscar,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no hay dias disponibles',
                'datos' => null,
            ];

        }

        echo json_encode($response);

    }

    public function guardardoctorhorario($doctor, $doctor_id, $horarios_atencion_id)
    {
        if ($doctor) {
            $nuevodoctorHorario = new Doctor_Horario();
            $nuevodoctorHorario->doctor_id = $doctor_id;
            $nuevodoctorHorario->horarios_atencion_id = $horarios_atencion_id;
            $nuevodoctorHorario->estado = 'A';
            $nuevodoctorHorario->save();

            return $nuevodoctorHorario;

        } else {
            return null;
        }

    }

    public function verhorariod()
    {
        $this->cors->corsJson();
        $dataverhorario = Doctor_Horario::where('estado', 'A')->get();
        $data = [];
        $i = 1;

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

    public function buscarDoctor()
    {
        $this->cors->corsJson();
        $doctorHorario = Doctor_Horario::where('estado', 'A')->get();
        $response = [];

        if ($doctorHorario) {
            $response = [
                'status' => true,
                'mensaje' => 'hay datos',
                'doctorHorario' => $doctorHorario,

            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no hay datos',
                'doctorHorario' => null,

            ];

        }

        echo json_encode($response);

    }

}
