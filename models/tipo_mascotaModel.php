<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/mascotaModel.php';



use Illuminate\Database\Eloquent\Model;


class Tipo_Mascota extends Model{

    protected $table = "tipo_mascota";
    public $timestamps = false;

    public function mascota(){ 
        return $this->hasMany(Mascota::class);
    }  

    



 
}
