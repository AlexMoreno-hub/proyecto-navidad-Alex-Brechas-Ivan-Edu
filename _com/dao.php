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


    /*FUNCIONES PARA CATEGORÍA */

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


/*Obtener la categoria mediante id*/
    public static function categoriaObtenerPorId(int $id): ?categoria
    {
        $rs = self::ejecutarConsultaObtener(
            "SELECT * FROM categoria WHERE id=?",
            [$id]
        );
        if ($rs) return self::categoriaCrearDesdeRs($rs[0]);
        else return null;
    }

/*Obtener todas categorias*/
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


    /*FUNCIONES PARA JUGADOR */

    /*necesario con rs1, sin select tablas*/
    public static function jugadorObtenerPorId(int $jugadorId): ?jugador
    {
        $rs = self::ejecutarConsultaObtener(
            "SELECT * FROM jugador WHERE jugadorId=?",
            [$jugadorId]
        );
        if ($rs) return self::jugadorCrearDesdeRs1($rs[0]);
        else return null;
    }
/*Mostrar el select de categoria al crear/modificar jugador*/
    public static function jugadorSelectCategoria(): array
    {
        $rs = self::ejecutarConsulta(
            "SELECT id, nombre FROM categoria order by nombre",
            []
        );
        return $rs;
    }
    /*Mostrar el select de equipo al crear/modificar jugador*/
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
/*crear nuevo jugador*/
    public static function jugadorCrear($nombre,$apellidos,$dorsal,$lesionado,$categoriaId,$equipoId): bool
    {

        $consulta = self::ejecutarActualizacion("INSERT INTO jugador (nombre,apellidos,dorsal,lesionado,categoriaId,equipoId) VALUES (?,?,?,?,?,?);",
            [$nombre,$apellidos,$dorsal,$lesionado,$categoriaId,$equipoId]);

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

/*Mostrar todos los jugadores para jugador LISTADO*/
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



/*UTILIZADA EN CATEGORIA FICHA*/
    public static function mostrarJugadores($id)
    {

        return   $rs = self::ejecutarConsultaMostrar(
            "SELECT * FROM jugador WHERE categoriaId=? ORDER BY nombre",
            [$id]
        );

    }

    /*UTILIZADA EN JUGADOR FICHA*/
    public static function mostrarJugadoresEquipo($id)
    {

        return   $rs = self::ejecutarConsultaMostrar(
            "SELECT * FROM jugador WHERE equipoId=? ORDER BY nombre",
            [$id]
        );

    }
/*para obtener por id*/
    private static function jugadorCrearDesdeRs1(array $fila): jugador
    {
        return new jugador($fila["jugadorId"], $fila["nombre"],$fila["apellidos"],$fila["dorsal"],$fila["lesionado"],$fila["categoriaId"],$fila["equipoId"]);
    }



    /* FUNCIONES PARA EQUIPO */

    public static function equipoCrear($nombre): bool
    {
        $consulta = self::ejecutarActualizacion("INSERT INTO equipo (nombre) VALUES (?);", [$nombre]);
        return $consulta;
    }


    public static function equipoModificar($nombre, $id): bool
    {
        $consulta = self::ejecutarActualizacion("UPDATE equipo SET nombre=? WHERE id=?;",
            [$id, $nombre]);
        return $consulta;
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
 /*Necesario para mostrar jugadores en equipo y categoria*/

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



    /*FUNCIONES DE SESIONES Y USUARIO*/


    /*Obtener el usuario mediante el nombre y la contraseña, devuelve bien o null (no usuario creado)*/
    public static function usuarioObtener(string $nombreUsuario, string $contrasenna): ? usuario
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM usuario WHERE nombreUsuario=? AND contrasenna =?",
            [$nombreUsuario, $contrasenna]
        );
        if ($rs) return self::usuarioCrearDesdeRS($rs[0]);
        else return null;
    }

    private static function usuarioCrearDesdeRS(array $usuario): usuario
    {
        return new usuario($usuario["id"], $usuario["nombreUsuario"],$usuario["contrasenna"], $usuario["codigoCookie"]);
    }

/*obtenemos los datos del usuario sesion iniciada*/
    public function marcarSesionComoIniciada($usuario)
    {

        $_SESSION["id"] = $usuario->getId();
        $_SESSION["nombreUsuario"] = $usuario->getNombreUsuario();
        $_SESSION["contrasenna"] = $usuario->getContrasenna();
    }

    public function haySesionIniciada(): bool
    {
        return isset($_SESSION["id"]) ? true : false;

    }

    public function cerrarSesion()
    {
        session_destroy();
        setcookie('codigoCookie', "");
        setcookie('nombreUsuario',"");
        unset($_SESSION);

    }
/*metodo no utilizado*/
    public function borrarCookies()
    {
        setcookie("nombreUsuario", "", time() - 3600);
        setcookie("codigoCookie", "", time() - 3600); //borrar cookie en ese tiempo
    }
/*creamos */

    public static function establecerSesionCookie()
    {
        $arrayUsuario = DAO::usuarioObtener($_REQUEST["nombreUsuario"], $_REQUEST["contrasenna"]);
        $codigoCookie = generarCadenaAleatoria(32);

        self::ejecutarConsulta(
            "UPDATE usuario SET codigoCookie=? WHERE nombreUsuario=?",
            [$codigoCookie, $arrayUsuario->getnombreUsuario()]
        );


        $arrayCookies["nombreUsuario"] = setcookie("nombreUsuario", $arrayUsuario->getnombreUsuario(), time() + 60 * 60);
        $arrayCookies["codigoCookie"] = setcookie("codigoCookie", $codigoCookie, time() + 60 * 60);
    }


}