<?php

require_once "_varios.php";

$conexion= obtenerPdoConexionBD();

$sql = "SELECT id, nombre FROM categoria ORDER BY nombre";

$select = $conexion->prepare($sql);
$select->execute([]);
$rs = $select->fetchAll();

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

    <?php foreach ($rs as $fila) { ?>
        <tr>
            <td><a href='categoriaFicha.php?id=<?=$fila["id"]?>'> <?=$fila["nombre"] ?> </a></td>
            <td><a href='categoriaEliminar.php?id=<?=$fila["id"]?>'> (X)</a></td>
        </tr>
    <?php } ?>

</table>

<br />

<a href='categoriaFicha.php?id=-1'>Crear entrada</a>

<br />
<br />

<a href='jugadorListado.php'>Gestionar listado de Jugadores</a>

</body>

</html>