<?php

namespace App\Form;

use App\Entity\Gerente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Gerente1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('cedula')
            ->add('usuario')
            ->add('clave')
            ->add('correo')
            ->add('rol')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gerente::class,
        ]);
    }
}
