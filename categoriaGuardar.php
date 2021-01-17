<?php
//
require_once "_com/dao.php";
require_once "_com/_varios.php";

// Se recoge el parámetro "id" de la request.
$id= (int)$_REQUEST["id"];
$nombre = $_REQUEST["nombre"];

/*---*/

$nuevaEntrada = ($id == -1);
$resultado=false;
$datosNoModificados=false;

if ($nuevaEntrada){
    $resultado=dao::categoriaCrear($nombre);
    redireccionar("categoriaListado.php");
}
else {
    $datosNoModificados = DAO::categoriaModificar($id,$nombre);
    redireccionar("categoriaListado.php");
}

?>