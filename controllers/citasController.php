<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/helper.php';
require_once 'models/citasModel.php';
require_once 'models/horarios_atencionModel.php';
require_once 'models/doctorModel.php';
require_once 'models/recetaModel.php';
require_once 'models/mascotaModel.php';
require_once 'models/tipo_mascotaModel.php';

class CitasController
{

    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    //guardar prueba 11-01-2022 falso
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
            $horarios_atencion_id = intval($dataCitaRequest->horarios_atencion_id);

            $nuevoCita = new Citas();
            $nuevoCita->doctor_id = $doctor_id;
            $nuevoCita->servicios_id = $servicios_id;
            $nuevoCita->mascota_id = $mascota_id;
            $nuevoCita->cliente_id = $cliente_id;
            $nuevoCita->estado_cita_id = 1;
            $nuevoCita->horarios_atencion_id = $horarios_atencion_id;
            $nuevoCita->fecha = date('Y-m-d');
            $nuevoCita->estado = 'A';

            //actulizar la hora de atencio a ocupado en el atributo libre
            $updHorarioAtencion = Horarios_Atencion::find($horarios_atencion_id);
            $updHorarioAtencion->libre = 'O';
            $updHorarioAtencion->save();

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
        $dataCita = Citas::where('estado', 'A')->orderBy('fecha','desc')->get();
        $data = [];
        $i = 1;

