<?php
	require_once "_com/Varios.php";

	$conexionBD = obtenerPdoConexionBD();

	// Se recogen los datos del formulario de la request.
	$id = (int)$_REQUEST["id"];
	$nombre = $_REQUEST["nombre"];

	// Si id es -1 quieren CREAR una nueva entrada ($nueva_entrada tomará true).
	// Sin embargo, si id NO es -1 quieren VER la ficha de una categoría existente
	// (y $nueva_entrada tomará false).
	$nuevaEntrada = ($id == -1);
	
	if ($nuevaEntrada) {
		// Quieren CREAR una nueva entrada, así que es un INSERT.
 		$sql = "INSERT INTO Categoria (nombre) VALUES (?)";
 		$parametros = [$nombre];
	} else {
		// Quieren MODIFICAR una categoría existente y es un UPDATE.
 		$sql = "UPDATE Categoria SET nombre=? WHERE id=?";
        $parametros = [$nombre, $id];
 	}
 	
    $sentencia = $conexionBD->prepare($sql);
    //Esta llamada devuelve true o false según si la ejecución de la sentencia ha ido bien o mal.
    $sqlConExito = $sentencia->execute($parametros); // Se añaden los parámetros a la consulta preparada.

 	// Está todo correcto de forma normal si NO ha habido errores y se ha visto afectada UNA fila.
 	$correcto = ($sqlConExito && $sentencia->rowCount() == 1);

 	// Si los datos no se habían modificado, también está correcto pero es "raro".
 	$datosNoModificados = ($sqlConExito && $sentencia->rowCount() == 0);



 	// INTERFAZ:
    // $nuevaEntrada
    // $correcto
    // $datosNoModificados
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
			<h1>Inserción completada</h1>
			<p>Se ha insertado correctamente la nueva entrada de <?=$nombre?>.</p>
		<?php } else { ?>
			<h1>Guardado completado</h1>
			<p>Se han guardado correctamente los datos de <?=$nombre?>.</p>

			<?php if ($datosNoModificados) { ?>
				<p>En realidad, no había modificado nada, pero no está de más que se haya asegurado pulsando el botón de guardar :)</p>
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

<a href='CategoriaObtenerTodas.php'>Volver al listado de categorías.</a>

</body>

</html>