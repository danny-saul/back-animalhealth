<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/productoModel.php';

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model{

    protected $table = "categoria";
    protected $filleable =['nombre', 'estado'];
    public $timestamps = false;

    public function producto(){
        return $this->hasMany(Producto::class);
    }

}