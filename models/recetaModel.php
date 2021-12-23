<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/citasModel.php';
require_once 'models/doctorModel.php'; 
require_once 'models/detalle_recetaModel.php'; 



use Illuminate\Database\Eloquent\Model;

class Receta extends Model{

    protected $table = "receta";
    protected $filleable =['cita_id', 'doctor_id', 'pagado', 'fecha', 'total', 'descripcion', 'estado'];
    public $timestamps = false;

    public function citas(){
        return $this->belongsTo(Citas::class);
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function detallereceta(){
        return $this->hasMany(Detalle_Receta::class);
    }


}