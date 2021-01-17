<?php
//
require_once "_com/DAO.php";
require_once "_com/_varios.php";

// Se recoge el parámetro "id" de la request.
$id = (int)$_REQUEST["id"];

$resultado = DAO::categoriaEliminar($id);

if($resultado)
    redireccionar("categoriaListado.php?eliminacionCorrecta");
else
    redireccionar("categoriaListado.php?eliminacionErronea");
?>
