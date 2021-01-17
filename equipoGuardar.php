<?php
//
require_once "_com/dao.php";
require_once "_com/_varios.php";

// Se recoge el parámetro "id" de la request.
$id= (int)$_REQUEST["id"];
$nombre = $_REQUEST["nombre"];


$nuevaEntrada = ($id == -1);
$resultado=false;
$datosNoModificados=false;

if ($nuevaEntrada){
    $resultado=dao::equipoCrear($nombre);
    redireccionar("equipoListado.php");
}
else {
    $datosNoModificados = DAO::equipoModificar($id,$nombre);
    redireccionar("equipoListado.php");
}






/*
$conexion = obtenerPdoConexionBD();

// Se recogen los datos del formulario de la request.
$id = (int)$_REQUEST["id"];
$nombre = $_REQUEST["nombre"];


$nuevaEntrada = ($id == -1);

if ($nuevaEntrada) {
    // Quieren CREAR una nueva entrada, así que es un INSERT.
    $sql = "INSERT INTO equipo (id , nombre) VALUES (?,?)";
    $parametros = [$id, $nombre];
} else {
    // Quieren MODIFICAR una persona existente y es un UPDATE.
    $sql = "UPDATE equipo SET id=? nombre=?  WHERE id=?";
    $parametros = [$nombre, $id];
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
    <p>No se han podido guardar los datos de el equipo.</p>

    <?php
}
?>

<a href='equipoListado.php'>Volver al listado de equipos.</a>

</body>

</html>
*/
?>