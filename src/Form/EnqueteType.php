<?php

namespace AcMarche\EnquetePublique\Form;

use AcMarche\EnquetePublique\Entity\CategorieWp;
use AcMarche\EnquetePublique\Entity\Enquete;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class EnqueteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intitule')
            ->add(
                'description',
                TextareaType::class,
                [
                    'attr' => ['rows' => 5],
                    'required' => false,
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
                    'required' => false,
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
                    'required' => false,
                ]
            )
            ->add(
                'categorie_wp',
                EntityType::class,
                [
                    'class' => CategorieWp::class,
                    'required' => true,
                    'label' => 'Catégorie du site marche.be',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => Enquete::class,
            ]
        );
    }
}
