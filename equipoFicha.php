<?php

require_once "_com/dao.php";
require_once "_com/_varios.php";

$id = (int)$_REQUEST["id"];

$nuevaEntrada = ($id == -1);

if ($nuevaEntrada) { // Quieren CREAR una nueva entrada, así que no se cargan datos.

    $equipoNombre = "<introduzca nombre>";

} else { // Quieren VER la ficha de una posicion existente, cuyos datos se cargan.
    /*
        $sql = "SELECT nombre FROM categoria WHERE id=?";
        $select = $conexion->prepare($sql);
        $select->execute([$id]);
        $rs = $select->fetchAll();*/
    $equipo= dao::EquipoObtenerPorId($id);
    $equipoNombre = $equipo->getNombreEquipo();
    // Con esto, accedemos a los datos de la primera (y esperemos que única) fila que haya venido.
    /* $rs=dao::categoriaModificar($id);
     $categoriaNombre = $rs[1];/*/
}



// Con lo siguiente se deja preparado un recordset con todas las categorías.

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
    <h1>Nuevo equipo</h1>
<?php } else { ?>
    <h1>Ficha equipo</h1>
<?php } ?>

<form method='post' action='equipoGuardar.php'>

    <input type='hidden' name='id' value='<?= $id ?>' />


    <label for='nombre'>Nombre: </label>
    <input type='text' name='nombre' value='<?=$equipoNombre?>' />
    <br/>

    <br/>

    <br/>


    <?php if ($nuevaEntrada) { ?>
        <input type='submit' name='crear' value='Crear equipo' />
    <?php } else { ?>
        <input type='submit' name='guardar' value='Guardar cambios' />
    <?php } ?>

</form>


<p>Jugadores que pertenecen actualmente :</p>
<!--
<ul>

    foreach ($rsJugadoresDelEquipo as $fila) {
        echo "<li>$fila[nombre] $fila[apellidos]</li>";
    }

</ul>
-->

<?php if (!$nuevaEntrada) { ?>
    <br />
    <a href='equipoEliminar.php?id=<?=$id ?>'>Eliminar equipo</a>
<?php } ?>

<br />
<br />

<a href='equipoListado.php'>Volver al listado de equipos.</a>

</body>

</html>