<?php

require_once "_varios.php";

class DAO
{
    private static $pdo = null;

    private static function obtenerPdoConexionBD()
    {
        $servidor = "localhost";
        $identificador = "root";
        $contrasenna = "";
        $bd = "Liga";
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

    private static function ejecutarConsulta(string $sql, array $parametros): array
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $select = self::$pdo->prepare($sql);
        $select->execute($parametros);
        $rs = $select->fetchAll();

        return $rs;
    }

    // Devuelve:
    //   - null: si ha habido un error
    //   - 0, 1 u otro número positivo: OK (no errores) y estas son las filas afectadas.
    private static function ejecutarActualizacion(string $sql, array $parametros): ?int
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $actualizacion = self::$pdo->prepare($sql);
        $sqlConExito = $actualizacion->execute($parametros);

        if (!$sqlConExito) return null;
        else return $actualizacion->rowCount();
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
  /*  public static function iniciarSessionConCookie(): bool
    {
        if (isset($_COOKIE["usuarioCliente"]) && isset($_COOKIE["clave"])) {
            $usuarioCliente = $_COOKIE["usuarioCliente"];
            $codigoCookie = $_COOKIE["clave"];
            $arrayUsuario = DAO::obtenerClienteConUsuario($usuarioCliente); //Obtener usuario con el identificador de la cookie
            // Si hay un usuario con el identificador de la cookie
            // Y ademas coincide el codigoCookie de la BDD y el codigoCookie de la cookie
            if ($arrayUsuario && $arrayUsuario[0]["codigoCookieCliente"] == $codigoCookie) {
                DAO::generarCookieRecordar($arrayUsuario); // Generamos otro codigo y renovamos la cookie
                return true;
            } else {
                DAO::borrarCookieRecordar($arrayUsuario); // Borranos la cookie
                return false;
            }
        } else {
            return false;
        }
    }*/

    public static function iniciarSessionConCookie(): bool
    {
        if (isset($_COOKIE["usuarioCliente"]) && isset($_COOKIE["clave"])) {
            $usuarioCliente = $_COOKIE["usuarioCliente"];
            $codigoCookie = $_COOKIE["clave"];
            $arrayUsuario = DAO::obtenerClienteConUsuario($usuarioCliente); //Obtener usuario con el identificador de la cookie
            // Si hay un usuario con el identificador de la cookie
            // Y ademas coincide el codigoCookie de la BDD y el codigoCookie de la cookie
            if ($arrayUsuario && $arrayUsuario[0]["codigoCookieCliente"] == $codigoCookie) {
                DAO::generarCookieRecordar($arrayUsuario); // Generamos otro codigo y renovamos la cookie
                return true;
            } else {
                DAO::borrarCookieRecordar($arrayUsuario); // Borranos la cookie
                return false;
            }
        } else {
            return false;
        }
    }




    public static function haySesionIniciada(): bool
    {
        if (isset($_SESSION["usuarioCliente"])) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


    public static function CerrarSesion()
    {
        // funcion que elimina sesion iniciada
        session_start();
        session_unset();
        session_destroy();
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



    /*NUEVO USUARIO*/


    /*--------------------------- FUNCIONES PARA CLIENTE ------------------------------*/
    public static function obtenerClienteConUsuario(string $usuarioCliente): ?array
    {
        $pdo = DAO::obtenerPdoConexionBD();
        $sql = "SELECT * FROM cliente WHERE usuarioCliente='$usuarioCliente' ";
        $select = $pdo->prepare($sql);
        $select->execute([]);
        $resultados = $select->fetchAll();
        return $resultados;
    }




    /* CATEGORÍA */

    private static function categoriaCrearDesdeRs(array $fila): Categoria
    {
        return new Categoria($fila["id"], $fila["nombre"]);
    }

    public static function categoriaObtenerPorId(int $id): ?Categoria
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Categoria WHERE id=?",
            [$id]
        );
        if ($rs) return self::crearCategoriaDesdeRs($rs[0]);
        else return null;
    }


    public static function categoriaActualizar($id, $nombre)
    {
        self::ejecutarActualizacion(
            "UPDATE Categoria SET nombre=? WHERE id=?",
            [$nombre, $id]
        );
    }

    public static function categoriaCrear(string $nombre)
    {
        $resultado = self::ejecutarActualizacion(
            "INSERT INTO Categoria (nombre) VALUES (?)",
            [$nombre]
        );
        return $resultado;
    }

    public static function categoriaObtenerTodas(): array
    {
        $datos = [];

        $rs = self::ejecutarConsulta(
            "SELECT * FROM Categoria ORDER BY nombre",
            []
        );

        foreach ($rs as $fila) {
            $categoria = self::categoriaCrearDesdeRs($fila);
            array_push($datos, $categoria);
        }

        return $datos;
    }

    public static function categoriaEliminar(int $id): ?int
    {
        $resultado = self::ejecutarActualizacion(
            "DELETE FROM Categoria WHERE id=?",
            [$id]
        );

        return $resultado;
    }




    ///////JUGADOR/////////
    public static function jugadorEliminar(int $id): ?int
    {
        $resultado = self::ejecutarActualizacion(
            "DELETE FROM Jugador WHERE id=?",
            [$id]
        );

        return $resultado;
    }

    /////EQUIPO//////

    public static function equipoEliminar(int $id): ?int
    {
        $resultado = self::ejecutarActualizacion(
            "DELETE FROM equipo WHERE id=?",
            [$id]
        );

        return $resultado;
    }

    public static function agregarCategoria($id, $nombre)
    {
        self::ejecutarActualizacion("INSERT INTO categoria (id, nombre)
            VALUES (?, ?);",
            [$id,$nombre]);
    }

    public static function agregarEquipo($id, $nombre)
    {
        self::ejecutarActualizacion("INSERT INTO equipo (id, nombre)
            VALUES (?, ?);",
            [$id,$nombre]);
    }

    public static function agregarJugador($nombre, $apellidos, $dorsal, $lesionado, $categoriaId, $equipoId)
    {
        self::ejecutarActualizacion("INSERT INTO jugador (nombre, apellidos, dorsal,lesionado,categoriaId,equipoId)
            VALUES (?, ?, ?, ?, ?, ?);",
            [$nombre, $apellidos, $dorsal, $lesionado, $categoriaId, $equipoId]);
    }

    public static function modificarJugador($nombre, $apellidos, $dorsal, $lesionado, $categoriaId, $equipoId)
    {
        self::ejecutarActualizacion("UPDATE jugador SET nombre=?, apellidos=?, dorsal=?, lesionado=?, categoriaId=? , equipoId=? WHERE id=?)
            VALUES (?, ?, ?, ?, ?, ?);",
            [$nombre, $apellidos, $dorsal, $lesionado, $categoriaId, $equipoId]);
    }

}