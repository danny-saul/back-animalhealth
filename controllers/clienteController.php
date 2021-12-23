<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'models/personaModel.php';
require_once 'models/clienteModel.php';
require_once 'controllers/personaController.php';

class ClienteController
{

    private $cors;
    private $personaController;

    public function __construct()
    {
        $this->cors = new Cors();
        $this->personaController = new PersonaController();
    }
    //tabla cliente
/*     public function guardarCliente($cliente, $persona_id){
        if ($cliente) {
        $nuevocliente = new Cliente();
        $nuevocliente->persona_id = $persona_id;
        $nuevocliente->estado = 'A';
        $nuevocliente->save();

        return $nuevocliente;

    } else {
        return null;
    }

    } */

    public function getClienteId($params){
        $this->cors->corsJson();
        $id = intval($params['id']);
        $datacliente = Cliente::find($id);
        $response = [];

        if ($datacliente) {
            $datacliente->persona->sexo;

            $response = [
                'status' => true,
                'mensaje' => 'Si hay datos',
                'cliente' => $datacliente,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
                'cliente' => null,
            ];
        }
        echo json_encode($response);
    }

    public function guardar(Request $request){
        $this->cors->corsJson();
        $response = [];

        $dataPersona = $this->personaController->guardarPersona($request);
        $objetoPersona = (object) $dataPersona;

        if($objetoPersona->status){
            $nuevoCliente = new Cliente();
            $nuevoCliente->persona_id = $objetoPersona->persona->id;
            $nuevoCliente->estado = 'A';

            if($nuevoCliente->save()){
                $response = [
                    'status' => true,
                    'mensaje' => 'Se ha registrado el cliente',
                    'persona' => $nuevoCliente->persona->cedula,
                    'cliente' => $nuevoCliente,
                ];
            }else{
                $response = [
                    'status' => false,
                    'mensaje' => 'Se ha registrado el cliente',
                    'cliente' => null,
                ];
            }          
        }else{
            $response = [
                'status' => false,
                'mensaje' => $objetoPersona->mensaje,
                'cliente' => null
            ];
        }
        echo json_encode($response);

    }

    public function datatable()
    {     
        $this->cors->corsJson();
        $datacliente = Cliente::where('estado', 'A')->get();
        $data = [];   $i = 1;

        foreach ($datacliente as $dc) {
            $personas = $dc->persona;
            $sexo = $dc->persona->sexo;

            $icono = $dc->estado == 'I' ? '<i class="fa fa-check-circle fa-lg"></i>' : '<i class="fa fa-trash fa-lg"></i>';
            $clase = $dc->estado == 'I' ? 'btn-success btn-sm' : 'btn-dark btn-sm';
            $other = $dc->estado == 'A' ? 0 : 1;

            $botones = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm" onclick="editar_cliente(' . $dc->id . ')">
                                <i class="fa fa-edit fa-lg"></i>
                            </button>
                            <button class="btn ' . $clase . '" onclick="eliminar_cliente(' . $dc->id . ',' . $other . ')">
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
                6 => $sexo->tipo,
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

    public function eliminar(Request $request)
    {
        $this->cors->corsJson();
        $dataclienterequest = $request->input('cliente');

        $id = $dataclienterequest->id;
        $datacliente = Cliente::find($id);

        if ($dataclienterequest) {
            if ($datacliente) {
                $datacliente->estado = 'I';
                $datacliente->save();
                $response = [
                    'status' => true,
                    'mensaje' => "Se ha eliminado el cliente",
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => "No se puede eliminar el cliente",
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

    public function editar(Request $request)
    {
        $this->cors->corsJson();
        $clienterequest = $request->input('cliente');
        $idcliente = intval($clienterequest->id); //
        $personaid = intval($clienterequest->persona_id); //
        $sexoid = intval($clienterequest->sexo_id); //

        $response = [];
        $clientedata = Cliente::find($idcliente); //

        if ($clienterequest) {
            if ($clientedata) { //cliente
                $clientedata->persona_id = $personaid; //

                $personadata = Persona::find($clienterequest->persona_id); //persona
                $personadata->nombre = $clienterequest->nombre; //
                $personadata->apellido = $clienterequest->apellido; //
                $personadata->telefono = $clienterequest->telefono; //
                $personadata->direccion = $clienterequest->direccion; //
                $personadata->sexo_id = $sexoid; //
                $personadata->save();
                $clientedata->save();
    
                $response = [
                    'status' => true,
                    'mensaje' => 'El cliente se ha actualizado',
                    'usuario' => $clientedata,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar el cliente',
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos ',
            ];
        }
        echo json_encode($response);
    }

    public function listarCliente(){
       
        $this->cors->corsJson();
        $response=[];
        $dataCliente = Cliente::where('estado','A')->get();

        if($dataCliente){
            foreach($dataCliente as $item){
                $item->persona;
            }
            $response=[
                'status'=>true,
                'mensaje'=>'Si hay datos',
                'cliente'=>$dataCliente
            ];


        }else{
            $response=[
                'status'=>false,
                'mensaje'=>'No hay datos',
                'cliente'=>null
            ];
        }
        echo json_encode($response);


    } 
    
 

    



}