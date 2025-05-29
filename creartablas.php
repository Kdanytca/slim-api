<?php

require 'vendor/autoload.php';
require 'config.php';

use Illuminate\Database\Capsule\Manager as DB;


if (!DB::schema()->hasTable('equipos')) {
    DB::schema()->create('equipos', function ($table) {
        $table->increments('idEquipo');
        $table->string('nombreEquipo', 50);
        $table->string('institucion', 50);
        $table->string('departamento', 50);
        $table->string('municipio', 30);
        $table->text('direccion');
        $table->string('telefono', 8);
    });

    echo "Tabla 'equipos' creada correctamente.<br>";
} else {
    echo "La tabla 'equipos' ya existe.<br>";
}


if (!DB::schema()->hasTable('jugadores')) {
    DB::schema()->create('jugadores', function ($table) {
        $table->increments('idJugador');
        $table->string('nombres', 30);
        $table->string('apellidos', 30);
        $table->date('fechaNacimiento');
        $table->char('genero', 1);
        $table->string('posicion', 30);
        $table->unsignedInteger('idEquipo');
        $table->foreign('idEquipo')->references('idEquipo')->on('equipos');
    });

    echo " Tabla 'jugadores' creada correctamente.<br>";
} else {
    echo " La tabla 'jugadores' ya existe.<br>";
}
