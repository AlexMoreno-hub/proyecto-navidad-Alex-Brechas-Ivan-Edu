<?php

require_once "_com/dao.php";
require_once "_com/_varios.php";

$id = (int)$_REQUEST["id"];

$nuevaEntrada = ($id == -1);

if ($nuevaEntrada) { // Quieren CREAR una nueva entrada, así que no se cargan datos.

    $categoriaNombre = "<introduzca nombre>";

} else { // Quieren VER la ficha de una posicion existente, cuyos datos se cargan.
    /*
        $sql = "SELECT nombre FROM categoria WHERE id=?";
        $select = $conexion->prepare($sql);
        $select->execute([$id]);
        $rs = $select->fetchAll();*/
    $categoria = dao::categoriaObtenerPorId($id);
    $categoriaNombre = $categoria->getNombreCategoria();
    // Con esto, accedemos a los datos de la primera (y esperemos que única) fila que haya venido.
    /* $rs=dao::categoriaModificar($id);
     $categoriaNombre = $rs[1];/*/
 }


/*
$sql = "SELECT * FROM jugador WHERE categoriaId=? ORDER BY nombre";

$select = $conexion->prepare($sql);
$select->execute([$id]);

$rsJugadoresDeLaCategoria = $select->fetchAll();

   $rsJugadoresDeLaCategoria= dao::mostrarJugadores($id);
*/
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

<form method='post' action='categoriaGuardar.php'>

    <input type='hidden' name='id' value='<?=$id?>' />

    <ul>
        <li>
            <strong>Nombre: </strong>
            <input type='text' name='nombre' value='<?=$categoriaNombre?>' />
        </li>
    </ul>

    <?php if ($nuevaEntrada) { ?>
        <input type='submit' name='crear' value='Crear categoría' />
    <?php } else { ?>
        <input type='submit' name='guardar' value='Guardar cambios' />
    <?php } ?>

</form>
<br />

<p>Personas que pertenecen actualmente a la categoría:</p>

<ul>

</ul>


<?php if (!$nuevaEntrada) { ?>
    <br />
    <a href='categoriaEliminar.php?id=<?=$id?>'>Eliminar Poscición</a>
<?php } ?>

<br />

<a href='categoriaListado.php'>Volver al listado de Posiciones.</a>

</body>

</html>
