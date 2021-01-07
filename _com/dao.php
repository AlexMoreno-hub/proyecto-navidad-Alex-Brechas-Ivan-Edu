<?php
// TODO: añadir cosas aqui segun necesitamos aqui

require_once "_com/clases.php";
require_once "_com/varios.php";


class DAO
{
    private static $pdo = null;

    private static function obtenerPdoConexionBD(): PDO
    {
        $servidor = "localhost";
        $bd = "Liga.sql";
        $identificador = "root";
        $contrasenna = "";
        $opciones = [
            PDO::ATTR_EMULATE_PREPARES => false, // Modo emulación desactivado para prepared statements "reales"
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Que los errores salgan como excepciones.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // El modo de fetch que queremos por defecto.

        ];

        try {
            $pdo = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
        } catch (Exception $e) {
            error_log("Error al conectar: " . $e->getMessage());
            exit("Error al conectar" . $e->getMessage());
        }

        return $pdo;
    }

    /*---------- Funciones generales ----------*/
    public static function anotarCookieEnBDD($codigoCookie, $idUsuario): bool
    {
        $pdo = DAO::obtenerPdoConexionBD();
        if ($codigoCookie == "NULL") {
            $codigoCookie = NULL;
        }
        $sqlSentencia = "UPDATE cliente SET codigoCookieCliente=? WHERE idCliente=?";

        $sqlUpdate = $pdo->prepare($sqlSentencia);
        $sqlUpdate->execute([$codigoCookie, $idUsuario]);
        if ($sqlUpdate->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }
    public static function iniciarSessionConCookie(): bool
    {
        if(isset($_COOKIE["usuarioCliente"]) && isset($_COOKIE["clave"])){
            $usuarioCliente=$_COOKIE["usuarioCliente"];
            $codigoCookie=$_COOKIE["clave"];
            $arrayUsuario=DAO::obtenerClienteConUsuario($usuarioCliente);//Obtener usuario con el identificador de la cookie
            // Si hay un usuario con el identificador de la cookie
            // Y ademas coincide el codigoCookie de la BDD y el codigoCookie de la cookie
            if( $arrayUsuario && $arrayUsuario[0]["codigoCookieCliente"]==$codigoCookie ){
                DAO::generarCookieRecordar($arrayUsuario);// Generamos otro codigo y renovamos la cookie
                return true;
            }else{
                DAO::borrarCookieRecordar($arrayUsuario);// Borranos la cookie
                return false;
            }
        }else{
            return false;
        }
    }

    public static function haySesionIniciada(): bool{
        if(isset($_SESSION["usuarioCliente"])){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    public static function borrarCookieRecordar(array $arrayUsuario)
    {
        // Eliminar el código cookie de nuestra BD.
        $idCliente = $arrayUsuario["idCliente"];
        DAO::anotarCookieEnBDD("NULL", $idCliente);
        // Pedir borrar cookie (setcookie con tiempo time() - negativo...)
        setcookie("identificador", "", time() - 86400);
        setcookie("clave", "", time() - 86400);
    }
    public static function cerrarSesion()
    {
        //$usuarioCliente=$_SESSION["usuarioCliente"];
        $resultados=DAO::obtenerClienteConUsuario($_SESSION["usuarioCliente"]);
        DAO::borrarCookieRecordar($resultados);
        session_unset();
        session_destroy();
        redireccionar("SessionInicioFormulario.php");
    }
    public static function generarCookieRecordar(array $arrayUsuario)
    {
        // Creamos un código cookie muy complejo (no necesariamente único).
        $codigoCookie = generarCadenaAleatoria(32); // Random...
        $idCliente = $arrayUsuario[0]["idCliente"];
        // actualizar el codigoCookie en la BDD
        DAO::anotarCookieEnBDD($codigoCookie, $idCliente);
        // anotar la cookie en el navegador
        $usuarioCliente = $arrayUsuario[0]["usuarioCliente"];
        $valorCookie = $codigoCookie;
        setcookie("usuarioCliente", $usuarioCliente, time() + 86400);
        setcookie("clave", $valorCookie, time() + 86400);
    }
    public static function marcarSesionComoIniciada($arrayUsuario)
    {
        $_SESSION["idCliente"] = $arrayUsuario[0]["idCliente"];
        $_SESSION["usuarioCliente"] = $arrayUsuario[0]["usuarioCliente"];
        $_SESSION["nombreCliente"] = $arrayUsuario[0]["nombreCliente"];
        $_SESSION["apellidosCliente"] = $arrayUsuario[0]["apellidosCliente"];

    }

    public static function ejecutarConsultaObtener(string $sql, array $parametros): ?array
    {
        if (!isset(DAO::$pdo)) DAO::$pdo = DAO::obtenerPdoConexionBd();

        $sentencia = DAO::$pdo->prepare($sql);
        $sentencia->execute($parametros);
        $resultado = $sentencia->fetchAll();
        return $resultado;
    }
    public static function ejecutarConsultaActualizar(string $sql, array $parametros): int
    {
        if (!isset(DAO::$pdo)) DAO::$pdo = DAO::obtenerPdoConexionBd();

        $sentencia = DAO::$pdo->prepare($sql);
        $sentencia->execute($parametros);
        return $sentencia->rowCount();
    }




}// FIN DE LA CLASSE DAO