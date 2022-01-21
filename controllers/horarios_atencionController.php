<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/horarios_atencionModel.php';
require_once 'models/doctor_HorarioModel.php';

class Horarios_AtencionController
{

    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function intervaloHora($hora_inicio, $hora_fin, $intervalo)
    {
        $hora_inicio = new DateTime($hora_inicio);
        $hora_fin = new DateTime($hora_fin);
        $hora_fin->modify('+1 second'); // Añadimos 1 segundo para que nos muestre $hora_fin

        // Si la hora de inicio es superior a la hora fin
        // añadimos un día más a la hora fin
        if ($hora_inicio > $hora_fin) {

            $hora_fin->modify('+1 day');
        }

        // Establecemos el intervalo en minutos
        $intervalo = new DateInterval('PT' . $intervalo . 'M');

        // Sacamos los periodos entre las horas
        $periodo = new DatePeriod($hora_inicio, $intervalo, $hora_fin);

        foreach ($periodo as $hora) {

            // Guardamos las horas intervalos
            $horas[] = $hora->format('H:i:s');
        }

        return $horas;
    }

    public function Horarioatencion()
    {
        $this->cors->corsJson();

        $response = [];
        $dataHorarioA = Horarios_Atencion::where('estado', 'A')->get();
        if ($dataHorarioA) {
            $response = [
                'status' => true,
                'message' => 'existen datos',
                'horario' => $dataHorarioA,
            ];

        } else {
            $response = [
                'status' => false,
                'message' => 'no existen datos',
                'horario' => null,
            ];

        }
        echo json_encode($response);

    }

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $response = [];
        $dataRequestHorario = $request->input('horario_atencion');

        if ($dataRequestHorario) {
            $horaE = $dataRequestHorario->horaE;
            $horaS = $dataRequestHorario->horaS;
            $fecha = $dataRequestHorario->fecha;
            $inter = $dataRequestHorario->intervalo;
         
            $existeFecha = Horarios_Atencion::where('fecha', $fecha)->get()->first();
            
            if ($existeFecha) {
                $response = [
                    'status' => false,
                    'mensaje' => 'La fecha ya existe',
                    'horario_atencion' => null,
                ];
            } else {
             
                $horas_horario =  $this->intervaloHora($horaE,$horaS, $inter); //array de horas
                
                for ($i=0; $i < count($horas_horario) ; $i++) { 
                   $nuevoHorario = new Horarios_Atencion();    
                   $nuevoHorario->horaE = $horaE;
                   $nuevoHorario->horaS = $horaS;
                   $nuevoHorario->fecha = $fecha;
                   $nuevoHorario->intervalo = $inter;
                   $nuevoHorario->horario = $horas_horario[$i];
                   $nuevoHorario->libre = 'S';
                   $nuevoHorario->asignacion ='N';
                   $nuevoHorario->estado = 'A';
                
                   $nuevoHorario->save();
                }

                $response = [
                    'status' => true,
                    'mensaje' => 'El horario de atencion se ha guardado corectamente',
                    'horario_atencion' => $nuevoHorario,
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no hay datos par procesar',
                'horario_atencion' => null,
            ];
        }
        
        echo json_encode($response);
    }

    public function horarioAtencionlibre($params)
    {
        $this->cors->corsJson();
        $asignacion = strtoupper($params['asignacion']);
        $response = [];

        if ($asignacion == 'S' || $asignacion == 'N') {

            $horario_libre = Horarios_Atencion::where('asignacion', $asignacion)->get();

            $response = [
                'status' => true,
                'mensaje' => 'Horarios de Atencion encontrados',
                'horario_atencion' => $horario_libre,
            ];

        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No existe',
                'horario_atencion' => null,
            ];
        }

