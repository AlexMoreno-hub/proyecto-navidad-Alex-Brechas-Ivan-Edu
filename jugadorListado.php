<?php
require_once "_com/_varios.php";
require_once "_com/dao.php";
/*
$conexion = obtenerPdoConexionBD();

$mostrarLesionado = isset($_REQUEST["soloLesionado"]);

session_start(); // Crear post-it vacío, o recuperar el que ya haya  (vacío o con cosas).
if (isset($_REQUEST["soloLesionado"])) {
    $_SESSION["soloLesionado"] = true;
}
if (isset($_REQUEST["todos"])) {
    unset($_SESSION["soloLesionado"]);
}

$posibleClausulaWhere = $mostrarLesionado ? "WHERE p.lesionado=1" : "";
*/

$jugadores = dao::jugadorObtenerTodos();
/*
$sql = "
               SELECT
                    p.id     AS pId,
                    p.nombre AS pNombre,
                    p.apellidos AS pApellidos,
                    p.dorsal AS pDorsal,
                    p.lesionado AS pLesionado,
                    c.id     AS cId,
                    c.nombre AS cNombre,
                    e.id AS eId,
                    e.nombre AS eNombre
                FROM
                   jugador AS p INNER JOIN categoria AS c
                   ON p.categoriaId = c.id
                   INNER JOIN equipo AS e ON p.equipoId = e.id
                   $posibleClausulaWhere
                ORDER BY p.nombre
            ";

$select = $conexion->prepare($sql);
$select->execute([]);
$rs = $select->fetchAll();


// INTERFAZ:
// $rs*/
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

        <tr>
           <!-- <td>
                <?php/*
           echo "<a href='jugadorFicha.php?id=$fila->getId()'>";
           echo "$fila->getNombreJugador()";
           echo "</a>";

           $urlImagen = $fila["pLesionado"] ? "img/cruz-roja.png" : "img/2.png";
           echo " <a href='jugadorLesionado.php.php?id=$fila[pId]'><img src='$urlImagen' width='16' height='16'></a> ";
           */?>
            </td>-->
            <td><a href='jugadorFicha.php?id=<?=$fila->getId()?>'> <?= $fila->getNombreJugador() ?> </a></td>
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

</body>