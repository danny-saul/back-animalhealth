<?php

require_once 'core/conexion.php';
require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/evaluar_servicioModel.php';
require_once 'models/detalleModel.php';


class Evaluar_ServicioController{

    private $cors;
    private $conexion;
  

    public function __construct()
    {
        $this->cors = new Cors();
        $this->conexion = new Conexion();
    }

    public function guardarevaluarservicio(Request $request){
        //   echo json_encode($request); die();
           $this->cors->corsJson();
           $evaluacionsrequest = $request->input('evaluar_servicio');
           $response = [];
           if($evaluacionsrequest){
               $clienteid = intval($evaluacionsrequest->cliente_id);
               $detalleid = intval($evaluacionsrequest->detalle_id);
               $valoracion = ucfirst($evaluacionsrequest->valoracion);
               
               $nuevosevaluacion = new Evaluar_Servicio();
               $nuevosevaluacion->cliente_id=$clienteid;
               $nuevosevaluacion->detalle_id=$detalleid;
               $nuevosevaluacion->valoracion=$valoracion;
               $nuevosevaluacion->fecha=date('Y-m-d');
               $nuevosevaluacion->estado= 'A';
   
               if($nuevosevaluacion->save()){
                   $response = [
                       'status'=>true,
                       'mensaje'=>'se guardo el servicio evaluado',
                       'data'=>$nuevosevaluacion,
                   ];
               }else{
                   $response = [
                       'status'=>false,
                       'mensaje'=>'no se guardo el servicio evaluado',
                       'data'=>null,
                   ];
   
               }
   
           } else{
               $response = [
                   'status'=>false,
                   'mensaje'=>'no hay datos para procesar',
                   'data'=>null,
               ];
           }
   
           echo json_encode($response);

    }

    public function servicioevaluarkpi(){
        $this->cors->corsJson();
        $sumapuntuaciones=0;
        $totalvaloracionesobtenidas=0;
        $numerovaloracionpositiva=0;
       
        $sql = "SELECT SUM(d.valor) as valor, COUNT(s.id) FROM evaluar_servicio s
        INNER JOIN detalle d ON d.id = s.detalle_id WHERE s.estado = 'A' AND s.valoracion = 'P'";
        $sumapuntuaciones = $this->conexion->database::select($sql);

        $sql2 = "SELECT SUM(d.valor) as valor, COUNT(s.id) FROM evaluar_servicio s
        INNER JOIN detalle d ON d.id = s.detalle_id WHERE s.estado = 'A' AND s.valoracion = 'N'";
        $sumapuntuaciones2 = $this->conexion->database::select($sql2);

        $sumapuntuaciones = intval($sumapuntuaciones[0]->valor);
        $totalvaloracionesobtenidas = Evaluar_Servicio::count('id');

        $sumapuntuaciones2 = intval($sumapuntuaciones2[0]->valor);

        $csat_promedio = round(($sumapuntuaciones / $totalvaloracionesobtenidas),2); //formulaPositiva
        $csat_promedioN = round(($sumapuntuaciones2 / $totalvaloracionesobtenidas),2); //formulaNegativa

        $saP = Evaluar_Servicio::where('estado','A')->where('valoracion','P')->get();
        foreach ($saP as $key) {
            $labelsPositivos = $key->valoracion;
        }

        $saN = Evaluar_Servicio::where('estado','A')->where('valoracion','N')->get();
        foreach ($saN as $key) {
            $labelsNegativos = $key->valoracion;
        }

        //echo json_encode($labelsNegativos); die();
        
        $mensaje = '';
        $mensaje2 = ''; 
        
        if($labelsPositivos == 'P'){
            $mensaje = 'Positivo';
        }
        if($labelsNegativos == 'N'){
            $mensaje2 = 'Negativo';
        }
        
        
        $numerovaloracionpositiva = Evaluar_Servicio::where('valoracion','P')->count();
        $csat_porcentaje = round((($numerovaloracionpositiva / $totalvaloracionesobtenidas) * 100),2);//formula2 

        $numerovaloracionnegativa = Evaluar_Servicio::where('valoracion','N')->count();
        $csat_porcentajeN = round((($numerovaloracionnegativa / $totalvaloracionesobtenidas) * 100),2);//formula2 
        
        $mensajePP = ''; $mensajePN = '';
        if($labelsPositivos == 'P'){
            $mensajePP = 'Positivo';
        }
        if($labelsNegativos == 'N'){
            $mensajePN = 'Negativo';
        }
        
        /* $data1 = [$mensaje,$csat_promedio];
        $data2 = [$mensaje2,$csat_promedioN]; */

        $dataP1 = [$mensajePP,$csat_porcentaje];
        $dataP2 = [$mensajePN,$csat_porcentajeN];

        $formulaP = (string) $sumapuntuaciones .' / '. $totalvaloracionesobtenidas; //positiva
        $formulaN = (string) $sumapuntuaciones2 .' / '. $totalvaloracionesobtenidas; //negativa

        $formulaPorP = (string) $numerovaloracionpositiva .' / '. $totalvaloracionesobtenidas .' * 100';
        $formulaPorN = (string) $numerovaloracionnegativa .' / '. $totalvaloracionesobtenidas .' * 100';


      /*  $response = [
            'data1' =>[
                'positivo' =>$data1,
                'formula_positiva' => $formulaP,
                'porcentaje_positivo' =>$dataP1,
                'formula_porcentaje_positiva' =>$formulaPorP,                
            ],
            'data2' =>[
                'negativo' =>$data2,
                'formula_negativa' => $formulaN,
                'porcentaje_negativo' =>$dataP2,
                'formula_porcentaje_negativa' =>$formulaPorN,                

            ], 
        ]; */ 

        /* title: {
            text: 'RPM'
        } */
        
        $response = [
            'title' => $mensaje,
            'data' => [$csat_promedio],
            'formula_positiva' => $formulaP,
            'title2' =>$mensaje2,
            'data2' => [$csat_promedioN],
            'formula_negativa' => $formulaN,
            'titlepor' => $mensajePP,
            'datapor' => [$csat_porcentaje],
            'formula_porcentaje_positiva' => $formulaPorP,
            'titlepor2' => $mensajePN,
            'datapor2' => [$csat_porcentajeN],
            'formula_porcentaje_negativa' => $formulaPorN,      
        ];

  


        echo json_encode($response); 


/* 
 */

    }
 


}