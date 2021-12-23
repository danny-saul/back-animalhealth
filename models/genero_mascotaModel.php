<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/mascotaModel.php';



use Illuminate\Database\Eloquent\Model;


class Genero_Mascota extends Model{

    protected $table = "genero_mascota";
    public $timestamps = false;

    public function mascota(){ 
        return $this->hasMany(Mascota::class);
    }  

    



 
}
