<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/proveedorModel.php';
require_once 'models/usuarioModel.php';
require_once 'models/detalle_compraModel.php';



use Illuminate\Database\Eloquent\Model;

class Compras extends Model{

    protected $table = "compras";
    protected $filleable =['proveedor_id','usuario_id','numero_compra','descuento','subtotal','iva','total','fecha_compra','estado'];
    public $timestamps = false;

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }

    public function usuario(){
        return $this->belongsTo(Usuario::class);
    }

    public function detalle_compra(){
        return $this->hasMany(Detalle_Compra::class);
    }
    


}