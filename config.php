<?php

use Illuminate\Database\Capsule\Manager as BaseDeDatos;

$bd = new BaseDeDatos;

$bd->addConnection([
    'driver'    => 'mysql',
    'host'      => 'sql.freedb.tech',
    'database'  => 'freedb_torneo_db',
    'username'  => 'freedb_ues_parcial',
    'password'  => '!hW27cPytWudkD6',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$bd->setAsGlobal();
$bd->bootEloquent();

return $bd;
