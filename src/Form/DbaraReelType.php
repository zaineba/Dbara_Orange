<?php

namespace App\Form;

use App\Entity\DbaraReel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DbaraReelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('video', UrlType::class, [
                'label' => 'URL de la vidéo',
                'attr' => ['placeholder' => 'Entrez l\'URL de la vidéo']
            ])
            ->add('chef');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DbaraReel::class,
        ]);
    }
}
