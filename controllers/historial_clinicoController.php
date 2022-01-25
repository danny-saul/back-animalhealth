<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/historial_clinicoModel.php';
require_once 'models/codigosModel.php';
require_once 'controllers/antecedentesController.php';
require_once 'controllers/examen_fisicoController.php';
require_once 'controllers/perscripcionController.php';




class Historial_ClinicoController{

    private $cors;
  

    public function __construct()
    {
        $this->cors = new Cors();

    }

    public function generar_codigos($params){
        $this->cors->corsJson();
        $tipos = $params['tipos'];
        $response = [];

        $codigos = Codigos::where('tipos',$tipos)->orderBy('id','DESC')->first();

        if($codigos == null){
            $response = [
                'status' =>true,
                'tipo' =>$tipos,
                'mensaje' => 'Primer Numero',
                'codigo' => '000001'
            ];
        }else{
            $numero = intval($codigos->codigo);
            $numeroSiguiente = '00000'. ($numero += 1);
            $response = [
                'status' =>true,
                'tipo' =>$tipos,
                'mensaje' => 'Aumentando codigos ',
                'codigo' => $numeroSiguiente
            ];
        }
        echo json_encode($response);
    }

    public function aumentarCodigo(Request $request){
        $this->cors->corsJson();
        $codigoRequest = $request->input('codigo');
        $codigo = $codigoRequest->codigo;
        $tipos = $codigoRequest->tipos;
        $response = [];
        
        if($codigoRequest  == null){
            $response = [
                'status' => false,
                'mensaje' => 'no ahi datos para procesar'
            ];
        }else{
            $nuevoCodigo = new Codigos();
            $nuevoCodigo->codigo = $codigo;
            $nuevoCodigo->tipos = $tipos;
            $nuevoCodigo->estado = 'A';
            $nuevoCodigo->save();

            $response = [
                'status' => true,
                'mensaje' => 'Guardando Datos',
                'codigo' => $nuevoCodigo
            ];
        }
        echo json_encode($response);

    }

    public function guardarhistorial_clinico(Request $request){
        $this->cors->corsJson();
        $response = [];

        $HistorialClinicoRequest = $request->input('historial_clinico');
        $antecedentesRequest = $request->input('antecedentes');
        $examenFisicoRequest = $request->input('examen_fisico');
        $perscripcionRequest = $request->input('perscripcion');

        if($HistorialClinicoRequest){
            $cliente_id = intval($HistorialClinicoRequest->cliente_id);
            $mascota_id = intval($HistorialClinicoRequest->mascota_id);
            $numero_historia = $HistorialClinicoRequest->numero_historia;

            $nuevoHC = new Historial_Clinico();
            $nuevoHC->cliente_id = $cliente_id;
            $nuevoHC->mascota_id = $mascota_id;
            $nuevoHC->numero_historia = $numero_historia;
            $nuevoHC->motivo_consulta = $HistorialClinicoRequest->motivo_consulta;
            $nuevoHC->fecha_h = date('Y-m-d');
            $nuevoHC->estado = 'A';
           
            $existeNumeroHistorial = Historial_Clinico::where('numero_historia',$numero_historia)->get()->first();
            
            if($existeNumeroHistorial){
                $response = [
                    'status' => false,
                    'mensaje' => 'El número ya existe',
                    'historial_clinico' => null,
                    'antecedentes' => null,
                    'examen_fisico' => null,
                    'perscripcion' => null

                ];
            }else{
                if($nuevoHC->save()){
                    //guardar en la tabla antecedentes
                    $antecedentesController = new AntecedentesController();
                    $extraAntecedentes = $antecedentesController->guardarAntecedentes($nuevoHC->id,$antecedentesRequest);
                    
                    //guarda en la tabla examen-fisico
                    $examenFisicoController = new Examen_FisicoController();
                    $extraExamenFisicoController = $examenFisicoController->guardarExamenFisico($nuevoHC->id,$examenFisicoRequest);

                    //guarda en la tabla Perscripcion
                    $perscripcionController = new PerscripcionController();
                    $extraPerscripcion = $perscripcionController->guardarPerscripcion($nuevoHC->id,$perscripcionRequest);

                    $response = [
                        'status' => true,
                        'mensaje' => 'Se guardo correctamente',
                        'historial_clinico' => $nuevoHC,
                        'antecedentes' => $extraAntecedentes,
                        'examen_fisico' => $extraExamenFisicoController,
                        'perscripcion' => $extraPerscripcion,
                    ];
                }else{
                    $response = [
                        'status' => false,
                        'mensaje' => 'No se pudo guardar :(',
                        'historial_clinico' => null,
                        'antecedentes' => null,
                        'examen_fisico' => null,
                        'perscripcion' => null
                    ];
                }
            }
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'historial_clinico' => null
            ];
        }
        echo json_encode($response);
    }

}