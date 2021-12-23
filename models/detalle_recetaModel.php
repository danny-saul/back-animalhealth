<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/recetaModel.php';
require_once 'models/productoModel.php'; 



use Illuminate\Database\Eloquent\Model;

class Detalle_Receta extends Model{

    protected $table = "detalle_receta";
    protected $filleable =['receta_id', 'producto_id', 'cantidad', 'total'];
    public $timestamps = false;

    public function receta(){
        return $this->belongsTo(Receta::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }


}