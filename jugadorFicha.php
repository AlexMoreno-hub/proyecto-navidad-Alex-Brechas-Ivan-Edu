<?php


require_once "_com/_varios.php";

$conexion = obtenerPdoConexionBD();


$id = (int)$_REQUEST["id"];

$nuevaEntrada = ($id == -1);

if ($nuevaEntrada) { // Quieren CREAR una nueva entrada, así que no se cargan datos.
    $jugadorNombre = "<introduzca nombre>";
    $jugadorApellidos = "<introduzca apellidos>";
    $jugadorDorsal = "<introduzca dorsal>";
    $jugadorEquipo= "<introduzca equipo>";
    $jugadorLesioando=false;

    $jugadorCategoriaId = 0;
} else { // Quieren VER la ficha de una persona existente, cuyos datos se cargan.
    $sqlPersona = "SELECT nombre, apellidos, dorsal, lesionado , equipoId ,categoriaId FROM jugador WHERE id=?";

    $select = $conexion->prepare($sqlPersona);
    $select->execute([$id]); // Se añade el parámetro a la consulta preparada.
    $rsJugador = $select->fetchAll();

    // Con esto, accedemos a los datos de la primera (y esperemos que única) fila que haya venido.
    $jugadorNombre = $rsJugador[0]["nombre"];
    $jugadorApellidos = $rsJugador[0]["apellidos"];
    $jugadorDorsal = $rsJugador[0]["dorsal"];
    $jugadorLesioando = ($rsJugador[0]["lesionado"] == 1);
    $jugadorEquipo =$rsJugador[0]["equipoId"];
    $jugadorCategoriaId = $rsJugador[0]["categoriaId"];
}


// Con lo siguiente se deja preparado un recordset con todas las categorías.

$sqlCategorias = "SELECT id, nombre FROM categoria ORDER BY nombre";

$select = $conexion->prepare($sqlCategorias);
$select->execute([]);
$rsCategorias = $select->fetchAll();



// INTERFAZ:
// jugadorNombre , apellidos..
// jugadorDorsal
// jugadorCategoriaId
// rsCategorias
?>




<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php if ($nuevaEntrada) { ?>
    <h1>Nuevo Jugador</h1>
<?php } else { ?>
    <h1>Ficha Jugador</h1>
<?php } ?>

<form method='post' action='jugadorGuardar.php'>

    <input type='hidden' name='id' value='<?= $id ?>' />


    <label for='nombre'>Nombre: </label>
    <input type='text' name='nombre' value='<?=$jugadorNombre ?>' />
    <br/>

    <label for='apellidos'> Apellidos: </label>
    <input type='text' name='apellidos' value='<?=$jugadorApellidos ?>' />
    <br/>

    <label for='dorsal'> Dorsal: </label>
    <input type='text' name='dorsal' value='<?=$jugadorDorsal ?>' />
    <br/>

    <label for='categoriaId'>Categoría: </label>
    <select name='categoriaId'>
        <?php
        foreach ($rsCategorias as $filaCategoria) {
            $categoriaId = (int) $filaCategoria["id"];
            $categoriaNombre = $filaCategoria["nombre"];

            if ($categoriaId == $jugadorCategoriaId) $seleccion = "selected='true'";
            else                                     $seleccion = "";

            echo "<option value='$categoriaId' $seleccion>$categoriaNombre</option>";

        }
        ?>
    </select>
    <br/>

    <label for='lesionado'>Lesionado</label>
    <input type='checkbox' name='lesionado' <?= $jugadorLesioando ? "checked" : "" ?> />
    <br/>

    <label for='equipo'> Equipo: </label>
    <input type='text' name='equipo' value='<?=$jugadorEquipo ?>' />
    <br/>

    <br/>


    <?php if ($nuevaEntrada) { ?>
        <input type='submit' name='crear' value='Crear jugador' />
    <?php } else { ?>
        <input type='submit' name='guardar' value='Guardar cambios' />
    <?php } ?>

</form>

<?php if (!$nuevaEntrada) { ?>
    <br />
    <a href='jugadorEliminar.php?id=<?=$id ?>'>Eliminar jugador</a>
<?php } ?>

<br />
<br />

<a href='jugadorListado.php'>Volver al listado de personas.</a>

</body>

</html>

