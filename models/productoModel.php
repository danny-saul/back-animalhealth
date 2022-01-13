<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/categoriaModel.php';
require_once 'models/detalle_compraModel.php';




use Illuminate\Database\Eloquent\Model;

class Producto extends Model{

    protected $table = "producto";
    protected $filleable =['categoria_id','codigo','nombre','descripcion','imagen','stock','precio_compra','precio_venta','fecha','estado'];
    public $timestamps = false;

    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }

    public function detalle_compra(){
        return $this->hasMany(Detalle_Compra::class);
    }
    
    public function detalle_venta(){
        return $this->hasMany(Detalle_Venta::class);
    }


}