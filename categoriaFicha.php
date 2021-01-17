<?php
//
require_once "_com/dao.php";
require_once "_com/_varios.php";

$id = (int)$_REQUEST["id"];

$nuevaEntrada = ($id == -1);

if ($nuevaEntrada) { // Quieren CREAR una nueva entrada, así que no se cargan datos.

    $categoriaNombre = "<introduzca nombre>";

} else {
    $categoria = dao::categoriaObtenerPorId($id);
    $categoriaNombre = $categoria->getNombreCategoria();

 }

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
    <?php
    $rsJugadoresDeLaCategoria= dao::mostrarJugadores($id);
    ?>
</ul>

<ul>

</ul>


<?php if (!$nuevaEntrada) { ?>
    <br />
    <a href='categoriaEliminar.php?id=<?=$id?>'>Eliminar Posición</a>
<?php } ?>

<br />

<a href='categoriaListado.php'>Volver al listado de Posiciones.</a>

</body>

</html>
