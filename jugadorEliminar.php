<?php
//
require_once "_com/dao.php";
require_once "_com/_varios.php";

// Se recoge el parámetro "id" de la request.
$id = (int)$_REQUEST["id"];

$resultado = DAO::jugadorEliminar($id);

if($resultado)
    redireccionar("jugadorListado.php?eliminacionCorrecta");
else
    redireccionar("jugadorListado.php?eliminacionErronea");
?>

