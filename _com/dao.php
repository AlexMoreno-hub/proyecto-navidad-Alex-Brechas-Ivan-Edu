<?php

require_once "_varios.php";
require_once "clases.php";


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

    private static function categoriaCrearDesdeRs(array $fila): categoria
    {
        return new categoria($fila["id"], $fila["nombre"]);
    }


    public static function categoriaCrear($nombre): bool
    {
        $consulta = self::ejecutarActualizacion("INSERT INTO categoria (nombre) VALUES (?);", [$nombre]);
        return $consulta;
    }


    public static function categoriaModificar($nombre, $id): bool
    {
        $consulta = self::ejecutarActualizacion("UPDATE categoria SET nombre=? WHERE id=?;", [$id, $nombre]);
        return $consulta;
    }



    public static function categoriaObtenerPorId(int $id): ?categoria
    {
        $rs = self::ejecutarConsultaObtener(
            "SELECT * FROM categoria WHERE id=?",
            [$id]
        );
        if ($rs) return self::categoriaCrearDesdeRs($rs[0]);
        else return null;
    }


    public static function categoriaObtenerTodas(): array
    {
        $datos = [];

        $rs = self::ejecutarConsulta(
            "SELECT * FROM categoria ORDER BY nombre",
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

    /* JUGADOR */

    public static function jugadorObtenerPorId(int $jugadorId): ?jugador
    {
        $rs = self::ejecutarConsultaObtener(
            "SELECT * FROM jugador WHERE jugadorId=?",
            [$jugadorId]
        );
        if ($rs) return self::jugadorCrearDesdeRs1($rs[0]);
        else return null;
    }

    public static function jugadorSelectCategoria(): array
    {
        $rs = self::ejecutarConsulta(
            "SELECT id, nombre FROM categoria order by nombre",
            []
        );
        return $rs;
    }

    public static function jugadorSelectEquipo(): array
    {
        $rs = self::ejecutarConsulta(
            "SELECT id, nombre FROM equipo order by nombre",
            []
        );
        return $rs;
    }


    public static function jugadorEliminar(int $id): ?int
    {
        $resultado = self::ejecutarActualizacion(
            "DELETE FROM Jugador WHERE jugadorId=?",
            [$id]
        );

        return $resultado;
    }


    /* EQUIPO */

    public static function equipoCrear($nombre): bool
    {
        $consulta = self::ejecutarActualizacion("INSERT INTO equipo (nombre) VALUES (?);", [$nombre]);
        return $consulta;
    }

    public static function jugadorCrear($nombre,$apellidos,$dorsal,$lesionado,$categoriaId,$equipoId): bool
    {

        $consulta = self::ejecutarActualizacion("INSERT INTO jugador (nombre,apellidos,dorsal,lesionado,categoriaId,equipoId) VALUES (?,?,?,?,?,?);",
            [$nombre,$apellidos,$dorsal,$lesionado,$categoriaId,$equipoId]);

        return $consulta;
    }



    public static function equipoModificar($nombre, $id): bool
    {
        $consulta = self::ejecutarActualizacion("UPDATE equipo SET nombre=? WHERE id=?;",
            [$id, $nombre]);
        return $consulta;
    }


    public static function jugadorModificar($nombre,$apellidos,$dorsal,$lesionado,$categoriaId,$equipoId,$jugadorId): bool
    {
        $consulta = self::ejecutarActualizacion("UPDATE jugador SET nombre=?, apellidos=?, dorsal=? , lesionado=?,categoriaId=?,equipoId=? WHERE jugadorId=?;",
            [$nombre,$apellidos,$dorsal,$lesionado,$categoriaId,$equipoId,$jugadorId]);
        return $consulta;
    }


    public static function jugadorCrearDesdeRs(array $fila): jugador
    {
        return new jugador($fila["pId"], $fila["pNombre"],$fila["pApellidos"],$fila["pDorsal"],$fila["pLesionado"],$fila["cId"],$fila["eId"]);
    }

    private static function equipoCrearDesdeRs(array $fila): equipo
    {
        return new Equipo($fila["id"], $fila["nombre"]);
    }

    public static function EquipoObtenerPorId(int $id): ?equipo
    {
        $rs = self::ejecutarConsultaObtener(
            "SELECT * FROM equipo WHERE id=?",
            [$id]
        );
        if ($rs) return self::equipoCrearDesdeRs($rs[0]);
        else return null;
    }

    /*
    public static function jugadorObtenerTodos(): array
    {
        $datos = [];

        $rs = self::ejecutarConsulta(
            "SELECT
                    p.id     AS pId,
                    p.nombre AS pNombre,
                    p.apellidos AS pApellidos,
                    p.dorsal AS pDorsal,
                    p.lesionado AS pLesionado,
                    c.id     AS cId,
                    c.nombre AS cNombre,
                    e.id AS eId,
                    e.nombre AS eNombre
                FROM
                   jugador AS p INNER JOIN categoria AS c
                   ON p.categoriaId = c.id
                   INNER JOIN equipo AS e ON p.equipoId = e.id
                ORDER BY p.nombre",
            []
        );

        foreach ($rs as $fila) {
            $jugador = self::jugadorCrearDesdeRs($fila);
            array_push($datos, $jugador);
        }

        return $datos;
    }*/

    /*
$conexion = obtenerPdoConexionBD();

$mostrarLesionado = isset($_REQUEST["soloLesionado"]);

session_start(); // Crear post-it vacío, o recuperar el que ya haya  (vacío o con cosas).
if (isset($_REQUEST["soloLesionado"])) {
    $_SESSION["soloLesionado"] = true;
}
if (isset($_REQUEST["todos"])) {
    unset($_SESSION["soloLesionado"]);
}

$posibleClausulaWhere = $mostrarLesionado ? "WHERE p.lesionado=1" : "";
*/

    public static function jugadorObtenerTodos(): array
    {

        $mostrarLesionado = isset($_REQUEST["soloLesionado"]);

        session_start(); // Crear post-it vacío, o recuperar el que ya haya  (vacío o con cosas).
        if (isset($_REQUEST["soloLesionado"])) {
            $_SESSION["soloLesionado"] = true;
        }
        if (isset($_REQUEST["todos"])) {
            unset($_SESSION["soloLesionado"]);
        }

        $posibleClausulaWhere = $mostrarLesionado ? "WHERE p.lesionado=1" : "";
        $datos = [];

        $rs = self::ejecutarConsulta(
            "SELECT
                    p.jugadorId     AS pId,
                    p.nombre AS pNombre,
                    p.apellidos AS pApellidos,
                    p.dorsal AS pDorsal,
                    p.lesionado AS pLesionado,
                    c.id     AS cId,
                    c.nombre AS cNombre,
                    e.id AS eId,
                    e.nombre AS eNombre
                FROM
                   jugador AS p INNER JOIN categoria AS c
                   ON p.categoriaId = c.id
                   INNER JOIN equipo AS e ON p.equipoId = e.id
                   $posibleClausulaWhere
                ORDER BY p.nombre",
            []
        );

        foreach ($rs as $fila) {
            $jugador = self::jugadorCrearDesdeRs($fila);
            array_push($datos, $jugador);
        }

        return $datos;
    }


    public static function equipoObtenerTodos(): array
    {
        $datos = [];

        $rs = self::ejecutarConsulta(
            "SELECT id, nombre FROM equipo ORDER BY nombre",
            []
        );

        foreach ($rs as $fila) {
            $equipo = self::equipoCrearDesdeRs($fila);
            array_push($datos, $equipo);
        }

        return $datos;
    }


    public static function equipoEliminar(int $id): ?int
    {
        $resultado = self::ejecutarActualizacion(
            "DELETE FROM equipo WHERE id=?",
            [$id]
        );

        return $resultado;
    }



    public static function ejecutarConsultaObtener(string $sql, array $parametros): ?array
    {
        if (!isset(DAO::$pdo)) DAO::$pdo = DAO::obtenerPdoConexionBd();

        $sentencia = DAO::$pdo->prepare($sql);
        $sentencia->execute($parametros);
        $resultado = $sentencia->fetchAll();
        return $resultado;
    }





    /*public static function categoriaActualizar($id, $nombre)
    {
        self::ejecutarActualizacion(
            "UPDATE Categoria SET nombre=? WHERE id=?",
            [$nombre, $id]
        );
    }*/

    /////JUGADOR////


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


    public static function mostrarJugadores($id)
    {

        return   $rs = self::ejecutarConsultaMostrar(
            "SELECT * FROM jugador WHERE categoriaId=? ORDER BY nombre",
            [$id]
        );

    }

public static function mostrarJugadoresEquipo($id)
{

    return   $rs = self::ejecutarConsultaMostrar(
        "SELECT * FROM jugador WHERE equipoId=? ORDER BY nombre",
        [$id]
    );

}

    private static function ejecutarConsultaMostrar(string $sql, array $parametros): array
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $select = self::$pdo->prepare($sql);
        $select->execute($parametros);
        $rsJugadoresDelaCategoria = $select->fetchAll();

        foreach ($rsJugadoresDelaCategoria as $fila) {
            echo "<li>$fila[nombre] $fila[apellidos]</li>";
        }
        return $rsJugadoresDelaCategoria;
    }

    private static function jugadorCrearDesdeRs1(array $fila): jugador
    {
        return new jugador($fila["jugadorId"], $fila["nombre"],$fila["apellidos"],$fila["dorsal"],$fila["lesionado"],$fila["categoriaId"],$fila["equipoId"]);
    }


    public function usuarioObtener(string $nombreUsuario, string $contrasenna): array
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM usuario WHERE nombreUsuario = ?  && contrasenna = ?",
            [$nombreUsuario,$contrasenna]);

        /*if ($rs) return  $rs[0];
        else return null;*/
        return  $rs[0];
    }

    public function obtenerUsuarioCreado(string $nombreUsuario): ?array
    {
        $sql = "SELECT * FROM usuario WHERE id = ?;";
        ;
    }

    public function marcarSesionComoIniciada(array $arrayUsuario)
    {
        // TODO Anotar en el post-it todos estos datos:
        $_SESSION["id"] = $arrayUsuario["id"];
        $_SESSION["nombreUsuario"] = $arrayUsuario["nombreUsuario"];
        $_SESSION["contrasenna"] = $arrayUsuario["contrasenna"];
    }

    public function haySesionIniciada(): bool
    {
        // TODO Pendiente hacer la comprobación.

        // Está iniciada si isset($_SESSION["id"])
        return isset($_SESSION["id"]) ? true : false;

    }

    public function cerrarSesion()
    {
        session_destroy();
        setcookie('codigoCookie', "");
        setcookie('nombreUsuario',"");
        unset($_SESSION);
        // TODO session_destroy() y unset de $_SESSION (por si acaso).
    }

    public function borrarCookies()
    {
        setcookie("nombreUsuario", "", time() - 3600); // Tiempo en el pasado, para (pedir) borrar la cookie.
        setcookie("codigoCookie", "", time() - 3600); // Tiempo en el pasado, para (pedir) borrar la cookie.}
    }

    public function establecerSesionCookie(array $arrayUsuario)
    {
        // Creamos un código cookie muy complejo (no necesariamente único).
        $codigoCookie = generarCadenaAleatoria(32); // Random..
        //.
        self::ejecutarActualizacion(
            "UPDATE Usuario SET codigoCookie=? WHERE nombreUsuario=?",
            [$codigoCookie,$arrayUsuario["nombreUsuario"]]
        );

        // Enviamos al cliente, en forma de cookies, el identificador y el codigoCookie:
        setcookie("nombreUsuario", $arrayUsuario["nombreUsuario"], time() + 600);
        setcookie("codigoCookie", $codigoCookie, time() + 600);

    }

    public function destruirSesionRamYCookie()
    {
        session_destroy();
        actualizarCodigoCookieEnBD(Null);
        borrarCookies();
        unset($_SESSION); // Por si acaso
    }

}