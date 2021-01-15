<?php

require_once "_com/dao.php";
require_once "_com/_varios.php";

// Se recoge el parámetro "id" de la request.
$id= (int)$_REQUEST["id"];
$nombre = $_REQUEST["nombre"];

$resultado=dao::agregarCategoria($id,$nombre);

$nuevaEntrada = ($id == -1);

if ($resultado){
    redireccionar("categoriaListado.php?");
}
else {
    redireccionar("categoriaListado.php?");
}
/*
$conexion = obtenerPdoConexionBD();


$id = (int)$_REQUEST["id"];
$nombre = $_REQUEST["nombre"];


$nuevaEntrada = ($id == -1);

if ($nuevaEntrada) {

    $sql = "INSERT INTO categoria (nombre) VALUES (?)";
    $parametros = [$nombre];
} else {

    $sql = "UPDATE categoria SET nombre=? WHERE id=?";
    $parametros = [$nombre, $id];
}

$sentencia = $conexion->prepare($sql);


$sqlConExito = $sentencia->execute($parametros);

// Está todo correcto de forma normal si NO ha habido errores y se ha visto afectada UNA fila.
$correcto = ($sqlConExito && $sentencia->rowCount() == 1);


$datosNoModificados = ($sqlConExito && $sentencia->rowCount() == 0);



// INTERFAZ: $nuevaEntrada, $correcto , $datosNoModificados
?>


<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php
// Todo bien tanto si se han guardado los datos nuevos como si no se habían modificado.
if ($correcto || $datosNoModificados) { ?>
    <?php if ($nuevaEntrada) { ?>
        <h1>Completado</h1>
        <p>Se ha añadido la nueva posición de: <?=$nombre?>.</p>
    <?php } else { ?>
        <h1>Guardado completado</h1>
        <p>Se han guardado correctamente los datos de <?=$nombre?>.</p>

        <?php if ($datosNoModificados) { ?>
            <p>En realidad, no había modificado nada</p>
        <?php } ?>
    <?php }
    ?>

    <?php
} else {
    ?>

    <?php if ($nuevaEntrada) { ?>
        <h1>Error en la creación.</h1>
        <p>No se ha podido crear la nueva categoría.</p>
    <?php } else { ?>
        <h1>Error en la modificación.</h1>
        <p>No se han podido guardar los datos de la categoría.</p>
    <?php } ?>

    <?php
}
?>

<a href='categoriaListado.php'>Volver al listado de posiciones.</a>

</body>

</html>*/
?>