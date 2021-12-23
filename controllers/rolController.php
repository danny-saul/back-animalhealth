<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/rolModel.php';

class RolController{

    private $cors;
  

    public function __construct()
    {
        $this->cors = new Cors();

       
    }

    public function guardar(Request $request){
        $this->cors->corsJson();
        $datarolrequest= $request->input('rol');
        $rol = $datarolrequest->rol;
         /* var_dump($datarolrequest);  */
         $response=[];
         if ($datarolrequest){
             $nuevoRol = new Rol();

             $existeRol = Rol::where('rol',$rol)->get()->first();
             if( $existeRol ){

                $response = [
                    'status' => false, 
                    'message' => 'El rol ya existe',
                    'rol'=> []
                ];
             }else{
                $nuevoRol->rol=$rol;
                $nuevoRol->estado='A';
                $nuevoRol->save();
                $response = [
                   'status' => true, 
                   'message' => 'Se ha guardado el rol',
                   'rol'=> $nuevoRol,
               ];
             }
         }else{
             $response = [
                 'status' => false, 
                 'message' => 'no hay datos para procesar' 
             ];
         }

         echo json_encode($response);

    }


    public function getRoles(){
        $this->cors->corsJson();
        $response=[];
        $dataRol = Rol::where('estado','A')->get();
        if($dataRol){
            $response=[
                'status' => true, 
                'message' => 'existen datos', 
                'rol'=>$dataRol
            ];

        }else{
            $response=[
                'status' => false, 
                'message' => 'no existen datos', 
                'rol'=>null
            ];

        }
        echo json_encode($response);

    }


    public function listarID($params){
        $this->cors->corsJson();
        $id=intval($params['id']);

        $response= [];
        $dataRol = Rol::find($id);
        if($dataRol){
            $response = [
                'status' => true, 
                'message' => 'existen datos', 
                'rol'=>$dataRol,
            ];
        }else{
            $response = [
                'status' => false, 
                'message' => 'no existen datos', 
                'rol'=>null,
            ];

        }
        echo json_encode($response); 



    }

       //select cliente
       public function getRolesClientes(){
        $this->cors->corsJson();
        $response = [];
        $rolCliente = Rol::where('id',5)->get()->first();

        if($rolCliente){
            $response = [
                'status' => true,
                'mensaje' => 'Existen Datos',
                'rol_cliente' => $rolCliente 
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No Existen Datos',
                'rol_cliente' => null
            ];
        }
        echo json_encode($response);
    }

}