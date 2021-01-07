<?php
require_once "_com/_varios.php";

$conexionBD = obtenerPdoConexionBD();

$id = (int)$_REQUEST["id"];

$sql = "DELETE FROM categoria WHERE id=?";


$sentencia = $conexionBD->prepare($sql);

$sqlConExito = $sentencia->execute([$id]);

$correctoNormal = ($sqlConExito && $sentencia->rowCount() == 1);

$noExistia = ($sqlConExito && $sentencia->rowCount() == 0);

// INTERFAZ: $sqlConExito $correctoNormal $noExistia
?>


