<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';


use Illuminate\Database\Eloquent\Model;

class Codigos extends Model{

    protected $table = "codigos";
    protected $filleable =['codigo','tipos','estado'];
    public $timestamps = false;

    

}