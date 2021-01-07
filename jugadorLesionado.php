<?php

require_once "_com/_varios.php";

$conexion = obtenerPdoConexionBD();

$id = $_REQUEST["id"];

$sql = "UPDATE jugador SET lesionado = (NOT (SELECT lesionado FROM jugador WHERE id=?)) WHERE id=?";
$sentencia = $conexion->prepare($sql);
$sentencia->execute([$id, $id]);

redireccionar("jugadorListado.php");
?>