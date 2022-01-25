<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/mascotaModel.php';
require_once 'models/clienteModel.php';
require_once 'models/examen_fisicoModel.php';
require_once 'models/antecedentesModel.php';
require_once 'models/perscripcionModel.php';

use Illuminate\Database\Eloquent\Model;


class Historial_Clinico extends Model{

    protected $table = "historial_clinico";
    protected $filleable = ['cliente_id','mascota_id','numero_historia','motivo_consulta','fecha_h','estado'];
    public $timestamps = false;

    public function mascota(){ 
        return $this->belongsTo(Mascota::class);
    }  
    public function cliente(){ 
        return $this->belongsTo(Cliente::class);
    }  
    public function examen_fisico(){ 
        return $this->hasMany(Examen_Fisico::class);
    }  
    public function antecendentes(){ 
        return $this->hasMany(Antecedentes::class);
    }  
    public function perscripcion(){ 
        return $this->hasMany(Perscripcion::class);
    }  

}
