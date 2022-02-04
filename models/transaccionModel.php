<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/ventasModel.php'; 
require_once 'models/comprasModel.php';  
require_once 'models/recetaModel.php';
require_once 'models/inventarioModel.php';
 
use Illuminate\Database\Eloquent\Model;


class Transaccion extends Model{

    protected $table = "transaccion";
    protected $filleable = ['tipo_movimiento','ventas_id','compras_id','receta_id','fecha'];
    


     public function ventas(){
        return $this->belongsTo(Ventas::class);
    } 
    public function compras(){
        return $this->belongsTo(Compras::class);
    } 

    public function receta(){
        return $this->belongsTo(Receta::class);
    } 
    public function inventario(){
        return $this->hasMany(Inventario::class);
    } 

 
}

