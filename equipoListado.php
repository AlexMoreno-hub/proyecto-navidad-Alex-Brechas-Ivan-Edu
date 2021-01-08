<?php
require_once "_com/_varios.php";


$conexion= obtenerPdoConexionBD();

$sql = "SELECT id, nombre FROM equipo ORDER BY nombre";

$select = $conexion->prepare($sql);
$select->execute([]);
$rs = $select->fetchAll();

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

    <?php foreach ($rs as $fila) { ?>
        <tr>
            <td><a href='equipoFicha.php?id=<?=$fila["id"]?>'> <?=$fila["nombre"] ?> </a></td>
            <td><a href='equipoEliminar.php?id=<?=$fila["id"]?>'> (X)</a></td>
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