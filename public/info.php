<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config.php';

use Illuminate\Database\Capsule\Manager as DB;

try {
    $usuarios = DB::table('usuarios')->get();

    foreach ($usuarios as $usuario) {
        echo $usuario->nombre . "<br>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
