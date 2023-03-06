<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Factura
 *
 * @ORM\Table(name="factura", indexes={@ORM\Index(name="Id_Cliente", columns={"Id_Cliente"}), @ORM\Index(name="Id_Facturador", columns={"Id_Facturador"})})
 * @ORM\Entity
 */
class Factura
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Factura", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFactura;

    /**
     * @var int
     * ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'factura')
     * @ORM\Column(name="Id_Facturador", type="integer", nullable=false)
     */
    private $idFacturador;

    /**
     * @var int
     * ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'factura')
     * @ORM\Column(name="Id_Cliente", type="integer", nullable=false)
     */
    private $idCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="TipoTrabajo", type="string", length=230, nullable=false)
     */
    private $tipotrabajo;

    /**
     * @var float
     *
     * @ORM\Column(name="Precio", type="float", precision=10, scale=0, nullable=false)
     */
    private $precio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Fecha", type="datetime", nullable=false)
     */
    private $fecha;

    public function getIdFactura(): ?int
    {
        return $this->idFactura;
    }

    public function getIdFacturador(): ?int
    {
        return $this->idFacturador;
    }

    public function setIdFacturador(int $idFacturador): self
    {
        $this->idFacturador = $idFacturador;

        return $this;
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

    public function getTipotrabajo(): ?string
    {
        return $this->tipotrabajo;
    }

    public function setTipotrabajo(string $tipotrabajo): self
    {
        $this->tipotrabajo = $tipotrabajo;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }


}
