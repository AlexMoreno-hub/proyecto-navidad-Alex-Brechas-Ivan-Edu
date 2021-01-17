<?php

require_once "_com/dao.php";
require_once "_com/_varios.php";


$id = (int)$_REQUEST["id"];

$resultado = DAO::jugadorEliminar($id);

if($resultado)
    redireccionar("jugadorListado.php?eliminacionCorrecta");
else
    redireccionar("jugadorListado.php?eliminacionErronea");
?>

