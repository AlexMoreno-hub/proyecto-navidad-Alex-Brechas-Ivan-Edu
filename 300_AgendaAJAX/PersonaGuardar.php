<?php
	require_once "_com/Varios.php";

	$conexion = obtenerPdoConexionBD();

	// Se recogen los datos del formulario de la request.
	$id = (int)$_REQUEST["id"];
	$nombre = $_REQUEST["nombre"];
	$apellidos = $_REQUEST["apellidos"];
	$telefono = $_REQUEST["telefono"];
    $categoriaId = (int)$_REQUEST["categoriaId"];
    $estrella = isset($_REQUEST["estrella"]);

	// Si id es -1 quieren INSERTAR una nueva entrada ($nueva_entrada tomará true).
	// Sin embargo, si id NO es -1 quieren ACTUALIZAR la ficha de una persona existente
	// (y $nueva_entrada tomar false).
	$nuevaEntrada = ($id == -1);
	
	if ($nuevaEntrada) {
		// Quieren CREAR una nueva entrada, así que es un INSERT.
 		$sql = "INSERT INTO Persona (nombre, apellidos, telefono, estrella, categoriaId) VALUES (?, ?, ?, ?, ?)";
        $parametros = [$nombre, $apellidos, $telefono, $estrella?1:0, $categoriaId];
	} else {
		// Quieren MODIFICAR una persona existente y es un UPDATE.
 		$sql = "UPDATE Persona SET nombre=?, apellidos=?, telefono=?, estrella=?, categoriaId=? WHERE id=?";
        $parametros = [$nombre, $apellidos, $telefono, $estrella?1:0, $categoriaId, $id];
 	}

    $sentencia = $conexion->prepare($sql);
    // Esta llamada devuelve true o false según si la ejecución de la sentencia ha ido bien o mal.
    $sqlConExito = $sentencia->execute($parametros); // Se añaden los parámetros a la consulta preparada.

    //Se consulta la cantidad de filas afectadas por la ultima sentencia SQL.
    $numFilasAfectadas = $sentencia->rowCount();
    $unaFilaAfectada = ($numFilasAfectadas == 1);
    $ningunaFilaAfectada = ($numFilasAfectadas == 0);

    // Está todo correcto de forma NORMAL si NO ha habido errores y se ha visto afectada UNA fila.
    $correcto = ($sqlConExito && $unaFilaAfectada);

    // Si los datos no se habían modificado, también está correcto, pero de otra manera.
    $datosNoModificados = ($sqlConExito && $ningunaFilaAfectada);
?>



<html>

<head>
	<meta charset='UTF-8'>
</head>



<body>

<?php
	// Todo bien tanto si se han guardado los datos nuevos como si no se habían modificado.
	if ($correcto || $datosNoModificados) { ?>

		<?php if ($id == -1) { ?>
			<h1>Inserción completada</h1>
			<p>Se ha insertado correctamente la nueva entrada de <?php echo $nombre; ?>.</p>
		<?php } else { ?>
			<h1>Guardado completado</h1>
			<p>Se han guardado correctamente los datos de <?php echo $nombre; ?>.</p>

			<?php if ($datosNoModificados) { ?>
				<p>En realidad, no había modificado nada, pero no está de más que se haya asegurado pulsando el botón de guardar :)</p>
			<?php } ?>
		<?php }
?>

<?php
	} else {
?>

	<h1>Error en la modificación.</h1>
	<p>No se han podido guardar los datos de la persona.</p>

<?php
	}
?>

<a href='PersonaListado.php'>Volver al listado de personas.</a>

</body>

</html>