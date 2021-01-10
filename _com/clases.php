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

class Categoria extends Dato
{
    use Identificable;

    private string $categoriaNombre;

    public function __construct(int $id, string $categoriaNombre)
    {
        $this->setId($id);
        $this->setCategoriaNombre($categoriaNombre);

    }

    public function getNombre(): string
    {
        return $this->categoriaNombre;
    }

    public function setCategoriaNombre(string $categoriaNombre)
    {
        $this->nombre = $categoriaNombre;
    }

}


class Equipo extends Dato
{
    use Identificable;

    private string $equipoNombre;


    public function __construct(int $id, string $equipoNombre)
    {
        $this->setId($id);
        $this->setNombre($equipoNombre);
    }

    public function getNombre(): string
    {
        return $this->equipoNombre;
    }

    public function setNombre(string $equipoNombre)
    {
        $this->nombre = $equipoNombre;
    }



}
class Jugador extends Dato
{
    use Identificable;

    private string $jugadorNombre;
    private string $jugadorApellidos;
    private int $jugadorDorsal;
    private string $jugadorEquipo;
    private bool $jugadorLesioando;
    private int $jugadorCategoriaId;
    private int $jugadorEquipoId;

    public function __construct(int $idJugador, string $jugadorNombre, string $jugadorApellidos, int $jugadorDorsal, string $jugadorEquipo, bool $jugadorLesioando, int $jugadorCategoriaId, int $jugadorEquipoId)
    {
        $this->setId($idJugador);
        $this->setJugadorNombre($jugadorNombre);
        $this->setJugadorApellidos($jugadorApellidos);
        $this->setJugadorDorsal($jugadorDorsal);
        $this->setJugadorEquipo($jugadorEquipo);
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

    public function getJugadorEquipo(): string
    {
        return $this->jugadorEquipo;
    }

    public function setJugadorEquipo(string $jugadorEquipo)
    {
        $this->jugadorEquipo = $jugadorEquipo;
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

