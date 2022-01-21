<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'core/conexion.php';
require_once 'app/error.php';
require_once 'app/helper.php';
require_once 'models/mascotaModel.php';

class MascotaController
{
    private $cors;

    public function __construct()
    {
        $this->cors = new cors;
    }

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        //ojeto hacer en el front
        $datamascotarequest = $request->input('mascota');
        
        $response = [];
        if ($datamascotarequest) {
            $cliente_id = intval($datamascotarequest->cliente_id);       
            $tipo_mascota_id = intval($datamascotarequest->tipo_mascota_id);
            $genero_mascota_id = intval($datamascotarequest->genero_mascota_id);
            $raza_id = intval($datamascotarequest->raza_id);

                $nuevamascota = new Mascota();
                $nuevamascota->cliente_id = $cliente_id;
                $nuevamascota->tipo_mascota_id = $tipo_mascota_id;
                $nuevamascota->genero_mascota_id = $genero_mascota_id;
                $nuevamascota->raza_id = $raza_id;
                $nuevamascota->nombre = $datamascotarequest->nombre;
                $nuevamascota->edad = $datamascotarequest->edad;
                $nuevamascota->peso = $datamascotarequest->peso;
                $nuevamascota->fecha_nacimiento = $datamascotarequest->fecha_nacimiento;
                $nuevamascota->imagen = $datamascotarequest->imagen;
                $nuevamascota->estado = 'A';
                //echo json_encode($nuevamascota); die(); 
                
                $nuevamascota->save(); 
                    $response = [
                        'status' => true,
                        'mensaje' => 'La mascota con su cliente se han asignado',
                        'mascota' => $nuevamascota,
                    ];     

        } else {
            $response = [
                'status' => false,
                'mensaje' => 'La mascota con su cliente no se han asignado',
                'mascota' => null,
            ];
        }
        echo json_encode($response);
    }


    public function subirFichero($file)
    {
        $this->cors->corsJson();
        $img = $file['fichero'];
        $path = 'fotos/mascotas/';

        $response = Helper::save_file($img, $path);
        echo json_encode($response);
    }

    public function getMascotadatatable(){
        $this->cors->corsJson();
        $datamascota = Mascota::where('estado', 'A')->get();
        $data = [];
        $i = 1;

        foreach ($datamascota as $dd) {
            $tipo_mascota = $dd->tipo_mascota;
            $genero_mascota = $dd->genero_mascota;
            $raza = $dd->raza;
            $cliente= $dd->cliente;

            $icono = $dd->estado == 'I' ? '<i class="fa fa-check-circle fa-lg"></i>' : '<i class="fa fa-trash fa-lg"></i>';
            $clase = $dd->estado == 'I' ? 'btn-success btn-sm' : 'btn-dark btn-sm';
            $other = $dd->estado == 'A' ? 0 : 1;

            $botones = '<div class="btn-group">
                        <button class="btn btn-primary btn-sm" onclick="editar_mascota(' . $dd->id . ')">
                            <i class="fa fa-edit fa-lg"></i>
                        </button>
                        <button class="btn ' . $clase . '" onclick="eliminar_mascota(' . $dd->id . ',' . $other . ')">
                            ' . $icono . '
                        </button>
                    </div>';

            $data[] = [
                0 => $i,
                1 => $cliente->persona->nombre .' '.$cliente->persona->apellido,
                2 => $dd->nombre,
                3 => $dd->edad,
                4 => $tipo_mascota->nombre_tipo,
                5 => $raza->raza,
                6 => $genero_mascota->genero,
                7 => $dd->peso,
                8 => $dd->fecha_nacimiento,
                9 => $botones,
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

    public function eliminarmascota(Request $request)
    {
        $this->cors->corsJson();
        $datamascotarequest = $request->input('mascota');

        $id = $datamascotarequest->id;
        $datamascota = Mascota::find($id);

        if ($datamascotarequest) {
            if ($datamascota) {
                $datamascota->estado = 'I';
                $datamascota->save();
                $response = [
                    'status' => true,
                    'mensaje' => "Se ha eliminado la mascota",
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => "No se puede eliminar la mascota",
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

    public function listarmascotaId($params)
    {
        $this->cors->corsJson();
        $id = intval($params['id']);
        $response = [];

        $dataMascota = Mascota::find($id);

        if($dataMascota){
            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'mascota' => $dataMascota,
                'persona_id' => $dataMascota->cliente->persona->id,
                'tipo_mascota_id' => $dataMascota->tipo_mascota->id,
                'genero_mascota_id' => $dataMascota->genero_mascota->id,
                'raza_id' => $dataMascota->raza->id
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No existen datos',
                'mascota' => null
            ];
        }       
        echo json_encode($response);
    }

    public function listarmascota()
    {    
        $this->cors->corsJson();
        $response = [];

        $dataMascota = Mascota::where('estado','A')->orderBy('cliente_id','DESC')->get();

        if($dataMascota){
            foreach($dataMascota as $dm){
                $dm->cliente->persona;
                $dm->tipo_mascota;
                $dm->genero_mascota;
                $dm->raza;
            }
            
            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'mascota' => $dataMascota, 
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No existen datos',
                'mascota' => null
            ];
        }       
        echo json_encode($response);
    }

    public function cargarMascotaCliente($params){
        $this->cors->corsJson();
        $cliente_id = intval($params['cliente_id']);
        $response=[];
        
        $mascota = Mascota::where('cliente_id',$cliente_id)
                            ->where('estado','A')->get();
        if(count($mascota) >0){

            $response=[
                'status'=>true,
                'mensaje'=>'si hay datos',
                'mascota'=>$mascota,
            ];
        }else{
            $response=[
                'status'=>false,
                'mensaje'=>'no hay datos',
                'mascota'=>null,
            ];
        }


        echo json_encode($response);

    }
}