<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/historial_clinicoModel.php';



use Illuminate\Database\Eloquent\Model;


class Antecedentes extends Model{

    protected $table = "antecedentes";
    protected $filleable = ['historial_clinico_id','cirugias','descripcion','fecha_cirugia','estado'];
    public $timestamps = false;

    public function historial_clinico(){ 
        return $this->belongsTo(Historial_Clinico::class);
    }  
    

  
    

}
