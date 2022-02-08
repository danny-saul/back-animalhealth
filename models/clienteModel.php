<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/personaModel.php';
require_once 'models/mascotaModel.php';
require_once 'models/citasModel.php';
require_once 'models/ventasModel.php';
require_once 'models/historial_clinicoModel.php';
require_once 'models/sastifaccionModel.php';

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model{

    protected $table = "cliente";
    protected $filleable = ['persona_id','estado'];
    public $timestamps = false;

     //  muchos a 1 bellon to 
    public function persona(){
        return $this->belongsTo(Persona::class);
    }

    public function mascota(){ 
        return $this->hasMany(Mascota::class); 
    } 
    
    public function cita(){ 
        return $this->hasMany(Citas::class);
    }

    public function ventas(){ 
        return $this->hasMany(Ventas::class);
    }
    public function historial_clinico(){ 
        return $this->hasMany(Historial_Clinico::class);
    }
    public function sastifaccion(){ 
        return $this->hasMany(Sastifaccion::class);
    }


    

}
