<?php
//
require_once "_com/DAO.php";
require_once "_com/_varios.php";


$id = (int)$_REQUEST["id"];

$resultado = DAO::equipoEliminar($id);

if($resultado)
    redireccionar("equipoListado.php?eliminacionCorrecta");
else
    redireccionar("equipoListado.php?eliminacionErronea");
?>

