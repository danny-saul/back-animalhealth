<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/usuarioModel.php';

use Illuminate\Database\Eloquent\Model;

class Rol extends Model{

    protected $table = "roles";
    protected $filleable = ['rol','estado'];
    public $timestamps = false;
    
    //1 a muchos hash many 
    public function usuario(){
        
        return $this->hasMany(Usuario::class);
    }  

}
