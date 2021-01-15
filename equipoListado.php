<?php
require_once "_com/_varios.php";
require_once "_com/dao.php";

$equipos = dao::equipoObtenerTodos();




?>

<html>

<head>
    <meta charset='UTF-8'>
</head>

<body>

<h1>Listado de Equipos</h1>

<table border='1'>

    <tr>
        <th>Nombre</th>
    </tr>

    <?php foreach ($equipos as $fila) { ?>
        <tr>
            <td><a href='equipoFicha.php?id=<?=$fila->getId()?>'> <?=$fila->getNombreEquipo()?> </a></td>
        </tr>
    <?php } ?>


</table>

<br />

<a href='equipoFicha.php?id=-1'>Crear entrada</a>

<br />
<br />

<a href='jugadorListado.php'>Gestionar listado de Jugadores</a>
<br />
<br />
<a href="categoriaListado.php">Gestionar listado de posciones</a>

</body>

</html>