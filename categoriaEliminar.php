<?php
require_once "_varios.php";

$conexionBD = obtenerPdoConexionBD();

$id = (int)$_REQUEST["id"];

$sql = "DELETE FROM categoria WHERE id=?";


$sentencia = $conexionBD->prepare($sql);

$sqlConExito = $sentencia->execute([$id]);

$correctoNormal = ($sqlConExito && $sentencia->rowCount() == 1);

$noExistia = ($sqlConExito && $sentencia->rowCount() == 0);

// INTERFAZ: $sqlConExito $correctoNormal $noExistia
?>


<html>

<head>
    <meta charset='UTF-8'>
</head>

<body>

<?php if ($correctoNormal) { ?>

    <h1>Eliminación completada</h1>
    <p>Se ha eliminado correctamente la categoría.</p>

<?php } else if ($noExistia) { ?>

    <h1>Eliminación no realizada</h1>
    <p>No existe la categoría.</p>

<?php } else { ?>

    <h1>Error en la eliminación</h1>
    <p>No se ha podido eliminar la categoría.</p>

<?php } ?>

<a href='categoriaListado.php'>Volver al listado de posiciones.</a>

</body>

</html>
