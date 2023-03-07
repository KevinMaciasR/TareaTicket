<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
date_default_timezone_set("America/Bogota");
/**
 * Ticket
 *
 * @ORM\Table(name="ticket", indexes={@ORM\Index(name="Id_Cliente", columns={"Id_Cliente"})})
 * @ORM\Entity
 */
class Ticket
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Ticket", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTicket;

    /**
     * @var int
     * #[@ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'ticket')]
     * @ORM\Column(name="Id_Cliente", type="integer", nullable=false)
     */
    private $idCliente;

    
    /**
     * @var int
     * #[@ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'ticket')]
     * @ORM\Column(name="Id_Referenciasprecios", type="integer", nullable=false)
     */
    private $idReferencia;

    /**
     * @var bool
     *
     * @ORM\Column(name="Activo", type="boolean", nullable=false)
     */
    private $activo;

    /**
     * @var ?\DateTime
     *
     * @ORM\Column(name="Fecha", type="datetime", nullable=false)
     */
    private $fecha;
    


    public function __construct($idCliente, $idReferencia)
    {   $this->idCliente=$idCliente;
        $this->idReferencia=$idReferencia;
        $this->activo= true;
        $this->fecha=new \DateTime();;
        
    }

    public function getIdTicket(): ?int
    {
        return $this->idTicket;
    }

    public function getIdCliente(): ?int
    {
        return $this->idCliente;
    }

    public function setIdCliente(int $idCliente): self
    {
        $this->idCliente = $idCliente;

        return $this;
    }

    public function isActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha( \DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }
    public function getIdReferencia(): ?int
    {
        return $this->idReferencia;
    }


}
?>