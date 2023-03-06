<?php

use Doctrine\ORM\EntityManagerInterface;


$usuarioCliente= $_POST["user"];
$passwordCliente=$_POST["password"];
  echo $usuarioCliente;
  echo $passwordCliente;
    header("Location:ClienteController.php?usuarioCliente=".$_Post['usuarioCliente']);
    header("Location:ClienteController.php?usuarioCliente=".$_Post['passwordCliente']);


?>