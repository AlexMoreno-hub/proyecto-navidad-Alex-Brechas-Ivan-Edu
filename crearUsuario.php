<?php
//formulario para la creación del usuario en caso de que no exista
require_once "_com/_varios.php";
require_once "_com/dao.php";

?>

<html>

<head>
    <meta charset='UTF-8'>
</head>

<body>

<h1>Crear Usuario</h1>
<div>
    <form action='sesionComprobar.php' method='get'>
        <p>Usuario: <input type='text' name='nombreUsuario' /></p>
        <p>Contraseña: <input type='password' name='contrasenna' /></p>
        <input type='submit' name='boton' value="Enviar" />
    </form>
</div>
<br>
<a href='sesionFormulario.php'>Ya estoy registrado</a>

</body>

</html>