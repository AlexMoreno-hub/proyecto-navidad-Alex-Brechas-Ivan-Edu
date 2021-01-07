<?php
require_once "_varios.php";

$conexion = obtenerPdoConexionBD();

// Se recogen los datos del formulario de la request.
$id = (int)$_REQUEST["id"];
$nombre = $_REQUEST["nombre"];
$apellidos = $_REQUEST["apellidos"];
$dorsal = $_REQUEST["dorsal"];
$categoriaId = (int)$_REQUEST["categoriaId"];
$lesionado = isset($_REQUEST["lesionado"]);



$nuevaEntrada = ($id == -1);

if ($nuevaEntrada) {
    // Quieren CREAR una nueva entrada, así que es un INSERT.
    $sql = "INSERT INTO jugador (nombre, apellidos, dorsal, lesionado,categoriaId) VALUES (?, ?, ?, ?,?)";
    $parametros = [$nombre, $apellidos, $dorsal, $lesionado?1:0, $categoriaId];
} else {
    // Quieren MODIFICAR una persona existente y es un UPDATE.
    $sql = "UPDATE jugador SET nombre=?, apellidos=?, dorsal=?, lesionado=?, categoriaId=? WHERE id=?";
    $parametros = [$nombre, $apellidos, $dorsal,$lesionado?1:0 , $categoriaId, $id];
}

$sentencia = $conexion->prepare($sql);

$sqlConExito = $sentencia->execute($parametros);

$numFilasAfectadas = $sentencia->rowCount();
$unaFilaAfectada = ($numFilasAfectadas == 1);
$ningunaFilaAfectada = ($numFilasAfectadas == 0);


$correcto = ($sqlConExito && $unaFilaAfectada);


$datosNoModificados = ($sqlConExito && $ningunaFilaAfectada);
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php

if ($correcto || $datosNoModificados) { ?>

    <?php if ($id == -1) { ?>
        <h1>Inserción completada</h1>
        <p>Se ha insertado correctamente la nueva entrada de <?php echo $nombre; ?>.</p>
    <?php } else { ?>
        <h1>Guardado completado</h1>
        <p>Se han guardado correctamente los datos de <?php echo $nombre; ?>.</p>

        <?php if ($datosNoModificados) { ?>
            <p>En realidad, no había modificado nada</p>
        <?php } ?>
    <?php }
    ?>

    <?php
} else {
    ?>

    <h1>Error en la modificación.</h1>
    <p>No se han podido guardar los datos de el jugador.</p>

    <?php
}
?>

<a href='jugadorListado.php'>Volver al listado de Jugadores.</a>

</body>

</html>