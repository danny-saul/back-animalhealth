<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/comprasModel.php';
 

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model{

    protected $table = "proveedor";
    protected $filleable =['ruc','razon_social','telefono','correo','direccion', 'estado'];
    public $timestamps = false;

    public function compras(){
        return $this->hasMany(Compras::class);
    }

}