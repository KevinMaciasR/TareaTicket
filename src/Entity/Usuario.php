<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\ORM\Mapping as ORM;


class Usuario
{

    private string $usuario;

    private string $clave;

    public function getusuario(): ?string
    {
        return $this->usuario;
    }
    public function getclave(): ?string
    {
        return $this->clave;
    }
    public function setusuario(string $clave): self
    {
        $this->clave = $clave;

        return $this;
    }
    public function setClave(string $clave): self
    {
        $this->clave = $clave;

        return $this;
    }
}
