<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'models/citasModel.php';
require_once 'models/horarios_citasModel.php';
require_once 'models/doctorModel.php';
require_once 'models/recetaModel.php';


class CitasController
{

    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $response = [];
        $dataCitaRequest = $request->input('cita');

        if ($dataCitaRequest) {
            $doctor_id = intval($dataCitaRequest->doctor_id);
            $servicios_id = intval($dataCitaRequest->servicios_id);
            $mascota_id = intval($dataCitaRequest->mascota_id);
            $cliente_id = intval($dataCitaRequest->cliente_id);
            $horarios_citas_id = intval($dataCitaRequest->horarios_citas_id);

            $nuevoCita = new Citas();
            $nuevoCita->doctor_id = $doctor_id;
            $nuevoCita->servicios_id = $servicios_id;
            $nuevoCita->mascota_id = $mascota_id;
            $nuevoCita->cliente_id = $cliente_id;
            $nuevoCita->estado_cita_id = 1;
            $nuevoCita->horarios_citas_id = $horarios_citas_id;
            $nuevoCita->fecha = date('Y-m-d');
            $nuevoCita->estado = 'A';

            $updHorarioCitas = Horarios_Citas::find($horarios_citas_id);
            $updHorarioCitas->status = 'S';
            $updHorarioCitas->save();

            if ($nuevoCita->save()) {
                $response = [
                    'status' => true,
                    'mensaje' => 'Se Guardo la cita correctamente',
                    'cita' => $nuevoCita,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede guardar la cita',
                    'cita' => null,
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'cita' => null,
            ];

        }
        echo json_encode($response);
    }

    public function datatablecita()
    {
        $this->cors->corsJson();
        $dataCita = Citas::where('estado', 'A')->get();
        $data = [];
        $i = 1;

        foreach ($dataCita as $dc) {
            $dataCliente = $dc->cliente->persona;
            $dataMascota = $dc->mascota;
            $dataDoctor = $dc->doctor->persona;
            $dataServicio = $dc->servicios;
            $dataHoraCita = $dc->horarios_citas;
            $dataEstadoCita = $dc->estado_cita;

            //substr para quitar los ceros de la derecha
            $horario_inicio = substr($dataHoraCita->hora_inicio, 0, -3);
            $horario_fin = substr($dataHoraCita->hora_fin, 0, -3);

            $span = '<span class="badge bg-danger" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';


            $botones = '<div class="text-center">
                            <button class="btn btn-sm btn-outline-primary" onclick="ver_cita(' . $dc->id . ')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => $dataCliente->nombre . ' ' . $dataCliente->apellido,
                2 => $dataMascota->nombre,
                3 => $dataDoctor->nombre . ' ' . $dataDoctor->apellido,
                4 => $dataServicio->nombre_servicio,
                5 => $horario_inicio . ' ' . $horario_fin,
                6 => $span,
                7 => $botones,
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

    public function listarcitasPendientes($params){
        $this->cors->corsJson();

        $persona_id= intval($params['persona_id']);
        $estado_id= intval($params['estado_id']);
        
        $response = [];
        $doctor = Doctor::where('estado','A')->where('persona_id',$persona_id)->get()->first();
        
        if($doctor){
            $doctor_id=$doctor->id;
            //pendientes
            $pendientes = Citas::where ('estado','A')
            ->where('estado_cita_id',$estado_id)
            ->where('doctor_id',$doctor_id)
            ->orderBy('horarios_citas_id', 'ASC')
            ->get();

            foreach($pendientes as $pend ){
                $pend->mascota->tipo_mascota->id;
                $pend->mascota->genero_mascota->id;
                $pend->mascota->raza->id;
      
                $aux = [
                    'cita'=>$pend,
                    'doctor_id'=>$pend->doctor->persona->id,
                    'servicios_id'=>$pend->servicios->id,
                    'mascota_id'=>$pend->mascota->id,
                    'cliente_id'=> $pend->cliente->persona->id,
                    'estado_cita_id'=>$pend->estado_cita->id,
                    'horarios_citas_id'=>$pend->horarios_citas->id, 
                ];
                $response[]=$aux;           
            }
        }
        echo json_encode($response);
    }
    
    public function getcitasId($params){
        $this->cors->corsJson();

        $citas_id = intval($params['id']);
        $response=[];

        $citas = Citas::find($citas_id);
        
        if($citas){
            $citas->doctor->persona;
            $citas->servicios;
            $citas->mascota;
            $citas->mascota->tipo_mascota;
            $citas->mascota->genero_mascota;
            $citas->mascota->raza;
            $citas->cliente->persona;
            $citas->estado_cita;
            $citas->horarios_citas;
            $response = [
                'status'=>true,
                'mensaje'=>'existen datos',
                'citas'=>$citas,
            ]; 
        }else{
            $response = [
                'status'=>false,
                'mensaje'=>'no existen datos',
                'citas'=>null,              
            ];           
        }       
        echo json_encode($response);
    }

    public function actualizarCitaPendientes($params)
    {
        $this->cors->corsJson();
        $id_cita = intval($params['id_cita']);
        $id_estado = intval($params['estado_id']);
        $mensajes = '';

        $cita = Citas::find($id_cita);
        $response = [];

        if ($cita) {
            $rec = $cita->receta;
            $cita_id = $cita->id;
            $hc_id = $cita->horarios_citas_id;
           
            foreach($rec as $item){//receta
                $receta_id = $item->id;
            }
            
            $receta = Receta::find($receta_id);
            $receta->cita_id = $cita_id;         
            $receta->pagado = 'S';
            $receta->save();
            

            $cita->estado_cita_id = $id_estado;
            $cita->save();

            $horarioC=Horarios_Citas::find($hc_id);
            $horarioC->status='N';
            $horarioC->save();

            
            switch ($id_cita) {
                case 1:
                    $mensajes = 'La cita ha sido pendiente';    break;
                case 2:
                    $mensajes = 'La cita ha sido atendida';     break;
            }

            $response = [
                'status' => true,
                'mensaje' => $mensajes,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se puede actualizar la cita',
            ];
        }
        echo json_encode($response);
    }
}
