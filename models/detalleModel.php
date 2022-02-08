<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/sastifaccionModel.php';
 


use Illuminate\Database\Eloquent\Model;


class Detalle extends Model{

    protected $table = "detalle";
    public $timestamps = false;


    public function sastifaccion(){ 
        return $this->hasMany(Sastifaccion::class);
    }

}