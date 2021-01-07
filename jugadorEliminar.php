
<?php
require_once "_com/_varios.php";

$conexion = obtenerPdoConexionBD();


$id = (int)$_REQUEST["id"];

$sql = "DELETE FROM jugador WHERE id=?";

$sentencia = $conexion->prepare($sql);
//Esta llamada devuelve true o false según si la ejecución de la sentencia ha ido bien o mal.
$sqlConExito = $sentencia->execute([$id]);

//Se consulta la cantidad de filas afectadas por la ultima sentencia sql.
$unaFilaAfectada = ($sentencia->rowCount() == 1);
$ningunaFilaAfectada = ($sentencia->rowCount() == 0);


$correcto = ($sqlConExito && $unaFilaAfectada);


$noExistia = ($sqlConExito && $ningunaFilaAfectada);
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php if ($correcto) { ?>

    <h1>Eliminación completada</h1>
    <p>Se ha eliminado correctamente el jugador.</p>

<?php } else if ($noExistia) { ?>

    <h1>Eliminación imposible</h1>
    <p>No existe este jugador</p>

<?php } else { ?>

    <h1>Error en la eliminación</h1>
    <p>No se ha podido eliminar al jugador.</p>

<?php } ?>

<a href='jugadorListado.php'>Volver al listado de jugadores.</a>

</body>

</html>