<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'models/usuarioModel.php';
require_once 'models/personaModel.php';
require_once 'models/clienteoModel.php';
require_once 'controllers/personaController.php';

class ClienteoController
{

    private $cors;
    private $personaController;

    public function __construct()
    {
        $this->cors = new Cors();
        $this->personaController = new PersonaController();
    }

        //crear cuentas clientes para utilizar el sistema solo rol cliente = 5
        public function guardarRolCliente(Request $request)
        {
            $this->cors->corsJson();
            $response = [];
    
            $dataRolClienteRequest = $request->input('usuariocliente');
    
            if (!isset($dataRolClienteRequest) || $dataRolClienteRequest == null) {
                $response = [
                    'status' => false,
                    'mensaje' => "No hay datos para procesar",
                    'usuario' => null,
                ];
            } else {
                $respPersona = $this->personaController->guardarPersona($request);
    
                $persona_id = $respPersona['persona']->id; //recuperar el id de persona
                $clave = $dataRolClienteRequest->password;
                $encriptar = hash('sha256', $clave);
    
                $newUsuario = new Usuario();
                $newUsuario->persona_id = $persona_id;
                $newUsuario->roles_id = $dataRolClienteRequest->roles_id;
                $newUsuario->usuario = $dataRolClienteRequest->usuario;
                $newUsuario->correo = $dataRolClienteRequest->correo;
                $newUsuario->password = $encriptar;
                $newUsuario->password2 = $encriptar;
                $newUsuario->imagen = '';
                $newUsuario->estado = 'A';
    
                //exixte usuario
                $existeUsuario = Usuario::where('persona_id', $persona_id)->get()->first();
    
                if ($existeUsuario) {
                    $response = [
                        'status' => false,
                        'mensaje' => 'El usuario ya se encuentra registrado',
                        'usuario' => null,
                    ];
                } else {
                    if ($newUsuario->save()) {
                        if ($dataRolClienteRequest->roles_id == 5) {
                            $newCliente = new Cliente();
                            $newCliente->persona_id = $persona_id;
                            $newCliente->estado = 'A';
    
                            if ($newCliente->save()) {
                                $response = [
                                    'status' => true,
                                    'mensaje' => 'El cliente se ah registrado en el sisttema',
                                    'cliente' => $newCliente,
                                ];
                            } else {
                                $response = [
                                    'status' => false,
                                    'mensaje' => 'El cliente no se pudo registrar',
                                    'cliente' => null,
                                ];
                            }
                        } else {
                            $response = [
                                'status' => false,
                                'mensaje' => 'no ahi datos para procesar',
                                'cliente' => null,
                            ];
                        }
                    } else {
                        $response = [
                            'status' => false,
                            'mensaje' => 'El usuario no se ha registrado',
                            'usuario' => null,
                        ];
                    }
                }
            }
            echo json_encode($response);
        }

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