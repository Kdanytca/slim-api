<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use Psr\Http\Message\ResponseInterface as Respuesta;
use Psr\Http\Message\ServerRequestInterface as Peticion;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
$bd = require __DIR__ . '/../config.php';
require __DIR__ . '/../modelos/Equipos.php';
require __DIR__ . '/../modelos/Jugador.php';



$app = AppFactory::create();

$app->get('/hola', function (Peticion $peticion, Respuesta $respuesta) {
    $respuesta->getBody()->write("Hola mundo desde Slim");
    return $respuesta;
});

$app->post('/equipos', function (Peticion $peticion, Respuesta $respuesta) {
    $datos = $peticion->getParsedBody();
    
    $equipo = new Equipo();
    $equipo->nombreEquipo = $datos['nombreEquipo'];
    $equipo->institucion = $datos['institucion'];
    $equipo->departamento = $datos['departamento'];
    $equipo->municipio = $datos['municipio'];
    $equipo->direccion = $datos['direccion'];
    $equipo->telefono = $datos['telefono'];
    
    $equipo->save();
    
    $respuesta->getBody()->write($equipo->toJson());
    return $respuesta->withHeader('Content-Type', 'application/json');
});


$app->get('/equipos', function (Peticion $peticion, Respuesta $respuesta) use ($bd) {
    $equipos = $bd->table('equipos')->get();
    $respuesta->getBody()->write($equipos->toJson());
    return $respuesta->withHeader('Content-Type', 'application/json');
});



$app->get('/jugadores', function (Peticion $peticion, Respuesta $respuesta) use ($bd) {
    $jugadores = $bd->table('jugadores')->get();
    $respuesta->getBody()->write($jugadores->toJson());
    return $respuesta->withHeader('Content-Type', 'application/json');
});

$app->post('/jugadores', function (Peticion $peticion, Respuesta $respuesta) use ($bd) {
    $cuerpo = $peticion->getParsedBody();
    $idJugador = $bd->table('jugadores')->insertGetId([
        'nombres' => $cuerpo['nombres'],
        'apellidos' => $cuerpo['apellidos'],
        'fechaNacimiento' => $cuerpo['fechaNacimiento'],
        'genero' => $cuerpo['genero'],
        'posicion' => $cuerpo['posicion'],
        'idEquipo' => $cuerpo['idEquipo']
    ]);
    $jugador = $bd->table('jugadores')->where('idJugador', $idJugador)->first();
    $respuesta->getBody()->write(json_encode($jugador));
    return $respuesta->withHeader('Content-Type', 'application/json');
});


//actualizar y eliminar 
$app->put('/equipos/{id}', function (Peticion $peticion, Respuesta $respuesta, array $args) use ($bd) {
    $id = $args['id'];
    $datos = $peticion->getParsedBody();

    $actualizado = $bd->table('equipos')
        ->where('idEquipo', $id)
        ->update($datos);

    if ($actualizado) {
        $respuesta->getBody()->write(json_encode(['mensaje' => 'Equipo actualizado']));
    } else {
        $respuesta->getBody()->write(json_encode(['mensaje' => 'No se pudo actualizar o no hubo cambios']));
    }

    return $respuesta->withHeader('Content-Type', 'application/json');
});

$app->delete('/equipos/{id}', function (Peticion $peticion, Respuesta $respuesta, array $args) use ($bd) {
    $id = $args['id'];

    $eliminado = $bd->table('equipos')
        ->where('idEquipo', $id)
        ->delete();

    if ($eliminado) {
        $respuesta->getBody()->write(json_encode(['mensaje' => 'Equipo eliminado']));
    } else {
        $respuesta->getBody()->write(json_encode(['mensaje' => 'No se encontró equipo o ya fue eliminado']));
    }

    return $respuesta->withHeader('Content-Type', 'application/json');
});

$app->put('/jugadores/{id}', function (Peticion $peticion, Respuesta $respuesta, array $args) use ($bd) {
    $id = $args['id'];
    $datos = $peticion->getParsedBody();

    $actualizado = $bd->table('jugadores')
        ->where('idJugador', $id)
        ->update($datos);

    if ($actualizado) {
        $respuesta->getBody()->write(json_encode(['mensaje' => 'Jugador actualizado']));
    } else {
        $respuesta->getBody()->write(json_encode(['mensaje' => 'No se pudo actualizar o no hubo cambios']));
    }

    return $respuesta->withHeader('Content-Type', 'application/json');
});

$app->delete('/jugadores/{id}', function (Peticion $peticion, Respuesta $respuesta, array $args) use ($bd) {
    $id = $args['id'];

    $eliminado = $bd->table('jugadores')
        ->where('idJugador', $id)
        ->delete();

    if ($eliminado) {
        $respuesta->getBody()->write(json_encode(['mensaje' => 'Jugador eliminado']));
    } else {
        $respuesta->getBody()->write(json_encode(['mensaje' => 'No se encontró jugador o ya fue eliminado']));
    }

    return $respuesta->withHeader('Content-Type', 'application/json');
});

function buscarJugadorPorId($id) {
    return \Illuminate\Database\Capsule\Manager::table('jugadores')->where('idJugador', $id)->first();
}
$app->get('/jugadores/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $jugador = buscarJugadorPorId($id);
    if (!$jugador) {
        $response->getBody()->write('Jugador no encontrado');
        return $response->withStatus(404);
    }
    $response->getBody()->write(json_encode($jugador));
    return $response->withHeader('Content-Type', 'application/json');
});

function buscarEquipoPorId($id) {
    return \Illuminate\Database\Capsule\Manager::table('equipos')->where('idEquipo', $id)->first();
}

$app->get('/equipos/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $equipo = buscarEquipoPorId($id);
    if (!$equipo) {
        $response->getBody()->write('Equipo no encontrado');
        return $response->withStatus(404);
    }
    $response->getBody()->write(json_encode($equipo));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();

