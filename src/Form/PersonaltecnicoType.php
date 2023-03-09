<?php

namespace App\Form;

use App\Entity\Personaltecnico;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonaltecnicoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('cedula', IntegerType::class)
            ->add('usuario')
            ->add('clave')
<<<<<<< HEAD
            ->add('correo',EmailType::class)
=======
            ->add('correo')
>>>>>>> 704101e5771c5030c2745d04cfd7e6c29038fcb7
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personaltecnico::class,
        ]);
    }
}
