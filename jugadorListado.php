<?php
require_once "_com/_varios.php";
require_once "_com/dao.php";


$jugadores = dao::jugadorObtenerTodos();

?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<h1>Jugadores</h1>

<table border='1'>

    <tr>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Categoría</th>
        <th>Dorsal</th>
        <th>Equipo</th>
        <th>Eliminar</th>

    </tr>

    <?php
    foreach ($jugadores as $fila) { ?>



        <?php
        $urlImagen = "/img/cruz-roja.png";
        ?>

        <tr>
            <td>
            <a href='jugadorFicha.php?id=<?=$fila->getId()?>'> <?= $fila->getNombreJugador() ?> </a>
                <a href='jugadorLesionado.php?id=<?=$fila->getId()?>'>
                    <img src='$urlImagen' width='25' height='15'></a>
            </td>
            <td><a href='jugadorFicha.php?id=<?=$fila->getId()?>'> <?= $fila->getJugadorApellidos() ?> </a></td>
            <td><a href='jugadorFicha.php?id=<?=$fila->getId()?>'> <?= $fila->getJugadorCategoriaId() ?> </a></td>
            <td><a href='jugadorFicha.php?id=<?=$fila->getId()?>'> <?= $fila->getJugadorDorsal() ?> </a></td>
            <td><a href='jugadorFicha.php?id=<?=$fila->getId()?>'> <?= $fila->getJugadorEquipoId() ?> </a></td>
            <td><a href='jugadorEliminar.php?id=<?=$fila->getId()?>'> (X)                      </a></td>
        </tr>
    <?php } ?>

</table>

<br />

<?php if (!isset($_SESSION["soloLesionado"])) {?>
    <a href='jugadorListado.php?soloLesionado'>Mostrar solo jugadores lesionados</a>
<?php } else { ?>
    <a href='jugadorListado.php?todos'>Mostrar todos los jugadores</a>
<?php } ?>

<br />
<br />

<a href='jugadorFicha.php?id=-1'>Crear entrada</a>

<br />
<br />

<a href='categoriaListado.php'>Gestionar listado de Posiciones</a>

<br>
<br>

<a href="paginaPrincipal.php">Volver a la página principal</a>

</body>