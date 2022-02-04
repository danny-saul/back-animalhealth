<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/productoModel.php'; 
require_once 'models/transaccionModel.php'; 


use Illuminate\Database\Eloquent\Model;


class Inventario extends Model{

    protected $table = "inventario";
    protected $filleable = ['producto_id','transaccion_id','tipo','cantidad','cantidad_disponible','total','total_disponible'];
    


     public function producto(){
        return $this->belongsTo(Producto::class);
    } 
    public function transaccion(){
        return $this->belongsTo(Transaccion::class);
    } 

 
}

