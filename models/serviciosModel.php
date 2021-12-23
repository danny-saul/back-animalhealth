<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/citasModel.php';
 


use Illuminate\Database\Eloquent\Model;


class Servicios extends Model{

    protected $table = "servicios";
    protected $filleable = ['nombre_servicio','precio','estado'];
    public $timestamps = false;

    public function cita(){ 
        return $this->hasMany(Citas::class);
    }
  

 
}

