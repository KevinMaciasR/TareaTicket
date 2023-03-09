<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personaltecnico
 *
 * @ORM\Table(name="personaltecnico")
 * @ORM\Entity
 */
class Personaltecnico
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Tecnico", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTecnico;

    /**
     * @var string
     *
     * @ORM\Column(name="Nombre", type="string", length=230, nullable=false)
     */
    private $nombre;

    /**
     * @var int
     *
     * @ORM\Column(name="Cedula", type="integer", nullable=false)
     */
    private $cedula;

    /**
     * @var string
     *
     * @ORM\Column(name="Usuario", type="string", length=200, nullable=false)
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="Clave", type="string", length=230, nullable=false)
     */
    private $clave;

    /**
     * @var string
     *
     * @ORM\Column(name="Correo", type="string", length=230, nullable=false)
     */
    private $correo;

    /**
     * @var int
     *
     * @ORM\Column(name="Rol", type="integer", nullable=false)
     */
    private $rol;

    public function getIdTecnico(): ?int
    {
        return $this->idTecnico;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCedula(): ?int
    {
        return $this->cedula;
    }

    public function setCedula(int $cedula): self
    {
        $this->cedula = $cedula;

        return $this;
    }

    public function getUsuario(): ?string
    {
        return $this->usuario;
    }

    public function setUsuario(string $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getClave(): ?string
    {
        return $this->clave;
    }

    public function setClave(string $clave): self
    {
        $this->clave = $clave;

        return $this;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(string $correo): self
    {
        $this->correo = $correo;

        return $this;
    }

    public function getRol(): ?int
    {
        return $this->rol;
    }

    public function setRol(int $rol): self
    {
        $this->rol = $rol;

        return $this;
    }


}
?>