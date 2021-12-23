<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/usuarioModel.php';
require_once 'models/sexoModel.php';
require_once 'models/doctorModel.php';
require_once 'models/clienteModel.php';


use Illuminate\Database\Eloquent\Model;


class Persona extends Model{

    protected $table = "persona";
    protected $filleable = ['cedula', 'nombre', 'apellido', 'telefono', 'direccion', 'sexo_id', 'estado'];
    public $timestamps = false;


    public function usuario(){
        return $this->HasMany(Usuario::class);
    }

    public function sexo(){
        return $this->belongsTo(Sexo::class);
    }

    public function doctor(){
        return $this->HasMany(Doctor::class);
    }

    public function cliente(){
        return $this->HasMany(Cliente::class);
    }

}




