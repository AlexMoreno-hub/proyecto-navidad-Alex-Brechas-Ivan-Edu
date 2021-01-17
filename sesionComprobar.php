<?php
//se comprueba si el usuario existe o no...

require_once "_com/dao.php";


$nombreUsuario=$_REQUEST["nombreUsuario"];
$contrasenna=$_REQUEST["contrasenna"];

$arrayUsuario=DAO::usuarioObtener($nombreUsuario,$contrasenna);

if ($arrayUsuario != null) {
    DAO::marcarSesionComoIniciada($arrayUsuario);

    if (isset($_REQUEST["recordar"])) {
        DAO::establecerSesionCookie($arrayUsuario);
    }
    redireccionar("categoriaListado.php");
} else {
    redireccionar("sesionFormulario.php?datosErroneos");
}