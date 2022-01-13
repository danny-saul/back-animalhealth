<?php

require_once 'app/cors.php';
require_once 'core/conexion.php';
require_once 'app/request.php';
require_once 'models/personaModel.php';
require_once 'models/doctorModel.php';

class DoctorController
{

    private $cors;
    private $conexion;

    public function __construct()
    {
        $this->cors = new Cors();
        $this->conexion = new Conexion();
    }

    public function guardardoctor($doctor, $persona_id)
    {
        if ($doctor) {
            $nuevodoctor = new Doctor();
            $nuevodoctor->persona_id = $persona_id;
            $nuevodoctor->estado = 'A';
            $nuevodoctor->save();

            return $nuevodoctor;

        } else {
            return null;
        }

    }


    public function getDoctordatatable()
    {

        $this->cors->corsJson();
        $datadoctor = Doctor::where('estado', 'A')->get();
        $data = [];
        $i = 1;

        foreach ($datadoctor as $dd) {
            $personas = $dd->persona;
            $icono = $dd->estado == 'I' ? '<i class="fa fa-check-circle fa-lg"></i>' : '<i class="fa fa-trash fa-lg"></i>';
            $clase = $dd->estado == 'I' ? 'btn-success btn-sm' : 'btn-dark btn-sm';
            $other = $dd->estado == 'A' ? 0 : 1;

            $botones = '<div class="btn-group">
                        <button class="btn btn-primary btn-sm" onclick="editar_doctor(' . $dd->id . ')">
                            <i class="fa fa-edit fa-lg"></i>
                        </button>
                        <button class="btn ' . $clase . '" onclick="eliminar_doctor(' . $dd->id . ',' . $other . ')">
                            ' . $icono . '
                        </button>
                    </div>';

            $data[] = [
                0 => $i,
                1 => $personas->cedula,
                2 => $personas->nombre,
                3 => $personas->apellido,
                4 => $personas->telefono,
                5 => $personas->direccion,
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

    public function eliminar(Request $request)
    {
        $this->cors->corsJson();
        $datadoctorrequest = $request->input('doctor');

        $id = $datadoctorrequest->id;
        $datadoctor = Doctor::find($id);

        if ($datadoctorrequest) {
            if ($datadoctor) {
                $datadoctor->estado = 'I';
                $datadoctor->save();
                $response = [
                    'status' => true,
                    'mensaje' => "Se ha eliminado el Doctor",
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => "No se puede eliminar el Doctor",
                ];

            }

        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
            ];
        }
        echo json_encode($response);

    }

    public function getDoctorId($params)
    {
        $this->cors->corsJson();
        $id = intval($params['id']);
        $response = [];

        $dataDoctor = Doctor::find($id);

        if($dataDoctor){
         
                $dataDoctor->persona;
                $dh = $dataDoctor->doctor_horario;
                foreach($dh as $item){
                    $item->horarios_atencion;
                }
            
          
            $response = [
                'status' => true,
                'mensaje' => 'Si ahi datos',
                'doctor' => $dataDoctor
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'no ahi datos',
                'doctor' => null
            ];
        }
        echo json_encode($response);
    }

    public function editar(Request $request)
    {
        $this->cors->corsJson();
        $response = [];
        $dataDoctorRequest = $request->input('doctor');

        $id = intval($dataDoctorRequest->id);
        $persona_id = intval($dataDoctorRequest->persona_id);

        $doctor = Doctor::find($id);

        if($dataDoctorRequest){
            if($doctor){
                $doctor->persona_id = $persona_id;
                $persona = Persona::find($persona_id);
                $persona->nombre = $dataDoctorRequest->nombre;
                $persona->apellido = $dataDoctorRequest->apellido;
                $persona->telefono = $dataDoctorRequest->telefono;
                $persona->direccion = $dataDoctorRequest->direccion;
                $persona->save();
                $doctor->save();

                $response = [
                    'status' => true,
                    'mensaje' => 'El doctor se ha actualizado',
                    'doctor' => $doctor
                ];
            }else{
                $response = [
                    'status' => false,
                    'mensaje' => 'no se puede actualizar el doctor',
                    'doctor' => null
                ];
            }
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'no ahi datos para procesar'
            ];
        }
        echo json_encode($response);
    }

      //listar en array
      public function listarArray()
      {
          $this->cors->corsJson();
  
          $doctores = Doctor::where('estado','A')->get();
          $response = [];
          
          foreach ($doctores as $item) {
              $aux = [
                  'doctor' => $item,
                  'persona' => $item->persona->id,
              ];
              $response[] = $aux;
          }
  
          echo json_encode($response);
      }

    public function getDoctor(){
        $this->cors->corsJson();
        $dataDoctor = Doctor::where('estado','A')->get();
        $response = [];
        if($dataDoctor){
            foreach($dataDoctor as $chelas){
                $chelas->persona;
                $dh = $chelas->doctor_horario;
                foreach($dh as $item){
                    $item->horarios_atencion;
                }
            }
            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'doctor' => $dataDoctor
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'no existen datos',
                'doctor' => null,
            ];
        }
        echo json_encode($response);
    }

    public function searchDoctor($params)
    {
        $this->cors->corsJson();
        $texto = ucfirst($params['texto']);
        $response = [];

        $sql = "SELECT d.id, p.cedula, p.nombre, p.apellido, p.telefono FROM persona p
        INNER JOIN doctor d ON d.persona_id= p.id
        WHERE p.estado = 'A' and (p.cedula LIKE '%$texto%' OR p.nombre LIKE '%$texto%' OR p.apellido LIKE '%$texto%')";

        $array = $this->conexion->database::select($sql);

        if ($array) {
            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'doctores' => $array,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No existen coincidencias',
                'doctores' => null,
            ];
        }
        echo json_encode($response);
    } 

}
