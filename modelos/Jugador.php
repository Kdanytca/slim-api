<?php
use Illuminate\Database\Eloquent\Model;

class Jugador extends Model {
    protected $table = 'jugadores';  
    protected $primaryKey = 'id';    
    public $timestamps = false;      
}


