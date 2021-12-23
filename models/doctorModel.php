<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/personaModel.php';
require_once 'models/doctor_HorarioModel.php';
require_once 'models/citasModel.php';
require_once 'models/recetaModel.php';

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model{

    protected $table = "doctor";
    protected $filleable = ['persona_id','estado'];
    public $timestamps = false;

     //  muchos a 1 bellon to 
    public function persona(){
        return $this->belongsTo(Persona::class);
    }

    //uno a muchos
    public function doctor_horario(){
        return $this->hasMany(Doctor_Horario::class);
    }

    public function cita(){ 
        return $this->hasMany(Citas::class);
    }

    public function receta(){
        return $this->hasMany(Receta::class);
    }


}
