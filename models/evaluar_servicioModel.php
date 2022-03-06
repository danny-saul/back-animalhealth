<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/clienteModel.php';
require_once 'models/detalleModel.php';


use Illuminate\Database\Eloquent\Model;


class Evaluar_Servicio extends Model{

    protected $table = "evaluar_servicio";
    protected $filleable =['cliente_id','detalle_id','valoracion','fecha','estado'];
    public $timestamps = false;

    public function cliente(){ 
        return $this->belongsTo(Cliente::class);
    }  
    public function detalle(){ 
        return $this->belongsTo(Detalle::class);
    }  

    



 
}
