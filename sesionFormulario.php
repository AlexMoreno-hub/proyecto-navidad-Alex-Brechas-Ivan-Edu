<?php

require_once "_com/_varios.php";
require_once "_com/dao.php";

if (DAO::haySesionIniciada()) redireccionar("categoriaListado.php");

$datosErroneos = isset($_REQUEST["datosErroneos"]);
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>

<body>

<h1>Iniciar Sesión</h1>
<?php if ($datosErroneos) { ?>
    <p >No se ha podido iniciar sesión con los datos proporcionados. Inténtelo de nuevo.</p>
<?php } ?>
<div>
    <form action='sesionComprobar.php' method='get'>
        <label>Usuario </label>
        <br>
        <input type='text' name='nombreUsuario'>
        <br><br>
        <label>Contraseña </label>
        <br>
        <input type='password' name='contrasenna'>
        <br>
        <label for='recordar'>Recuerdame:</label>
        <input type='checkbox' name='recordar' id='recordar'>
        <br><br>
        <input type='submit' name='iniciarSesion' value='Iniciar Sesión'>
    </form>
</div>
<br><br>
<a href='crearUsuario.php'>Crear un usuario nuevo</a>
<br>
<br><br>



</body>

</html>