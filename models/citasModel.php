<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/doctorModel.php';
require_once 'models/serviciosModel.php';
require_once 'models/clienteModel.php';
require_once 'models/estado_citaModel.php';
require_once 'models/horarios_citasModel.php';
require_once 'models/mascotaModel.php';
require_once 'models/recetaModel.php';




use Illuminate\Database\Eloquent\Model;

class Citas extends Model{

    protected $table = "citas";
    protected $filleable = ['doctor_id','servicios_id','mascota_id','cliente_id','estado_cita_id','horarios_citas_id','fecha','estado'];
    public $timestamps = false;
 
     //  muchos a 1 bellon to 
    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function servicios(){ 
        return $this->belongsTo(Servicios::class); 
    } 
    
    public function cliente(){ 
        return $this->belongsTo(Cliente::class); 
    }

    public function estado_cita(){ 
        return $this->belongsTo(Estado_Cita::class); 
    }

    public function horarios_citas(){ 
        return $this->belongsTo(Horarios_Citas::class); 
    }

    public function mascota(){ 
        return $this->belongsTo(Mascota::class); 
    }

    public function receta(){
        return $this->hasMany(Receta::class,'cita_id','id');
    }

    

}
