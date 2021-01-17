<?php
/*Comprobar si usuario introducido ya existe*/

require_once "_com/dao.php";


$nombreUsuario=$_REQUEST["nombreUsuario"];
$contrasenna=$_REQUEST["contrasenna"];

$arrayUsuario=DAO::usuarioObtener($nombreUsuario,$contrasenna);

if ($arrayUsuario) {
    /*si obtenemos usuario existente*/
    DAO::marcarSesionComoIniciada($arrayUsuario);

    if (isset($_REQUEST["recordar"]))
        DAO::establecerSesionCookie($arrayUsuario);
    redireccionar("paginaPrincipal.php");
} else
    redireccionar("sesionFormulario.php?datosErroneos");

?>
