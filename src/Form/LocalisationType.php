<?php

namespace AcMarche\EnquetePublique\Form;

use AcMarche\EnquetePublique\Location\LocationAbleInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocalisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'latitude',
                TextType::class,
                [
                    'attr' => ['placeholder' => 'latitude'],
                ]
            )
            ->add(
                'longitude',
                TextType::class,
                [
                    'attr' => ['placeholder' => 'longitude'],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            ['data_class' => LocationAbleInterface::class]
        );
    }
}
