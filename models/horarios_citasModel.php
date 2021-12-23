<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/citasModel.php';


 


use Illuminate\Database\Eloquent\Model;


class Horarios_Citas extends Model{

    protected $table = "horarios_citas";
    protected $filleable = ['hora_inicio','hora_fin','status','estado'];
    public $timestamps = false;

    public function cita(){ 
        return $this->hasMany(Citas::class);
    }
   
  

 
}

