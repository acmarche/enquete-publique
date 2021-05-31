<?php

namespace AcMarche\EnquetePublique\Form;

use AcMarche\EnquetePublique\Entity\Categorie;
use AcMarche\EnquetePublique\Entity\Enquete;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class EnqueteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('intitule')
            ->add(
                'categorie',
                EntityType::class,
                [
                    'class' => Categorie::class,
                    'placeholder' => 'Sélectionnez',
                    'label' => 'Objet de la demande',
                ]
            )
            ->add('demandeur')
            ->add(
                'date_debut',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'label' => 'Date de début de diffusion',
                ]
            )
            ->add(
                'date_fin',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'label' => 'Date de fin de diffusion',
                ]
            )
            ->add(
                'avisFile',
                VichFileType::class,
                [
                    'label' => 'Affiche avis',
                    'help' => 'Uniquement pdf ou images',
                    'required' => false,
                ]
            )
            ->add(
                'rue',
                TextType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'numero',
                TextType::class,
                [
                    'required' => false,
                ]
            )
            ->add(
                'code_postal',
                TextType::class,
                [
                    'required' => true,
                ]
            )
            ->add(
                'localite',
                TextType::class,
                [
                    'required' => true,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Enquete::class,
            ]
        );
    }
}
