<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/error.php';
require_once 'app/helper.php';
require_once 'models/productoModel.php';

class ProductoController
{

    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();

    }

    public function listarproductoId($params){
        $this->cors->corsJson();
        $id = intval($params['id']);
        $response = [];
        $producto = Producto::find($id);

        if($producto){
            $producto->categoria;
            $response = [
                'status' => true,
                'mensaje' => 'hay datos',
                'producto' => $producto
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'no ahi datos',
                'producto' => null
            ];
        }
        echo json_encode($response);

    }

    public function listarproducto()
    {
        $this->cors->corsJson();
        $response = [];
        $dataproducto = Producto::where('estado', 'A')->get();

        if ($dataproducto) {
            foreach ($dataproducto as $produ) {
                $produ->categoria;

            }
            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'producto' => $dataproducto,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no existen datos',
                'producto' => null,
            ];
        }
        echo json_encode($response);
    }

    public function guardarproducto(Request $request)
    {
        $this->cors->corsJson();
        $datarequestproducto = $request->input('producto');
        $response = [];
        if ($datarequestproducto) {
            $codigo = $datarequestproducto->codigo;
            $categoriaid = $datarequestproducto->categoria_id;
            $nombre = $datarequestproducto->nombre;
            $descripcion = $datarequestproducto->descripcion;
            $imagen = $datarequestproducto->imagen;
            $precioventa = $datarequestproducto->precio_venta;
            $fecha = $datarequestproducto->fecha;

            $existecodigo = Producto::where('codigo', $codigo)->get()->first();
            if ($existecodigo) {
                $response = [
                    'status' => false,
                    'mensaje' => 'El codigo ya existe',
                    'producto' => null,
                ];
            } else {

                $nuevoproducto = new Producto();
                $nuevoproducto->categoria_id = $categoriaid;
                $nuevoproducto->codigo = $codigo;
                $nuevoproducto->nombre = $nombre;
                $nuevoproducto->descripcion = $descripcion;
                $nuevoproducto->imagen = $imagen;
                $nuevoproducto->stock = 0;
                $nuevoproducto->precio_compra = 0.00;
                $nuevoproducto->precio_venta = $precioventa;
                $nuevoproducto->fecha = $fecha;
                $nuevoproducto->estado = 'A';

                if ($nuevoproducto->save()) {
                    $response = [
                        'status' => true,
                        'mensaje' => 'El producto se ha guardado',
                        'producto' => $nuevoproducto,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'El producto no se ha guardado',
                        'producto' => null,

                    ];

                }

            }

        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'producto' => null,
            ];
        }
        echo json_encode($response);

    }

    public function subirFichero($file)
    {
        $this->cors->corsJson();
        $img = $file['fichero'];
        $path = 'fotos/productos/';

        $response = Helper::save_file($img, $path);
        echo json_encode($response);
    }

    public function datatableproducto()
    {
        $this->cors->corsJson();
        $productos = Producto::where('estado', 'A')->orderBy('codigo')->get();

        $data = [];
        $i = 1;
        foreach ($productos as $p) {

            $url = BASE . 'fotos/productos/' . $p->imagen;
            $icono = $p->estado == 'I' ? '<i class="fa fa-check-circle fa-lg"></i>' : '<i class="fa fa-trash fa-lg"></i>';
            $clase = $p->estado == 'I' ? 'btn-success btn-sm' : 'btn-dark btn-sm';
            $other = $p->estado == 'A' ? 0 : 1;

            $botones = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm" onclick="editar_producto(' . $p->id . ')">
                                <i class="fa fa-edit fa-lg"></i>
                            </button>
                            <button class="btn ' . $clase . '" onclick="eliminar_producto(' . $p->id . ',' . $other . ')">
                                ' . $icono . '
                            </button>
                        </div>';

            $color = "";
            if ($p->stock < 5) {
                $color = '<span class="badge bg-danger" style="font-size: 1.2rem;">' . $p->stock . '</span>';
            } else
            if ($p->stock >= 6 && $p->stock < 30) {
                $color = '<span class="badge bg-warning" style="font-size: 1.2rem;">' . $p->stock . '</span>';
            } else {
                $color = '<span class="badge bg-success" style="font-size: 1.2rem;">' . $p->stock . '</span>';
            }

            $data[] = [
                0 => $i,

                1 => '<div class="box-img-producto"><img src=' . "$url" . '></div>',
                2 => $p->codigo,
                3 => $p->nombre,
                4 => $p->descripcion,
                5 => $p->categoria->nombre,
                6 => $color,
                7 => number_format($p->precio_compra, 2, '.', ''),
                8 => number_format($p->precio_venta, 2, '.', ''),
                9 => $p->fecha,
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

    public function editarProducto(Request $request)
    {
        $this->cors->corsJson();
        $productorequest = $request->input('producto');
        $idproducto = intval($productorequest->id);
        $categoria_id = intval($productorequest->categoria_id);
      
        $productodata = Producto::find($idproducto);
        $response = [];

        if ($productorequest) {
            if ($productodata) {
                $productodata->categoria_id = $categoria_id;
                $productodata->nombre = ucfirst($productorequest->nombre);
                $productodata->descripcion = $productorequest->descripcion;
                $productodata->precio_venta = $productorequest->precio_venta;

                $categoria = Categoria::find($productodata->categoria_id);
                $categoria->save();
                $productodata->save();

                $response = [
                    'status' => true,
                    'mensaje' => 'Se ha actualizado el Producto',
                ];
            }else{
                $response = [
                    'status' => false,
                    'mensaje' => 'No se ha actualizado el Producto',
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

    public function eliminarproducto(Request $request)
    {
        $this->cors->corsJson();
        $productorequest = $request->input('producto');
        $idproducto = intval($productorequest->id);
      
        $productodata = Producto::find($idproducto);
        $response = [];
        if($productorequest){
            if($productodata){
                $productodata->estado = 'I';
                $productodata->save();
                
                $response = [
                    'status' => true,
                    'mensaje' => "Se ha eliminado producto",
                ];        
            }else{
                $response = [
                    'status' => false,
                    'mensaje' => "No Se ha eliminado producto",
                ];               
            }
        }else{
            $response = [
                'status' => false,
                'memsaje' => 'no hay datos para procesar',
                'producto' => null
            ];
        }
        echo json_encode($response);

    }

}
