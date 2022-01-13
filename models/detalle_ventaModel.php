<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/ventasModel.php';
require_once 'models/productoModel.php'; 



use Illuminate\Database\Eloquent\Model;

class Detalle_Venta extends Model{

    protected $table = "detalle_venta";
    protected $filleable =['ventas_id', 'producto_id', 'cantidad', 'precio_venta', 'total'];
    public $timestamps = false;

    public function ventas(){
        return $this->belongsTo(Ventas::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }


}