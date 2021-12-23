<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/doctorModel.php';
require_once 'models/horarios_atencionModel.php';



use Illuminate\Database\Eloquent\Model;

class Doctor_Horario extends Model{

    protected $table = "doctor_horario";
    protected $filleable = ['doctor_id','horarios_atencion_id','estado'];
    public $timestamps = false;

     //  muchos a 1 bellon to 
    public function doctor(){
        return $this->belongsTo(Doctor::class);

    }
    public function horarios_atencion(){
        return $this->belongsTo(Horarios_Atencion::class);
    }
    

}


