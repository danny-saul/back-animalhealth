<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/comprasModel.php';
require_once 'models/productoModel.php';



use Illuminate\Database\Eloquent\Model;

class Detalle_Compra extends Model{

    protected $table = "detalle_compra";
    protected $filleable =['compras_id','producto_id','cantidad','precio_compra','total'];
    public $timestamps = false;

    public function compras(){
        return $this->belongsTo(Compras::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }
    


}