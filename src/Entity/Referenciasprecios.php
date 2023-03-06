<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Ticket;

/**
 * Referenciasprecios
 *
 * @ORM\Table(name="referenciasprecios")
 * @ORM\Entity
 */
class Referenciasprecios
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Referencia", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReferencia;

    /**
     * @var string
     *
     * @ORM\Column(name="TipoTrabajo", type="string", length=230, nullable=false)
     */
    private $tipotrabajo;

    /**
     * @var float
     *
     * @ORM\Column(name="PrecioHora", type="float", precision=10, scale=0, nullable=false)
     */
    private $preciohora;

    /**
     * #[@ORM\OneToMany(targetEntity: Product::class, mappedBy: 'idReferencias')]
     */
    private $ticket;


    public function getIdReferencia(): ?int
    {
        return $this->idReferencia;
    }

    public function getTipotrabajo(): ?string
    {
        return $this->tipotrabajo;
    }

    public function setTipotrabajo(string $tipotrabajo): self
    {
        $this->tipotrabajo = $tipotrabajo;

        return $this;
    }

    public function getPreciohora(): ?float
    {
        return $this->preciohora;
    }

    public function setPreciohora(float $preciohora): self
    {
        $this->preciohora = $preciohora;

        return $this;
    }
     public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

}
