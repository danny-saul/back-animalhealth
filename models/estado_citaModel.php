<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/citasModel.php';



use Illuminate\Database\Eloquent\Model;


class Estado_Cita extends Model{

    protected $table = "estado_cita";
    public $timestamps = false;

    public function cita(){ 
        return $this->hasMany(Citas::class);
    }  

    



 
}
