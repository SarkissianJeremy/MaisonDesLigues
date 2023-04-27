<?php

namespace App\Form;

use App\Entity\Inscription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Atelier;
use App\Entity\Restauration;
use App\Entity\Chambre;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ateliers', EntityType::class, array(
                'class' => Atelier::class,
                'multiple' => true,
                'expanded' => true,
            ))
            ->add('Restauration', EntityType::class, array(
                'class' => Restauration::class,
                'multiple' => true,
                'expanded' => true,
            ))
            ->add('Chambres', EntityType::class, array(
                'class' => Chambre::class,
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'placeholder' => 'Aucun'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
