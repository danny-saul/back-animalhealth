<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/clienteModel.php';
require_once 'models/usuarioModel.php';
require_once 'models/detalle_ventaModel.php';



use Illuminate\Database\Eloquent\Model;

class Ventas extends Model{

    protected $table = "ventas";
    protected $filleable =['cliente_id','usuario_id','descuento','subtotal','iva','total','fecha_venta','estado','numero_venta'];
    public $timestamps = false;

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function usuario(){
        return $this->belongsTo(Usuario::class);
    }

    public function detalle_venta(){
        return $this->hasMany(Detalle_Venta::class);
    }
    


}