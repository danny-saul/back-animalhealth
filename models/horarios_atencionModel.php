<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/doctor_HorarioModel.php';
require_once 'models/citasModel.php';


use Illuminate\Database\Eloquent\Model;

class Horarios_Atencion extends Model{

    protected $table = "horarios_atencion";
    protected $filleable = ['horaE','horaS','fecha','intervalo','horario','libre','asignacion','estado'];
    public $timestamps = false;

     //  muchos a 1 bellon to 
    public function doctor_horario(){
        return $this->hasMany(Doctor_Horario::class);


    }

    public function cita(){ 
        return $this->hasMany(Citas::class);
    }

}
