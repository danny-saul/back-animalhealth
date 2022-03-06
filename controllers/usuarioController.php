<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'core/conexion.php';
require_once 'app/error.php';
require_once 'app/helper.php';
require_once 'models/usuarioModel.php';
require_once 'models/personaModel.php';
require_once 'models/clienteModel.php';
require_once 'models/doctorModel.php';
require_once 'controllers/personaController.php';
require_once 'controllers/doctorController.php';
require_once 'controllers/doctor_HorarioController.php';
 
class UsuarioController
{

    private $cors;
    private $personaController;
    private $doctorController;
    private $doctorHorarioController;
 
    public function __construct()
    {
        $this->cors = new Cors();
        $this->personaController = new PersonaController();
        $this->doctorController = new DoctorController();
        $this->doctorHorarioController = new Doctor_HorarioController();
     }

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $response = [];
        $datausuariorequest = $request->input('usuario');
        $datadoctorrequest = $request->input('doctor');
        //$datadoctorhorariorequest = $request->input('doctorhorario');
        $dataclienterequest = $request->input('cliente');

        //$horarios_atencion_id = intval($datadoctorhorariorequest->horarios_atencion_id);

        if (!isset($datausuariorequest) || $datausuariorequest == null) {
            $response = [
                'status' => false,
                'mensaje' => "No hay datos para procesar",
                'usuario' => null,
            ];
        } else {
            $responsePersona = $this->personaController->guardarPersona($request);

            //recuperar el id de persona
            $id_persona = $responsePersona['persona']->id;

            $clave = $datausuariorequest->password; //cedula
            $encriptar = hash('sha256', $clave);

            $nuevoUsuario = new Usuario();

            $nuevoUsuario->persona_id = $id_persona;
            $nuevoUsuario->roles_id = $datausuariorequest->roles_id;
            $nuevoUsuario->usuario = $datausuariorequest->usuario;
            $nuevoUsuario->correo = $datausuariorequest->correo;
            $nuevoUsuario->password = $encriptar;
            $nuevoUsuario->password2 = $encriptar;
            $nuevoUsuario->imagen = $datausuariorequest->imagen;
            $nuevoUsuario->estado = 'A';

            //exixte usuario
            $existe_usuario = Usuario::where('persona_id', $id_persona)->get()->first();

            if ($existe_usuario) {
                $response = [
                    'status' => false,
                    'mensaje' => 'El usuario ya se encuentra registrado',
                    'usuario' => null,
                ];
            } else {
                if ($nuevoUsuario->save()) {

                    //registrar en la tabla doctores
                    if ($datausuariorequest->roles_id == 3) {
                        $responseDoctor = $this->doctorController->guardardoctor($datadoctorrequest, $id_persona);
                        if ($responseDoctor == false) {
                            $response = [
                                'status' => false,
                                'mensaje' => 'El Doctor ya se encuentra registrado',
                                'usuario' => $responseDoctor,
                            ];
                        } else {
                            $response = [
                                'status' => true,
                                'mensaje' => 'El doctor se ha registrado',
                                'doctor' => $responseDoctor,
                       //         'doctor_horario' => $responseDoctorHorario,
                            ];
                            //recuperar el id del doctor
                          //  $iddoctor = $responseDoctor->id;
                            //guardar en la tabla doctor horario
                     //       $responseDoctorHorario = $this->doctorHorarioController->guardardoctorhorario($datadoctorhorariorequest, $iddoctor, $horarios_atencion_id);
                     /*        if ($responseDoctorHorario) {
                                $response = [
                                    'status' => true,
                                    'mensaje' => 'El doctor se ha registrado',
                                    'doctor' => $responseDoctor,
                           //         'doctor_horario' => $responseDoctorHorario,
                                ];

                            }  */
                        }
                    }else{

                        if($datausuariorequest->roles_id == 5){//cliente
                            $nuevoCliente= new Cliente();
                            $nuevoCliente->persona_id= $id_persona;
                            $nuevoCliente->estado = 'A';
                            $nuevoCliente->save();
                        }

                    }
                    $response = [
                        'status' => true,
                        'mensaje' => 'El usuario se ha registrado',
                        'usuario' => $nuevoUsuario,
                    ];
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

    public function dataTable()
    {
        $this->cors->corsJson();
        $datausuario = Usuario::where('estado', 'A')->get();
        $data = [];
        $i = 1;

        foreach ($datausuario as $du) {
            $personas = $du->persona;
            $roles = $du->roles;

            $url = BASE . 'fotos/usuarios/' . $du->imagen;
            $icono = $du->estado == 'I' ? '<i class="fa fa-check-circle fa-lg"></i>' : '<i class="fa fa-trash fa-lg"></i>';
            $clase = $du->estado == 'I' ? 'btn-success btn-sm' : 'btn-dark btn-sm';
            $other = $du->estado == 'A' ? 0 : 1;

            $botones = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm" onclick="editar_usuario(' . $du->id . ')">
                                <i class="fa fa-edit fa-lg"></i>
                            </button>
                            <button class="btn ' . $clase . '" onclick="eliminar_usuario(' . $du->id . ',' . $other . ')">
                                ' . $icono . '
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => '<div class="box-img-usuario"><img src=' . "$url" . '></div>',
                2 => $personas->cedula,
                3 => $personas->nombre,
                4 => $personas->apellido,
                5 => $du->usuario,
                6 => $roles->rol,
                7 => $personas->telefono,
                8 => $du->correo,
                9 => $personas->direccion,
                10 => $botones,
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

    /*   public function loginAntiguo(Request $request)
    {
        $data = $request->input('credenciales');
        $entrada = $data->entrada; //cedula
        $clave = $data->clave;
        $encriptar = hash('sha256', $clave);

        $this->cors->corsJson();
        $response = [];
        if ((!isset($entrada) || $entrada == "") || (!isset($clave) || $clave == "")) {
            $response = [
                'estatus' => false,
                'mensaje' => 'Falta datos',
            ];
        } else {
            $usuario = Usuario::where('correo', $entrada)->get()->first();
            if ($usuario) {
                $us = $usuario;
                //Segun con la verificacion de credenciales
                if ($encriptar == $us->password) {
                    $persona = Persona::find($us->persona->id);

                    $per = $us->persona->nombre . " " . $us->persona->apellido;
                    $rol = $us->roles->rol;
                    //echo json_encode($persona); die();

                    $response = [
                        'status' => true,
                        'mensaje' => 'Sesion iniciada',
                        'rol' => $rol,
                        'persona' => $per,
                        'usuario' => $us,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'La contraseña es incorrecta',
                    ];
                }
            } else {
                $response = [
                    'estatus' => false,
                    'mensaje' => 'El correo no existe',
                ];

            }

        }

        echo json_encode($response);
    } */

    public function login(Request $request)
    {
        $data = $request->input('credenciales');
        $entrada = $data->entrada; //cedula
        $clave = $data->clave;
        $encriptar = hash('sha256', $clave);

        $this->cors->corsJson();
        $response = [];
        if ((!isset($entrada) || $entrada == "") || (!isset($clave) || $clave == "")) {
            $response = [
                'estatus' => false,
                'mensaje' => 'Falta datos',
            ];
        } else {
            $usuario = Usuario::where('correo', $entrada)->get()->first();

        
            $doctor = $usuario->persona->doctor;
            $doc_id = [];  $cliente_id = [];

            foreach ($doctor as $doc) {
                $doc_id = intval($doc->id);
            }

            if ($usuario) {

                $ArrayIdCliente = $usuario->persona->cliente;

                foreach($ArrayIdCliente as $chelas){
                   $cliente_id = $chelas->id;
    
                }

                $us = $usuario;
                //Segun con la verificacion de credenciales
                if ($encriptar == $us->password) {
                    $persona = Persona::find($us->persona->id);
        
                        $per = $us->persona->nombre . " " . $us->persona->apellido;
                        $rol = $us->roles->rol;

                        $response = [
                            'status' => true,
                            'mensaje' => 'Sesion iniciada',
                            'rol' => $rol,
                            'persona' => $per,
                            'usuario' => $us,
                            'doctor' => $doc_id,
                            'cliente' => $cliente_id 
                        ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'La contraseña es incorrecta',
                    ];
                }
            } else {
                $response = [
                    'estatus' => false,
                    'mensaje' => 'El correo no existe',
                ];

            }

        }

        echo json_encode($response);
    }

    public function eliminar(Request $request)
    {
        $this->cors->corsJson();
        $datausuariorequest = $request->input('usuario');

        $id = $datausuariorequest->id;
        $datausuario = Usuario::find($id);

        if ($datausuariorequest) {
            if ($datausuario) {
                $datausuario->estado = 'I';
                $datausuario->save();
                $response = [
                    'status' => true,
                    'mensaje' => "Se ha eliminado el usuario",
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => "No se puede eliminar el usuario",
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

    public function subirFichero($file)
    {
        $this->cors->corsJson();
        $img = $file['fichero'];
        $path = 'fotos/usuarios/';

        $response = Helper::save_file($img, $path);
        echo json_encode($response);
    }

    public function getporidusuario($params)
    {
        $this->cors->corsJson();
        $id = intval($params['id']);
        $datausuario = Usuario::find($id);
        $response = [];

        if ($datausuario) {
            $datausuario->roles;
            $datausuario->persona->sexo;

            $doctor = $datausuario->persona->doctor;

            foreach ($doctor as $item) {
                $item->persona->id;
                $doctorHorario = $item->doctor_horario;
                foreach ($doctorHorario as $item2) {
                    $item2->horarios_atencion;
                }
            }
            $response = [
                'status' => true,
                'mensaje' => 'Si hay datos',
                'usuario' => $datausuario,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
                'usuario' => null,
            ];
        }
        echo json_encode($response);
    }

    public function editarUsuario(Request $request)
    {
        $this->cors->corsJson();
        $usuariorequest = $request->input('usuario');
        $idusuario = intval($usuariorequest->id); //
        $personaid = intval($usuariorequest->persona_id); //
        $roles_id = intval($usuariorequest->roles_id); //
        $sexoid = intval($usuariorequest->sexo_id); //
        $doctorid = intval($usuariorequest->doctor_id); //
        $doctorHorario_id = intval($usuariorequest->doctor_horario_id); //
        $horarioatencionid = intval($usuariorequest->horario_atencion_id); //

        $response = [];
        $usuariodata = Usuario::find($idusuario); //

        if ($usuariorequest) {
            if ($usuariodata) { //usuario
                $usuariodata->persona_id = $personaid; //
                $usuariodata->roles_id = $roles_id; //
                $usuariodata->usuario = $usuariorequest->usuario; //
                $usuariodata->correo = $usuariorequest->correo; //

                $personadata = Persona::find($usuariodata->persona_id); //persona
                $personadata->nombre = $usuariorequest->nombre; //
                $personadata->apellido = $usuariorequest->apellido; //
                $personadata->telefono = $usuariorequest->telefono; //
                $personadata->direccion = $usuariorequest->direccion; //
                $personadata->sexo_id = $sexoid; //
                $personadata->save();
                $usuariodata->save();

                if ($usuariodata->save()) {
                    $doctorHorarioData = Doctor_Horario::find($doctorHorario_id); //doctor_horario

                    if ($doctorHorarioData == null) {
                        $response = [
                            'status' => true,
                            'mensaje' => 'Se actualizo el usuario',
                        ];

                    } else {
                        $doctorHorarioData->horarios_atencion_id = $horarioatencionid; //
                        $doctorHorarioData->save();
                        $response = [
                            'status' => true,
                            'mensaje' => 'Se actualizo el horario de atencio',
                        ];
                    }
                }
                $response = [
                    'status' => true,
                    'mensaje' => 'el usuario se ha actualizado',
                    'usuario' => $usuariodata,
                ];

            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar el usuario',
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

     public function cantidad(){
         $this->cors->corsJson();
         $datausuario= Usuario::where('estado','A')->get();
         $response = [];

         if($datausuario){
             $response =[
                 'status'=>true,
                 'mensaje'=>'existe datos',
                 'modelo'=>'Usuarios',
                 'cantidad'=>$datausuario->count(),
             ];
         }else{
            $response =[
                'status'=>false,
                'mensaje'=>'no existe datos',
                'modelo'=>'Usuario',
                'cantidad'=>0,
            ];

         }
         echo json_encode($response);
     }

}
