<?php
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model {
    protected $table = 'equipos';
    protected $primaryKey = 'idEquipo';
    public $timestamps = false;
    protected $fillable = [
        'nombreEquipo',
        'institucion',
        'departamento',
        'municipio',
        'direccion',
        'telefono'
    ];
}
