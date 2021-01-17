<?php
require_once "_com/dao.php";
require_once "_com/_varios.php";

$categorias = DAO::categoriaObtenerTodas();


?>

<html>

<head>
    <meta charset='UTF-8'>
</head>

<body>

<h1>Listado de Posiciones</h1>

<table border='1'>

    <tr>
        <th>Nombre</th>
    </tr>
    <?php foreach ($categorias as $fila) { ?>
        <tr>
            <td><a href='categoriaFicha.php?id=<?=$fila->getId()?>'> <?=$fila->getNombreCategoria()?> </a></td>
            <td><a href='categoriaEliminar.php?id=<?=$fila->getId()?>'> (X)                            </a></td>

        </tr>
    <?php } ?>

</table>

<br />

<a href='categoriaFicha.php?id=-1'>Crear entrada</a>

<br />
<br />

<a href='jugadorListado.php'>Gestionar listado de Jugadores</a>
<br />
<br />
<a href="equipoListado.php">Gestionar equipos</a>
<br />
<br />
<a href="sesionCerrar.php">Cerrar sesion</a>

</body>

</html>