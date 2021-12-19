<?php

namespace App\Form;

use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('marque')
            ->add('matricule')
            ->add('modele')
            ->add('couleur',ColorType::class)
            ->add('desciption')
            ->add('images',FileType::class,[
                'label' => 'Ajouter des images',
                'required' => true,
                'multiple' => true,
                'mapped' => false
            ])
            // ->add('createdAt')
            // ->add('typeOffre')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
