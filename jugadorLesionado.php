<?php

require_once "_com/dao.php";

$conexion = obtenerPdoConexionBD();

$jugadorId = $_REQUEST["id"];

$sql = "UPDATE jugador SET lesionado = (NOT (SELECT lesionado FROM jugador WHERE jugadorId=?)) WHERE jugadorId=?";
$sentencia = $conexion->prepare($sql);
$sentencia->execute([$jugadorId, $jugadorId]);

redireccionar("jugadorListado.php");
?>