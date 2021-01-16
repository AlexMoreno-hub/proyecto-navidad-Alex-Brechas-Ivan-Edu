<?php

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

/*class jugador extends Dato
{
    use Identificable;



    public function __construct(int $idJugador, string $jugadorNombre, string $jugadorApellidos, int $jugadorDorsal, bool $jugadorLesioando, int $jugadorCategoriaId, int $jugadorEquipoId)
    {
        $this->setId($idJugador);
        $this->setJugadorNombre($jugadorNombre);
        $this->setJugadorApellidos($jugadorApellidos);
        $this->setJugadorDorsal($jugadorDorsal);
        $this->setJugadorLesioando($jugadorLesioando);
        $this->setJugadorCategoriaId($jugadorCategoriaId);
        $this->setJugadorEquipoId($jugadorEquipoId);
    }

    public function getNombre(): string
    {
        return $this->jugadorNombre;
    }

    public function setNombre(string $jugadorNombre)
    {
        $this->jugadorNombre = $jugadorNombre;
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
}*/

class Cliente extends Dato
{
    use Identificable;

    private string $nombreCliente;
    private string $apellidosCliente;
    private string $usuarioCliente;
    private string $contrasennaCliente;


    public function __construct(int $id, string $nombreCliente, string $apellidosCliente, string $usuarioCliente, string $contrasennaCliente)
    {
        $this->setId($id);
        $this->setNombre($nombreCliente);
        $this->setApellidos($apellidosCliente);
        $this->usuarioCliente($usuarioCliente);
        $this->setContrasenna($contrasennaCliente);
    }

    public function getNombre(): string
    {
        return $this->nombreCliente;
    }

    public function setNombre(string $nombreCliente)
    {
        $this->nombreCliente = $nombreCliente;
    }

    public function getApellidosCliente(): string
    {
        return $this->apellidosCliente;
    }

    public function setApellidosCliente(string $apellidosCliente)
    {
        $this->apellidosCliente = $apellidosCliente;
    }

    public function getUsuarioCliente(): string
    {
        return $this->usuarioCliente;
    }

    public function setUsuarioCliente(string $usuarioCliente)
    {
        $this->usuarioCliente = $usuarioCliente;
    }

    public function getContrasennaCliente(): string
    {
        return $this->contrasennaCliente;
    }

    public function setContrasennaCliente(string $contrasennaCliente)
    {
        $this->contrasennaCliente = $contrasennaCliente;
    }

}

