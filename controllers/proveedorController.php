<?php

use Illuminate\Support\Facades\Response;

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/proveedorModel.php';

class ProveedorController{

    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();

    }


    public function guardar(Request $request){
        $this->cors->corsJson();

        $datarequestproveedor = $request->input("proveedor");
        $ruc =$datarequestproveedor->ruc;
        
        if($datarequestproveedor){
            $existeruc=Proveedor::where('ruc',$ruc)->get()->first();
            if($existeruc){
                $response=[
                    'status'=>false,
                    'mensaje'=>'El ruc del proveedor ya existe',
                    'proveedor'=>null,
                ];
            }else{
                $nuevoproveedor= new Proveedor();

                $nuevoproveedor->ruc=$ruc;
                $nuevoproveedor->razon_social=ucfirst($datarequestproveedor->razon_social);
                $nuevoproveedor->telefono=$datarequestproveedor->telefono;
                $nuevoproveedor->correo=$datarequestproveedor->correo;
                $nuevoproveedor->direccion=$datarequestproveedor->direccion;
                $nuevoproveedor->estado='A';
                
                if($nuevoproveedor->save()){
                    $response=[
                        'status'=>true,
                        'mensaje'=>'El proveedor se ha guardado',
                        'proveedor'=>$nuevoproveedor,
                    ];                
                }else{
                    $response=[
                        'status'=>false,
                        'mensaje'=>'El proveedor no se puede guardar',
                        'proveedor'=>null,
                    ];
                }
            }
        }else{
            $response=[
                'status'=>false,
                'mensaje'=>'no hay datos para procesar',
                'proveedor'=>null
            ];
        }
        echo json_encode($response);
    }

    public function datatable(){
        $this->cors->corsJson();
        $dataproveedor = Proveedor::where('estado', 'A')->get();
        $data = [];   $i = 1;

        foreach ($dataproveedor as $dc) {
      
            $icono = $dc->estado == 'I' ? '<i class="fa fa-check-circle fa-lg"></i>' : '<i class="fa fa-trash fa-lg"></i>';
            $clase = $dc->estado == 'I' ? 'btn-success btn-sm' : 'btn-dark btn-sm';
            $other = $dc->estado == 'A' ? 0 : 1;

            $botones = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm" onclick="editar_proveedor(' . $dc->id . ')">
                                <i class="fa fa-edit fa-lg"></i>
                            </button>
                            <button class="btn ' . $clase . '" onclick="eliminar_proveedor(' . $dc->id . ',' . $other . ')">
                                ' . $icono . '
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => $dc->ruc,
                2 => $dc->razon_social,
                3 => $dc->telefono,
                4 => $dc->correo,
                5 => $dc->direccion,
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

    public function eliminar(Request $request){
        $this->cors->corsJson();
        $proveedorrequest = $request->input('proveedor');
        $idproveedor = intval($proveedorrequest->id);
      
        $proveedordata = Proveedor::find($idproveedor);
        $response = [];
        if($proveedorrequest){
            if($proveedordata){
                $proveedordata->estado = 'I';
                $proveedordata->save();
                
                $response = [
                    'status' => true,
                    'mensaje' => "Se ha eliminado el Proveedor",
                ];        
            }else{
                $response = [
                    'status' => false,
                    'mensaje' => "No Se ha eliminado el Proveedor",
                ];               
            }
        }else{
            $response = [
                'status' => false,
                'memsaje' => 'no hay datos para procesar',
                'proveedor' => null
            ];
        }
        echo json_encode($response);


    }

    public function getProveedorid($params){
        $this->cors->corsJson();
        $id = intval($params['id']);
        $response = [];
        $proveedor = Proveedor::find($id);

        if($proveedor){
 
            $response = [
                'status' => true,
                'mensaje' => 'hay datos',
                'proveedor' => $proveedor
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'no ahi datos',
                'proveedor' => null
            ];
        }
        echo json_encode($response);

    }

    public function editar(Request $request)
    {
        $this->cors->corsJson();
        $proveedorrequest = $request->input('proveedor');
        $idproveedor = intval($proveedorrequest->id);
 
        $proveedordata = Proveedor::find($idproveedor);
        $response = [];

        if ($proveedorrequest) {
            if ($proveedordata) {

                $proveedordata->ruc = $proveedorrequest->ruc;
                $proveedordata->razon_social =ucfirst($proveedorrequest->razon_social);
                $proveedordata->telefono = $proveedorrequest->telefono;
                $proveedordata->correo = $proveedorrequest->correo;
                $proveedordata->direccion = $proveedorrequest->direccion;

                $proveedordata->save();

                $response = [
                    'status' => true,
                    'mensaje' => 'Se ha actualizado el Proveedor',
                ];
            }else{
                $response = [
                    'status' => false,
                    'mensaje' => 'No se ha actualizado el Proveedor',
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

    public function listarproveedor(){
        $this->cors->corsJson();
        $response=[];
        $dataproveedor = Proveedor::where('estado','A')->get();

        if($dataproveedor){
            $response=[
                'status'=>true,
                'mensaje'=>'Si hay datos',
                'proveedor'=>$dataproveedor
            ];

        }else{
            $response=[
                'status'=>false,
                'mensaje'=>'No hay datos',
                'proveedor'=>null
            ];
        }
        echo json_encode($response);


    }  
    
    public function cantidad(){
        $this->cors->corsJson();
        $dataproveedor= Proveedor::where('estado','A')->get();
        $response = [];

        if($dataproveedor){
            $response =[
                'status'=>true,
                'mensaje'=>'existe datos',
                'modelo'=>'Proveedor',
                'cantidad'=>$dataproveedor->count(),
            ];
        }else{
           $response =[
               'status'=>false,
               'mensaje'=>'no existe datos',
               'modelo'=>'Proveedor',
               'cantidad'=>0,
           ];

        }
        echo json_encode($response);
    }

    public function Buscarproveedor($params){
        $this->cors->corsJson();
        $texto= strtolower($params['texto']);
        $dataproveedor = Proveedor::where('razon_social','like','%'. $texto .'%' )->where('estado','A')->get();
        $response=[];
        if($texto == ""){
            $response=[
                'status'=>true,
                'mensaje'=>'todos los registros',
                'proveedor'=> $dataproveedor,
            ];
        }else{
            if(count($dataproveedor)>0){
                $response=[
                    'status' => true,
                    'mensaje'=>'coincidencias encontradas',
                    'proveedor'=> $dataproveedor,
                ];
                
            }else{
                $response=[
                    'status' => false,
                    'mensaje'=>'no hay registros',
                    'raza'=> null,
                ];
            }
        }
        echo json_encode($response);
    }

}