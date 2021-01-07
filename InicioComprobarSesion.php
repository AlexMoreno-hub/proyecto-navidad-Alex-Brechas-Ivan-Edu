<?php
require_once "_com/DAO.php";
//print_r($_SESSION["idCliente"]);
/*Si no hay session iniciada redirigimos a la pagina de Iniciar Session*/

$idCliente="";
$nombreCliente="";
$apellidosCliente="";
$usuarioCliente=(string)$_REQUEST["usuarioCliente"];
$contrasennaCliente=(string)$_REQUEST["contrasennaCliente"];

/* Consultar que el usuario y contrasenna estan en la BDD */
$resultados= DAO::obtenerClienteConUsuario($usuarioCliente);

/*---- Si se ha marcado "Recuerdame" generamos cookie----*/
if(isset($_POST["recordar"])){
    DAO::marcarSesionComoIniciada($resultados);
    DAO::generarCookieRecordar($resultados);
    redireccionar("ComicListado.php");
}
/* SI hay un solo resultado---> Inicio session correcto */
if(count($resultados)==1 && password_verify($contrasennaCliente,$resultados[0]["contrasennaCliente"])){
    $idCliente=(int)$resultados[0]["idCliente"];
    $usuarioCliente=(string)$resultados[0]["usuarioCliente"];
    $nombreCliente=(string)$resultados[0]["nombreCliente"];
    $apellidosCliente=(string)$resultados[0]["apellidosCliente"];
    /*--- funcion abajo tmbn redericiona ---*/
    DAO::marcarSesionComoIniciada($resultados);
    redireccionar("ComicListado.php");
}else{
    $_SESSION["txto"]="El usuario o la contraseña no son correctos";
    redireccionar("SessionInicioFormulario.php");
}