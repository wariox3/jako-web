<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JuegoRepository")
 */
class Juego
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="codigo_juego_pk",type="integer")
     */
    private $codigoJuegoPk;

    /**
     * @ORM\Column(name="fecha" , type="datetime")
     */
    private $fecha;

    /**
     * @ORM\Column(name="nombre", type="string",length=100, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="jugadores", type="integer", nullable=true, options={"default" : 0})
     */
    private $jugadores = 0;

    /**
     * @ORM\Column(name="jugadores_confirmados", type="integer", nullable=true, options={"default" : 0})
     */
    private $jugadoresConfirmados = 0;

    /**
     * @ORM\Column(name="latitud", type="float", nullable=true, options={"default" : 0})
     */
    private $latitud = 0;

    /**
     * @ORM\Column(name="longitud", type="float", nullable=true, options={"default" : 0})
     */
    private $longitud = 0;

    /**
     * @ORM\Column(name="codigo_jugador_fk", type="integer")
     */
    private $codigoJugadorFk;

    /**
     * @ORM\Column(name="acceso", type="string",length=10, nullable=true)
     */
    private $acceso;

    /**
     * @ORM\Column(name="codigo_escenario_fk", type="integer")
     */
    private $codigoEscenarioFk;

    /**
     * @ORM\ManyToOne(targetEntity="Jugador", inversedBy="juegosJugadorRel")
     * @ORM\JoinColumn(name="codigo_jugador_fk", referencedColumnName="codigo_jugador_pk")
     */
    protected $jugadorRel;

    /**
     * @ORM\ManyToOne(targetEntity="Escenario", inversedBy="juegosEscenarioRel")
     * @ORM\JoinColumn(name="codigo_escenario_fk", referencedColumnName="codigo_escenario_pk")
     */
    protected $escenarioRel;

    /**
     * @ORM\OneToMany(targetEntity="JuegoInvitacion", mappedBy="juegoRel")
     */
    protected $juegosInvitacionesJuegoRel;

    /**
     * @ORM\OneToMany(targetEntity="JuegoDetalle", mappedBy="juegoRel")
     */
    protected $juegosDetallesJuegoRel;

    /**
     * @ORM\OneToMany(targetEntity="Comentario", mappedBy="juegoRel")
     */
    protected $comentariosJuegoRel;

    /**
     * @return mixed
     */
    public function getCodigoJuegoPk()
    {
        return $this->codigoJuegoPk;
    }

    /**
     * @param mixed $codigoJuegoPk
     */
    public function setCodigoJuegoPk($codigoJuegoPk): void
    {
        $this->codigoJuegoPk = $codigoJuegoPk;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha): void
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getJugadores()
    {
        return $this->jugadores;
    }

    /**
     * @param mixed $jugadores
     */
    public function setJugadores($jugadores): void
    {
        $this->jugadores = $jugadores;
    }

    /**
     * @return mixed
     */
    public function getJugadoresConfirmados()
    {
        return $this->jugadoresConfirmados;
    }

    /**
     * @param mixed $jugadoresConfirmados
     */
    public function setJugadoresConfirmados($jugadoresConfirmados): void
    {
        $this->jugadoresConfirmados = $jugadoresConfirmados;
    }

    /**
     * @return mixed
     */
    public function getLatitud()
    {
        return $this->latitud;
    }

    /**
     * @param mixed $latitud
     */
    public function setLatitud($latitud): void
    {
        $this->latitud = $latitud;
    }

    /**
     * @return mixed
     */
    public function getLongitud()
    {
        return $this->longitud;
    }

    /**
     * @param mixed $longitud
     */
    public function setLongitud($longitud): void
    {
        $this->longitud = $longitud;
    }

    /**
     * @return mixed
     */
    public function getCodigoJugadorFk()
    {
        return $this->codigoJugadorFk;
    }

    /**
     * @param mixed $codigoJugadorFk
     */
    public function setCodigoJugadorFk($codigoJugadorFk): void
    {
        $this->codigoJugadorFk = $codigoJugadorFk;
    }

    /**
     * @return mixed
     */
    public function getAcceso()
    {
        return $this->acceso;
    }

    /**
     * @param mixed $acceso
     */
    public function setAcceso($acceso): void
    {
        $this->acceso = $acceso;
    }

    /**
     * @return mixed
     */
    public function getCodigoEscenarioFk()
    {
        return $this->codigoEscenarioFk;
    }

    /**
     * @param mixed $codigoEscenarioFk
     */
    public function setCodigoEscenarioFk($codigoEscenarioFk): void
    {
        $this->codigoEscenarioFk = $codigoEscenarioFk;
    }

    /**
     * @return mixed
     */
    public function getJugadorRel()
    {
        return $this->jugadorRel;
    }

    /**
     * @param mixed $jugadorRel
     */
    public function setJugadorRel($jugadorRel): void
    {
        $this->jugadorRel = $jugadorRel;
    }

    /**
     * @return mixed
     */
    public function getEscenarioRel()
    {
        return $this->escenarioRel;
    }

    /**
     * @param mixed $escenarioRel
     */
    public function setEscenarioRel($escenarioRel): void
    {
        $this->escenarioRel = $escenarioRel;
    }

    /**
     * @return mixed
     */
    public function getJuegosInvitacionesJuegoRel()
    {
        return $this->juegosInvitacionesJuegoRel;
    }

    /**
     * @param mixed $juegosInvitacionesJuegoRel
     */
    public function setJuegosInvitacionesJuegoRel($juegosInvitacionesJuegoRel): void
    {
        $this->juegosInvitacionesJuegoRel = $juegosInvitacionesJuegoRel;
    }

    /**
     * @return mixed
     */
    public function getJuegosDetallesJuegoRel()
    {
        return $this->juegosDetallesJuegoRel;
    }

    /**
     * @param mixed $juegosDetallesJuegoRel
     */
    public function setJuegosDetallesJuegoRel($juegosDetallesJuegoRel): void
    {
        $this->juegosDetallesJuegoRel = $juegosDetallesJuegoRel;
    }

    /**
     * @return mixed
     */
    public function getComentariosJuegoRel()
    {
        return $this->comentariosJuegoRel;
    }

    /**
     * @param mixed $comentariosJuegoRel
     */
    public function setComentariosJuegoRel($comentariosJuegoRel): void
    {
        $this->comentariosJuegoRel = $comentariosJuegoRel;
    }



}