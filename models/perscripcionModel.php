<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/historial_clinicoModel.php';


use Illuminate\Database\Eloquent\Model;


class Perscripcion extends Model{

    protected $table = "perscripcion";
    protected $filleable = ['historial_clinico_id','descripcion','estado'];
    public $timestamps = false;

    
    public function historial_clinico(){ 
        return $this->belongsTo(Historial_Clinico::class);
    }  
    


  
    

}
