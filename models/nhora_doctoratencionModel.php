<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
/* require_once 'models/personaModel.php'; */


use Illuminate\Database\Eloquent\Model;


class Nhora_Doctoratencion extends Model{

    protected $table = "nhora_doctor_atencion";
    protected $filleable = ['horaE','horaS','estado'];
    public $timestamps = false;


  /*   public function persona(){
        return $this->HasMany(Persona::class);
    } */

 
}

