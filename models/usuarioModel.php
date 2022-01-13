<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/rolModel.php';
require_once 'models/personaModel.php';
require_once 'models/comprasModel.php';
require_once 'models/ventasModel.php';



use Illuminate\Database\Eloquent\Model;

class Usuario extends Model{

    protected $table = "usuario";
    protected $filleable = ['persona_id', 'roles_id', 'usuario', 'correo', 'password', 'password2','imagen','estado'];
    public $timestamps = false;

     //  muchos a 1 bellon to 
     public function roles(){
        return $this->belongsTo(Rol::class);
    }
    
    public function persona(){
        return $this->belongsTo(Persona::class); 
    }

    public function compras(){
        return $this->hasMany(Compras::class);
    }

    public function ventas(){
        return $this->hasMany(Ventas::class);
    }


}