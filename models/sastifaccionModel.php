<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/clienteModel.php';
require_once 'models/detalleModel.php';


use Illuminate\Database\Eloquent\Model;


class Sastifaccion extends Model{

    protected $table = "sastifaccion";
    protected $filleable =['cliente_id','detalle_id','valoracion','fecha','estado'];
    public $timestamps = false;

    public function cliente(){ 
        return $this->belongsTo(Cliente::class);
    }  
    public function detalle(){ 
        return $this->belongsTo(Detalle::class);
    }  

    



 
}