        echo json_encode($response);
    }

    public function saveDoctorHorarioAtencion(Request $request)
    {
        $this->cors->corsJson();
        $datos = $request->input('datos');
        $response = [];

        if ($datos) {
            $datos->doctor_id = intval($datos->doctor_id);
            $datos->horarios_atencion_id = intval($datos->horarios_atencion_id);

            $doctorHorario = new Doctor_Horario;
            $doctorHorario->doctor_id = $datos->doctor_id;
            $doctorHorario->horarios_atencion_id = $datos->horarios_atencion_id;
            $doctorHorario->estado = 'A';

            //validar que no se repita doctor_horario
            $existe = Doctor_Horario::where('horarios_atencion_id', $datos->horarios_atencion_id)->get()->first();

            if ($existe) {
                $response = [
                    'status' => false,
                    'mensaje' => 'El doctor ya tiene asignado su horario',
                    'doctor_horario' => null,
                ];
            } else {
                if ($doctorHorario->save()) {
                    //actualizar el horarios de atencion
                    $horarioAtencion = Horarios_Atencion::find($datos->horarios_atencion_id);
                   // $horarioAtencion->libre = 'N';
                    $horarioAtencion->asignacion= 'S';
                    $horarioAtencion->save();

                    $response = [
                        'status' => true,
                        'mensaje' => 'Se ha asignado su horario de atencion',
                        'doctor_horario' => $horarioAtencion,
                    ];

                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'No se ha guardado los datos ',
                        'doctor_horario' => null,
                    ];
                }

            }

        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No ha enviado datos',
                'doctor_horario' => null,
            ];
        }

        echo json_encode($response);

    }

    public function getdoctorhorario()
    {
        $this->cors->corsJson();
        $doctorHorario = Doctor_Horario::where('estado', 'A')->get();
        echo json_encode($doctorHorario);
    }

    public function doctorHorario($params)
    {
        $this->cors->corsJson();
        $idDoctor = intval($params['id']);

        $doctorHorario = Doctor_Horario::where('doctor_id', $idDoctor)->get();
        $response = []; $data = [];

         if(count($doctorHorario) > 0){
            foreach ($doctorHorario as $dh) {
                $id =  $dh->horarios_atencion->id;         
                $fechaHA =  $dh->horarios_atencion->fecha;
                $horario = $dh->horarios_atencion->horario;
       
                $aux = [
                    'id' => $id,
                    'fecha' => $fechaHA,
                    'horario' => $horario,
                ];

                $data[] = (object)$aux;
            }
            $response = [
                'status' => true,
                'mensaje' => 'Si ahi hora de atencion',
                'doctor_horario' => $data,
            ];

        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no ahi hora de atencion',
                'doctor_horario' => null,
            ];

        }
        echo json_encode($response);

    }

    public function eliminarDoctorHorarioAtencion($params)
    {

        $this->cors->corsJson();
        $response = [];

        $horarios_atencion_id = intval($params['id_horario_atencion']);
        $doctor_id = intval($params['id_doctor']);

        $doctor_horario = Doctor_Horario::where('horarios_atencion_id', $horarios_atencion_id)->get()->first();

        if ($doctor_horario->delete()) {

            //eliminar horario de atencion
            $horarioAtencion = Horarios_Atencion::find($horarios_atencion_id);
            
            $horarioAtencion->delete();

            $response = [
                'status' => true,
                'mensaje' => 'Se ha borrado el horario de atencion',
                'horario_atencion' => null,
            ];

        } else {
            $response = [
                'status' => false,
                'mensaje' => ' no se pudo borrar, intente mas tarde',
                'horario_atencion' => null,
            ];
        }
        echo json_encode($response);
    }

    public function listarHorasDoctorDt()
    {
        $this->cors->corsJson();
        $dataThorario = Horarios_Atencion::where('estado', 'A')->get();
        $data = [];
        $i = 1;

        foreach ($dataThorario as $dc) {

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
                1 => $dc->horaE,
                2 => $dc->horaS,
                3 => $dc->fecha,
                4 => $botones,
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

    public function eliminarhorasdoctor(Request $request)
    {
        $this->cors->corsJson();
        $horarioArequest = $request->input('horarios_atencion');
        $id = intval($horarioArequest->id);

        $horariosAtencion = Horarios_Atencion::find($id);
        $response = [];
        if ($horarioArequest) {
            if ($horariosAtencion) {
                $horariosAtencion->estado = 'I';
                $horariosAtencion->save();

                $response = [
                    'status' => true,
                    'mensaje' => "Se ha eliminado la hora",
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => "No Se ha eliminado la hora",
                ];
            }
        } else {
            $response = [
                'status' => false,
                'memsaje' => 'no hay datos para procesar',
                'horarios_atencion' => null,
            ];
        }
        echo json_encode($response);

    }

    public function editarDoctorHorarioAtencion(Request $request)
    {
        $this->cors->corsJson();
        $horarioArequest = $request->input('horarios_atencion');
        $id = intval($horarioArequest->id);

        $horariosAtencion = Horarios_Atencion::find($id);
        $response = [];

        if ($horarioArequest) {
            if ($horariosAtencion) {

                $horariosAtencion->horaE = $horarioArequest->horaE;
                $horariosAtencion->horaS = $horarioArequest->horaS;
                $horariosAtencion->fecha = $horarioArequest->fecha;

                $horariosAtencion->save();

                $response = [
                    'status' => true,
                    'mensaje' => 'Se ha actualizado el Horario de Atencion',
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se ha actualizado el Horario de Atencion',
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
            ];
        }
        echo json_encode($response);
    }

    public function horarioAlistar($params)
    {
        $this->cors->corsJson();
        $id = intval($params['id']);
        $response = [];
        $horarios_atencion = Horarios_Atencion::find($id);

        if ($horarios_atencion) {
            $response = [
                'status' => true,
                'mensaje' => 'hay datos',
                'horarios_atencion' => $horarios_atencion,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no ahi datos',
                'horarios_atencion' => null,
            ];
        }
        echo json_encode($response);

    }
}
