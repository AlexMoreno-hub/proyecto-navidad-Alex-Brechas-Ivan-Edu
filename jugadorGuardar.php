<?php

require_once "_com/dao.php";
require_once "_com/_varios.php";

$jugadorId= (int)$_REQUEST["id"];
// Se recoge el parámetro "id" de la request.
$nombre = $_REQUEST["nombre"];
$apellidos = $_REQUEST["apellidos"];
$dorsal = $_REQUEST["dorsal"];
$categoriaId = (int)$_REQUEST["categoriaId"];
$equipoId=(int)$_REQUEST["equipoId"];
$lesionado = isset($_REQUEST["lesionado"]);

$nuevaEntrada = ($jugadorId == -1);
$resultado=false;
$datosNoModificados=false;

if ($nuevaEntrada){

    $resultado=dao::jugadorCrear($nombre,$apellidos,$dorsal,$lesionado,$categoriaId,$equipoId);
    redireccionar("jugadorListado.php");

}
else {
    $datosNoModificados = DAO::jugadorModificar($nombre,$apellidos,$dorsal,$lesionado,$categoriaId,$equipoId,$jugadorId);
    redireccionar("jugadorListado.php");
    }

?>