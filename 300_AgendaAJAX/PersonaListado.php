<?php
    require_once "_com/Varios.php";

    $conexion = obtenerPdoConexionBD();

    session_start(); // Crear post-it vacío, o recuperar el que ya haya  (vacío o con cosas).
    if (isset($_REQUEST["soloEstrellas"])) {
        $_SESSION["soloEstrellas"] = true;
    }
    if (isset($_REQUEST["todos"])) {
        unset($_SESSION["soloEstrellas"]);
    }

    $posibleClausulaWhere = isset($_SESSION["soloEstrellas"]) ? "WHERE p.estrella=1" : "";

    $sql = "
               SELECT
                    p.id     AS pId,
                    p.nombre AS pNombre,
                    p.apellidos AS pApellidos,
                    p.estrella AS pEstrella,
                    c.id     AS cId,
                    c.nombre AS cNombre
                FROM
                   Persona AS p INNER JOIN Categoria AS c
                   ON p.categoriaId = c.id
                $posibleClausulaWhere
                ORDER BY p.nombre
            ";

    $select = $conexion->prepare($sql);
    $select->execute([]); // Array vacío porque la consulta preparada no requiere parámetros.
    $rs = $select->fetchAll();


    // INTERFAZ:
    // $rs
    // $_SESSION
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<h1>Listado de Personas</h1>

<table border='1'>

    <tr>
        <th>Persona</th>
        <th>Categoría</th>
    </tr>

    <?php
    foreach ($rs as $fila) { ?>
        <tr>
            <td>
                <?php
                    $urlImagen = $fila["pEstrella"] ? "img/EstrellaRellena.png" : "img/EstrellaVacia.png";
                    echo " <a href='PersonaEstablecerEstadoEstrella.php?id=$fila[pId]'><img src='$urlImagen' width='16' height='16'></a> ";

                    echo "<a href='PersonaFicha.php?id=$fila[pId]'>";
                    echo "$fila[pNombre]";
                    if ($fila["pApellidos"] != "") {
                        echo " $fila[pApellidos]";
                    }
                    echo "</a>";
                ?>
            </td>
            <td><a href= 'CategoriaFicha.php?id=<?=$fila["cId"]?>'> <?= $fila["cNombre"] ?> </a></td>
            <td><a href='PersonaEliminar.php?id=<?=$fila["pId"]?>'> (X)                      </a></td>
        </tr>
    <?php } ?>

</table>

<br />

<?php if (!isset($_SESSION["soloEstrellas"])) {?>
    <a href='PersonaListado.php?soloEstrellas'>Mostrar solo contactos con estrella</a>
<?php } else { ?>
    <a href='PersonaListado.php?todos'>Mostrar todos los contactos</a>
<?php } ?>

<br />
<br />

<a href='PersonaFicha.php?id=-1'>Crear entrada</a>

<br />
<br />

<a href='CategoriaObtenerTodas.php'>Gestionar listado de Categorías</a>

</body>

</html>