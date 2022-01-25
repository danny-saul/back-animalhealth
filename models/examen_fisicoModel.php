<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/mascotaModel.php';
require_once 'models/historial_clinicoModel.php';



use Illuminate\Database\Eloquent\Model;


class Examen_Fisico extends Model{

    protected $table = "examen_fisico";
    protected $filleable = ['historial_clinico_id','temperatura','peso','hidratacion','frecuencia_cardiaca','pulso','frecuencia_respiratoria','diagnostico','tratamiento','estado'];
    public $timestamps = false;


    public function historial_clinico(){ 
        return $this->belongsTo(Historial_Clinico::class);
    }  
    

}
