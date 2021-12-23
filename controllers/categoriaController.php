<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'models/categoriaModel.php';

class CategoriaController{

    private $cors;
  

    public function __construct()
    {
        $this->cors = new Cors();

    }

    public function listarcategoria(){
        $this->cors->corsJson();
        $response=[];
        $datacategoria = Categoria::where('estado','A')->get();
  
        if($datacategoria){
             foreach($datacategoria as $produ){
                 $produ->categoria;

             }
            $response=[
                'status'=>true,
                'mensaje'=>'existen datos',
                'categoria'=>$datacategoria
            ];
        }else{
            $response=[
                'status'=>false,
                'mensaje'=>'no existen datos',
                'categoria'=>null
            ];       
        }
        echo json_encode($response);
    }

    public function guardarcategoria(Request $request){
        $this->cors->corsJson();

        $datarequestcategoria = $request->input("categoria");
        $nombre=ucfirst($datarequestcategoria->nombre);

        if($datarequestcategoria){
            $nuevacategoria= new categoria();
            $existecategoria=Categoria::where('nombre',$nombre)->get()->first();
            if($existecategoria){
                $response=[
                    'status'=>false,
                    'mensaje'=>'La categoria ya existe',
                    'categoria'=>null,
                ];
            }else{
                $nuevacategoria->nombre=$nombre;
                $nuevacategoria->estado='A';
                
                if($nuevacategoria->save()){
                    $response=[
                        'status'=>true,
                        'mensaje'=>'La categoria se ha guardado',
                        'categoria'=>$nuevacategoria,
                    ];                
                }else{
                    $response=[
                        'status'=>false,
                        'mensaje'=>'La categoria no se puede guardar',
                        'categoria'=>null,
                    ];
                }
            }
        }else{
            $response=[
                'status'=>false,
                'mensaje'=>'no hay datos para procesar',
                'categoria'=>null
            ];
        }
        echo json_encode($response);
    }

    public function datatablecategoria(){
        $this->cors->corsJson();
        $datacategoria = Categoria::where('estado', 'A')->get();
        $data = [];   $i = 1;

        foreach ($datacategoria as $dc) {
      
            $icono = $dc->estado == 'I' ? '<i class="fa fa-check-circle fa-lg"></i>' : '<i class="fa fa-trash fa-lg"></i>';
            $clase = $dc->estado == 'I' ? 'btn-success btn-sm' : 'btn-dark btn-sm';
            $other = $dc->estado == 'A' ? 0 : 1;

            $botones = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm" onclick="editar_categoria(' . $dc->id . ')">
                                <i class="fa fa-edit fa-lg"></i>
                            </button>
                            <button class="btn ' . $clase . '" onclick="eliminar_categoria(' . $dc->id . ',' . $other . ')">
                                ' . $icono . '
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => $dc->nombre,
                2 => $botones,
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

   
}