<?php
//

require_once "_com/_varios.php";
require_once  "_com/dao.php";


$id = (int)$_REQUEST["id"];

$nuevaEntrada = ($id == -1);

if ($nuevaEntrada) { // Quieren CREAR una nueva entrada, así que no se cargan datos.
    $jugadorNombre = "<introduzca nombre>";
    $jugadorApellidos = "<introduzca apellidos>";
    $jugadorDorsal = "1";
    $jugadorLesioando=false;
    $jugadorCategoriaId = 0;
    $jugadorEquipoId = 0;
} else {

    $jugador = dao::jugadorObtenerPorId($id);
    $jugadorNombre = $jugador->getNombreJugador();
    $jugadorApellidos = $jugador->getJugadorApellidos();
    $jugadorDorsal = $jugador->getJugadorDorsal();
    $jugadorLesioando = $jugador->getJugadorLesioando();
    $jugadorCategoriaId = $jugador->getJugadorCategoriaId();
    $jugadorEquipoId = $jugador->getJugadorEquipoId();

}

$rsCategorias= DAO::jugadorSelectCategoria();
$rsEquipo= DAO::jugadorSelectEquipo();


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


    <label for='equipoId'>Equipo: </label>
    <select name='equipoId'>
        <?php
        foreach ($rsEquipo as $filaEquipo) {
            $equipoId = (int)$filaEquipo["id"];
            $equipoNombre = $filaEquipo["nombre"];

            if ($equipoId == $jugadorEquipoId) $seleccion = "selected='true'";
            else                                     $seleccion = "";

            echo "<option value='$equipoId' $seleccion>$equipoNombre</option>";

        }
        ?>
    </select>


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

