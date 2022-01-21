<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
/* require_once 'models/personaModel.php'; */


use Illuminate\Database\Eloquent\Model;


class Configuraciones extends Model{

    protected $table = "configuraciones";
    protected $filleable = ['porcentaje_ganancia','iva','estado'];
    public $timestamps = false;


  /*   public function persona(){
        return $this->HasMany(Persona::class);
    } */

 
}

