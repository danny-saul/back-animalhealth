<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/razaModel.php';
require_once 'models/genero_mascotaModel.php';
require_once 'models/tipo_mascotaModel.php';
require_once 'models/clienteModel.php';
require_once 'models/citasModel.php';


use Illuminate\Database\Eloquent\Model;


class Mascota extends Model{

    protected $table = "mascota";
    protected $filleable = ['cliente_id', 'tipo_mascota_id', 'genero_mascota_id', 'raza_id', 'nombre','edad', 'peso','fecha_nacimiento','imagen','estado'];
    public $timestamps = false;


    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function tipo_mascota(){
        return $this->belongsTo(Tipo_Mascota::class);
    }

    public function genero_mascota(){
        return $this->belongsTo(Genero_Mascota::class);
    }

    public function raza(){
        return $this->belongsTo(Raza::class);
    }

    public function citas(){
        return $this->HasMany(Citas::class);
    }

   

}

