<?php

require_once "_com/_varios.php";
$conexion = obtenerPdoConexionBD();


$id = (int)$_REQUEST["id"];

$nuevaEntrada = ($id == -1);

if ($nuevaEntrada) { // Quieren CREAR una nueva entrada, así que no se cargan datos.
    $equipoNombre = "<introduzca nombre>";
} else { // Quieren VER la ficha de una persona existente, cuyos datos se cargan.
    $sqlEquipo = "SELECT id,nombre FROM equipo WHERE id=?";

    $select = $conexion->prepare($sqlEquipo);
    $select->execute([$id]); // Se añade el parámetro a la consulta preparada.
    $rsEquipo = $select->fetchAll();

    // Con esto, accedemos a los datos de la primera (y esperemos que única) fila que haya venido.
    $equipoNombre = $rsEquipo[0]["nombre"];
}


// Con lo siguiente se deja preparado un recordset con todas las categorías.


$sql = "SELECT * FROM jugador WHERE equipoId=? ORDER BY nombre";

$select = $conexion->prepare($sql);
$select->execute([$id]);
$rsJugadoresDelEquipo = $select->fetchAll();


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
    <input type='text' name='nombre' value='<?=$equipoNombre ?>' />
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

<ul>
    <?php
    foreach ($rsJugadoresDelEquipo as $fila) {
        echo "<li>$fila[nombre] $fila[apellidos]</li>";
    }
    ?>
</ul>


<?php if (!$nuevaEntrada) { ?>
    <br />
    <a href='equipoEliminar.php?id=<?=$id ?>'>Eliminar equipo</a>
<?php } ?>

<br />
<br />

<a href='equipoListado.php'>Volver al listado de equipos.</a>

</body>

</html>