        foreach ($dataCita as $dc) {
            $dataCliente = $dc->cliente->persona;
            $dataMascota = $dc->mascota;
            $dataDoctor = $dc->doctor->persona;
            $dataServicio = $dc->servicios;
            $dataHoraCita = $dc->horarios_atencion;
            $dataEstadoCita = $dc->estado_cita;
            $dataFechaCita= $dc->horarios_atencion->fecha;

            //substr para quitar los ceros de la derecha
            // $horario = substr($dataHoraCita->horario, 0, -3);
            //   $horario_fin = substr($dataHoraCita->hora_fin, 0, -3);

            $estado = $dc->estado_cita_id;
            //  $horario =$dc->horarios_atencion_id;

            if ($estado == 1) {
                $estado = '<span class="badge bg-warning" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
            } else if ($estado == 2) {
                $estado = '<span class="badge bg-success" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
            } else {
                $estado = '<span class="badge bg-danger" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
            }

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
                5 => $dataHoraCita->horario,
                6 => $dataFechaCita,
                7 => $estado,
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

    public function listarcitasPendientes($params)
    {
        $this->cors->corsJson();

        $persona_id = intval($params['persona_id']);
        $estado_id = intval($params['estado_id']);

        $response = [];
        $doctor = Doctor::where('estado', 'A')->where('persona_id', $persona_id)->get()->first();

        if ($doctor) {
            $doctor_id = $doctor->id;
            //pendientes
            $pendientes = Citas::where('estado', 'A')
                ->where('estado_cita_id', $estado_id)
                ->where('doctor_id', $doctor_id)
                ->orderBy('horarios_atencion_id', 'ASC')
                ->get();

            foreach ($pendientes as $pend) {
                $pend->mascota->tipo_mascota->id;
                $pend->mascota->genero_mascota->id;
                $pend->mascota->raza->id;

                $aux = [
                    'cita' => $pend,
                    'doctor_id' => $pend->doctor->persona->id,
                    'servicios_id' => $pend->servicios->id,
                    'mascota_id' => $pend->mascota->id,
                    'cliente_id' => $pend->cliente->persona->id,
                    'estado_cita_id' => $pend->estado_cita->id,
                    'horarios_atencion_id' => $pend->horarios_atencion->id,
                ];
                $response[] = $aux;
            }
        }
        echo json_encode($response);
    }

    public function getcitasId($params)
    {
        $this->cors->corsJson();

        $citas_id = intval($params['id']);
        $response = [];

        $citas = Citas::find($citas_id);

        if ($citas) {
            $citas->doctor->persona;
            $citas->servicios;
            $citas->mascota;
            $citas->mascota->tipo_mascota;
            $citas->mascota->genero_mascota;
            $citas->mascota->raza;
            $citas->cliente->persona;
            $citas->estado_cita;
            $citas->horarios_atencion;
            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'citas' => $citas,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existen datos',
                'citas' => null,
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
        $receta_id = '';
        $cita_id = '';

        if ($cita) {
            $rec = $cita->receta;
            $cita_id = $cita->id;
            $hc_id = $cita->horarios_atencion_id;

            foreach ($rec as $item) { //receta
                $receta_id = $item->id;
            }

            $receta = Receta::find($receta_id);
            $receta->cita_id = $cita_id;
            $receta->pagado = 'S';
            $receta->save();

            $cita->estado_cita_id = $id_estado;
            $cita->save();

            $horarioC = Horarios_Atencion::find($hc_id);
            // $horarioC->libre = 'S';
            $horarioC->estado = 'I';
            $horarioC->save();

            switch ($id_cita) {
                case 1:
                    $mensajes = 'La cita ha sido pendiente';
                    break;
                case 2:
                    $mensajes = 'La cita ha sido atendida';
                    break;
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

    public function cancelar($params)
    {

        $this->cors->corsJson();
        $id_cita = intval($params['id_cita']);
        $id_estado = intval($params['estado_id']); //3 cancelado
        $mensajes = '';
        $response = [];

        $cita = Citas::find($id_cita);

        if ($cita) {
            $hc_id = $cita->horarios_atencion_id;

            $cita->estado_cita_id = $id_estado;
            $cita->save();

            $horarioC = Horarios_Atencion::find($hc_id);
            $horarioC->libre = 'S';
            $horarioC->save();

            switch ($id_cita) {
                case 1:
                    $mensajes = 'La cita ha sido cancelada';
                    break;
            }

            $response = [
                'status' => true,
                'mensaje' => $mensajes,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se puede cancelar la cita',
            ];
        }
        echo json_encode($response);
    }

    public function datatableclientecitaId($params)
    {
        $this->cors->corsJson();

        $cliente_id = intval($params['cliente_id']);
        $cita = Citas::where('cliente_id', $cliente_id)->orderBy('fecha','asc')->get();

        $data = [];
        $i = 1;
        foreach ($cita as $citasc) {
            $cli = $citasc->cliente->persona;
            $masc = $citasc->mascota->nombre;
            $doc = $citasc->doctor->persona;
            $serv = $citasc->servicios->nombre_servicio;
            $hor = $citasc->horarios_atencion->horario;
            $dataEstadoCita = $citasc->estado_cita;
            $dataFechaCita = $citasc->horarios_atencion->fecha;

            $estado = $citasc->estado_cita_id;
            //  $horario =$dc->horarios_atencion_id;

            if ($estado == 1) {
                $estado = '<span class="badge bg-warning" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
            } else if ($estado == 2) {
                $estado = '<span class="badge bg-success" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
            } else {
                $estado = '<span class="badge bg-danger" style="font-size: 1rem;">' . $dataEstadoCita->detalle . '</span>';
            }

            $botones = '<div class="text-center">
                            <button class="btn btn-sm btn-outline-danger" onclick="cancelar_cita(' . $citasc->id . ')">
                            <i class="fas fa-times"></i> Cancelar Cita
                            </button>

                            <button class="btn btn-sm btn-outline-success" onclick="ver_cita(' . $citasc->id . ')">
                            <i class="fas fa-clipboard-list"></i> Imprimir Cita
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => $cli->nombre . ' ' . $cli->apellido,
                2 => $masc,
                3 => $doc->nombre . ' ' . $doc->apellido,
                4 => $serv,
                5 => $hor,
                6 => $dataFechaCita,
                7 => $estado,
                8 => $botones,
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

    public function serviciomasAdquirido($params)
    {
        $this->cors->corsJson();
        $inicio = $params['inicio'];
        $fin = $params['fin'];
        $limite = intval($params['limite']);

        $atendidas = 2;  $response = [];

        $cita = Citas::where('fecha', '>=', $inicio)
            ->where('fecha', '<=', $fin)
            ->where('estado', 'A')
            ->where('estado_cita_id', $atendidas)
            ->take($limite)->get();

        $servicios_id = [];  $servicio2 = [];  $valorConsulta = 5; $total = [];

        foreach ($cita as $c) {
            $servicio = $c->servicios;
            $aux = [
                'id' => $servicio->id,
                'nombre' => $servicio->nombre_servicio,
                'precio' => $servicio->precio + $valorConsulta,
                'cantidad' => 1,
            ];
            $servicios_id[] = (object) $aux;
            $servicio2[] = $servicio->id;
            $total[] = $servicio->precio + $valorConsulta;
        }

        $totalGene = 0;
        //sumar los totales
        for ($i = 0; $i < count($total); $i++) {
            $totalGene += $total[$i];
        }

        $noRepetidos = array_values(array_unique($servicio2));
        $newArray = [];  $contador = 0;  $nombreS = "";

        //algoritmo para contar y eliminar los elementos repetidos de un array
        for ($i = 0; $i < count($noRepetidos); $i++) {
            $temp = [];
            foreach ($servicios_id as $item) {
                if ($item->id === $noRepetidos[$i]) {
                    $contador += $item->precio;
                    $nombreS = $item->nombre;
                    $temp[] = $item;
                }
            }
            $canti = $temp[0];
            $canti->cantidad = 0.5;
            foreach ($temp as $t) {
                $canti->cantidad = $canti->cantidad + $t->cantidad;
            }
            $result = $canti->cantidad;

            $aux = [
                'servicio_id' => $noRepetidos[$i],
                'precio' => $contador,
                'nombre_servicio' => $nombreS,
                'cantidad' => $result,
            ];

            $contador = 0;
            $newArray[] = (array) $aux;
            $aux = [];
        }

        
        $arrayOrdenado = $this->ordenarArray2($newArray);
        $arrayOrdenado = Helper::invertir_array($arrayOrdenado);

        $arraySecond = [];

        //recortar segun su limite
        if (count($arrayOrdenado) < $limite) {
            $arraySecond = $arrayOrdenado;
        } else if (count($arrayOrdenado) == $limite) {
            $arraySecond = $arrayOrdenado;
        } else if (count($arrayOrdenado) > $limite) {
            for ($i = 0; $i < $limite; $i++) {
                $arraySecond[] = $arrayOrdenado[$i];
            }
        }
        //ordenarlo por la cantidad mayor
        foreach ($arraySecond as $arr) {
            foreach ($arrayOrdenado as $orde) {
                if ($arr["cantidad"] == $orde["cantidad"]) {
                    $servers[] = $arr;
                }
            }
        }

        usort($servers, function($a, $b) {
            return $a["cantidad"] < $b["cantidad"] ? 1 : -1;
        });

        //echo json_encode($servers); die();

        $response = [
            'lista' => $servers,
            'total_general' => $totalGene,
        ];

        echo json_encode($response); 
    }


    public function agendamientospormedicos($params)
    {
        $this->cors->corsJson();

        $inicio = $params['inicio'];
        $fin = $params['fin'];
        $doctor_id = intval($params['doctor_id']);

        $estado_cita_atendidas = 2;

        $citas = Citas::where('estado_cita_id', $estado_cita_atendidas)
            ->where('doctor_id', $doctor_id)
            ->where('fecha', '>=', $inicio)
            ->where('fecha', '<=', $fin)->orderBy('fecha')->get();

        $nuevoArray = [];
        if (count($citas) > 0) {
            foreach ($citas as $item) {
                if ($item->doctor->id == $doctor_id) {
                    $nombresDoctor = $item->doctor->persona->nombre . ' ' . $item->doctor->persona->apellido;
                    $nombresCliente = $item->cliente->persona->nombre . ' ' . $item->cliente->persona->apellido;
                    $nombresMascota = $item->mascota->nombre;
                    $raza = $item->mascota->raza->raza;

                    $aux = [
                        'atendido' => $item->estado_cita->detalle,
                        'doctor' => $nombresDoctor,
                        'fecha' => $item->fecha,
                        'servicio' => $item->servicios->nombre_servicio,
                        'horario_atencion' => $item->horarios_atencion->horario,
                        'cliente' => $nombresCliente,
                        'nombreMascota' => $nombresMascota,
                        'raza' => $raza,
                    ];

                    $nuevoArray[] = (object) $aux;
                }
            }

            if (count($nuevoArray) > 0) {
                $response = [
                    'status' => true,
                    'mensaje' => 'si hay lista',
                    'data' => $nuevoArray,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'no hay datos',
                    'data' => [],
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no hay datos para la consulta',
                'data' => [],
            ];

        }
        echo json_encode($response);
    }

    public function mascotasmasatendidas($params)
    {
        $this->cors->corsJson();   
        $inicio = $params['inicio'];
        $fin = $params['fin'];
        $id_cliente = intval($params['cliente_id']);
       
        $atendidos = 2;  $response = [];  $mascota_id = []; $data = [];   $dataAux = [];      

        $citas = Citas::where('estado_cita_id', $atendidos)
                        ->where('cliente_id', $id_cliente)
                        ->where('fecha', '>=', $inicio)
                        ->where('fecha', '<=', $fin)->orderBy('fecha')->get();


        for ($i=0; $i < count($citas); $i++) {
            $data[] = $citas[$i];

            foreach($data as $d){
                $id_cita = $d->id;
                $id_cliente = $d->cliente_id;
                $nombreCliente = $d->cliente->persona->nombre.' '.$d->cliente->persona->apellido;
                $id_mascota = $d->mascota_id;
                $nombreMascota = $d->mascota->nombre;
                $atendidas = $d->estado_cita->detalle;
                $tipoMascota_id = $d->mascota->tipo_mascota_id;
                $servicios_id = $d->servicios_id;
                
            }


            $aux = [
                'cita_id' => $id_cita,
                'cliente_id' => $id_cliente,
                'nombre_cliente' => $nombreCliente,
                'mascota_id' => $id_mascota,
                'nombre_mascota' => $nombreMascota,
                'tipo_mascota_id' =>  $tipoMascota_id,
                'atendidas' => $atendidas,
                'servicios_id' => $servicios_id, 
                'cantidad' => 1,


            ];
            $dataAux[] = (object)$aux;
            $mascota_id[] = $id_mascota;
 
             
        }
        /* echo json_encode($dataAux); 
        echo json_encode($tipo_mascota_id); die(); */

        $noRepetidos = array_values(array_unique($mascota_id));
       

        $nuevoArray= [];    $cont = 0;

        //echo json_encode($nuevoArrayT); die();

        //recorrer mascota_id y eliminar los repetidos
        for ($k=0; $k < count($noRepetidos); $k++) { 
            foreach($dataAux as $da){
                if($da->mascota_id === $noRepetidos[$k]){
                    $cont += $da->cantidad;
                    $nombreCliente = $da->nombre_cliente;
                    $servi = $da->servicios_id;

                }
            }

           
            $aux = [
                'mascota_id' => $noRepetidos[$k],
                'cantidad' =>$cont,
                'nombre_cliente' => $nombreCliente,
                'servicios_id' => $servi
                
            ];
            $cont = 0;  
            $nuevoArray[] = (object)$aux;
            $aux =[];
        }

        //echo json_encode($arrayMascotaxTm); die();

        $arrayMascotaxId = $this->ordenarArray($nuevoArray);
        $arrayMascotaxId = Helper::invertir_array($arrayMascotaxId);

        $arrayFinal = [];

        $validaUnicoNombre = Citas::where('cliente_id',$id_cliente)->get()->first();
        $nombreClienteUnico[] = $validaUnicoNombre->cliente->persona->nombre.' '.$validaUnicoNombre->cliente->persona->apellido;

        //echo json_encode($nuevoArrayTipo); die();
        $totalPorcentaje = 0;
        
        foreach ($arrayMascotaxId as $key) {
            $mascota = Mascota::find($key->mascota_id);

            $servicios = Servicios::find($key->servicios_id);
            $todosServicios=$servicios->nombre_servicio;
            

            $nombreMascota = $mascota->nombre;
            $cantidad = $key->cantidad;
            $tipomascota = $mascota->tipo_mascota->nombre_tipo;
            $totalPorcentaje  += $key->cantidad;
           
           
            $aux = [
                'nombreMascota' => $nombreMascota,
                'cantidadDeMascotaMasAtendida' =>$cantidad,
                'tipomascota' =>$tipomascota,
                'servicios' => $todosServicios                   
            ];

            $arrayFinal[] = (object)$aux;
        }


        //armar el grafico para la mascot mas atendida

        $masAtendidas = []; $labels = [];   $porcentaje = []; 

        foreach($arrayFinal as $item){
            $labels[] = $item->nombreMascota;
            $masAtendidas[] = $item->cantidadDeMascotaMasAtendida;
            $por = round((100 * $item->cantidadDeMascotaMasAtendida) / $totalPorcentaje,2);
            $porcentaje[] = $por;
        
        }




        $response = [
            'lista' => [
                'data' => $arrayFinal,
                'unicoNombre' => $nombreClienteUnico,   
            ],
            'grafico' => [
                'datos' => $masAtendidas,
                'labels' => $labels       
            ],
            'porcentajes' => [
                'datos' => $porcentaje,
                'labels' => $labels
            
            ]
           
        ];
        
        
        
        echo json_encode($response); die(); 


       

    }

    function ordenarArray($array){
        for ($i=1; $i < count($array); $i++) { 
            for ($j=0; $j < count($array) - $i; $j++) { 
                if($array[$j]->cantidad > $array[$j + 1]->cantidad){
                    $chelas = $array[$j + 1];
                    $array[$j + 1] = $array[$j];
                    $array[$j] = $chelas;
                }
            }
            
        }
        return $array;
    } 

    function ordenarArray2($array){
        for ($i=1; $i < count($array); $i++) { 
            for ($j=0; $j < count($array) - $i; $j++) { 
                if($array[$j] > $array[$j + 1]){
                    $chelas = $array[$j + 1];
                    $array[$j + 1] = $array[$j];
                    $array[$j] = $chelas;
                }
            }
            
        }
        return $array;
    }


    

}