<?php
//
abstract class Dato
{
}

trait Identificable
{
    protected int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}

class categoria extends Dato
{
    use Identificable;

    private string $nombreCategoria;

    public function __construct(int $id, string $nombreCategoria)
    {
        $this->setId($id);
        $this->setNombreCategoria($nombreCategoria);
    }

    public function getNombreCategoria(): string
    {
        return $this->nombreCategoria;
    }

    public function setNombreCategoria(string $nombre)
    {
        $this->nombreCategoria = $nombre;
    }


}

class equipo extends Dato
{
    use Identificable;

    private string $nombreEquipo;

    public function __construct(int $id, string $nombreEquipo)
    {
        $this->setId($id);
        $this->setNombreEquipo($nombreEquipo);
    }

    public function getNombreEquipo(): string
    {
        return $this->nombreEquipo;
    }

    public function setNombreEquipo(string $nombre)
    {
        $this->nombreEquipo = $nombre;
    }


}


class jugador extends Dato
{
    use Identificable;

    private string $nombreJugador;
    private string $jugadorApellidos;
    private int $jugadorDorsal;
    private bool $jugadorLesioando;
    private int $jugadorCategoriaId;
    private int $jugadorEquipoId;

    public function __construct(int $jugadorId, string $nombreJugador, string  $jugadorApellidos, int $jugadorDorsal, bool $jugadorLesioando , int $jugadorCategoriaId , int $jugadorEquipoId)
    {
        $this->setId($jugadorId);
        $this->setNombreJugador($nombreJugador);
        $this->setJugadorApellidos($jugadorApellidos);
        $this->setJugadorDorsal($jugadorDorsal);
        $this->setJugadorLesioando($jugadorLesioando);
        $this->setJugadorCategoriaId($jugadorCategoriaId);
        $this->setJugadorEquipoId($jugadorEquipoId);
    }

    public function getNombreJugador(): string
    {
        return $this->nombreJugador;
    }

    public function setNombreJugador(string $nombre)
    {
        $this->nombreJugador = $nombre;
    }

    public function getJugadorApellidos(): string
    {
        return $this->jugadorApellidos;
    }

    public function setJugadorApellidos(string $jugadorApellidos)
    {
        $this->jugadorApellidos = $jugadorApellidos;
    }

    public function getJugadorDorsal(): int
    {
        return $this->jugadorDorsal;
    }

    public function setJugadorDorsal(int $jugadorDorsal)
    {
        $this->jugadorDorsal = $jugadorDorsal;
    }

    public function getJugadorLesioando(): bool
    {
        return $this->jugadorLesioando;
    }

    public function setJugadorLesioando(bool $jugadorLesioando)
    {
        $this->jugadorLesioando = $jugadorLesioando;
    }

    public function getJugadorCategoriaId(): int
    {
        return $this->jugadorCategoriaId;
    }

    public function setJugadorCategoriaId(int $jugadorCategoriaId)
    {
        $this->jugadorCategoriaId = $jugadorCategoriaId;
    }

    public function getJugadorEquipoId(): int
    {
        return $this->jugadorEquipoId;
    }

    public function setJugadorEquipoId(int $jugadorEquipoId)
    {
        $this->jugadorEquipoId = $jugadorEquipoId;
    }

}

class Usuario extends Dato
{
    use Identificable;

    private string $identificador;

    private string $nombre;

    private string $apellidos;

    private string $email;

    private string $contrasenna;

    private string $fotoPerfil;

    public function __construct(int $id, string $nombreUsuario,  string $contrasenna)
    {
        $this->setId($id);
        $this->setnombreUsuario($nombreUsuario);
        $this->setContrasenna($contrasenna);
    }



    public function getnombreUsuario(): string
    {
        return $this->nombreUsuario;
    }

    public function setnombreUsuario(string $nombreUsuario)
    {
        $this->nombreUsuario = $nombreUsuario;
    }

    public function getContrasenna(): string
    {
        return $this->contrasenna;
    }

    public function setContrasenna(string $contrasenna)
    {
        $this->contrasenna = $contrasenna;
    }


}


