<?php
	require_once "_com/Varios.php";

	$conexion = obtenerPdoConexionBD();
	
	// Se recoge el parámetro "id" de la request.
	$id = (int)$_REQUEST["id"];

	// Si id es -1 quieren CREAR una nueva entrada ($nueva_entrada tomará true).
	// Sin embargo, si id NO es -1 quieren VER la ficha de una categoría existente
	// (y $nueva_entrada tomará false).
	$nuevaEntrada = ($id == -1);

	if ($nuevaEntrada) { // Quieren CREAR una nueva entrada, así que no se cargan datos.
		$categoriaNombre = "<introduzca nombre>";
	} else { // Quieren VER la ficha de una categoría existente, cuyos datos se cargan.
		$sql = "SELECT nombre FROM Categoria WHERE id=?";

        $select = $conexion->prepare($sql);
        $select->execute([$id]); // Se añade el parámetro a la consulta preparada.
        $rs = $select->fetchAll();
		
		 // Con esto, accedemos a los datos de la primera (y esperemos que única) fila que haya venido.
		$categoriaNombre = $rs[0]["nombre"];
	}



    $sql = "SELECT * FROM Persona WHERE categoriaId=? ORDER BY nombre";

    $select = $conexion->prepare($sql);
    $select->execute([$id]); // Array vacío porque la consulta preparada no requiere parámetros.
    $rsPersonasDeLaCategoria = $select->fetchAll();


	// INTERFAZ:
    // $nuevaEntrada
    // $categoriaNombre
    // $rsPersonasDeLaCategoria
?>



<html>

<head>
	<meta charset='UTF-8'>
</head>



<body>

<?php if ($nuevaEntrada) { ?>
	<h1>Nueva ficha de categoría</h1>
<?php } else { ?>
	<h1>Ficha de categoría</h1>
<?php } ?>

<form method='post' action='CategoriaGuardar.php'>

<input type='hidden' name='id' value='<?=$id?>' />

    <label for='nombre'>Nombre</label>
	<input type='text' name='nombre' value='<?=$categoriaNombre?>' />
    <br/>

    <br/>

<?php if ($nuevaEntrada) { ?>
	<input type='submit' name='crear' value='Crear categoría' />
<?php } else { ?>
	<input type='submit' name='guardar' value='Guardar cambios' />
<?php } ?>

</form>

<br />

<p>Personas que pertenecen actualmente a la categoría:</p>

<ul>
<?php
    foreach ($rsPersonasDeLaCategoria as $fila) {
        echo "<li>$fila[nombre] $fila[apellidos]</li>";
    }
?>
</ul>

<?php if (!$nuevaEntrada) { ?>
    <br />
    <a href='CategoriaEliminar.php?id=<?=$id?>'>Eliminar categoría</a>
<?php } ?>

<br />
<br />

<a href='CategoriaObtenerTodas.php'>Volver al listado de categorías.</a>

</body>

</html>