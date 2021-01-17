<?php
//
require_once "_com/DAO.php";
require_once "_com/_varios.php";

// Se recoge el parámetro "id" de la request.
$id = (int)$_REQUEST["id"];

$resultado = DAO::equipoEliminar($id);

if($resultado)
    redireccionar("equipoListado.php?eliminacionCorrecta");
else
    redireccionar("equipoListado.php?eliminacionErronea");
?>

