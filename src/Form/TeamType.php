<?php

namespace App\Form;

use App\Entity\Team;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class TeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'photoFile',
            VichImageType::class,
            [
                'label' => 'Zdjęcie drużyny',
                'required' => false,
                'allow_delete' => true,
//                'download_label' => 'Zdjęcie lub dowolny obrazek',
                'download_uri' => true,
                'image_uri' => true,
                'attr' => ['class' => 'team-photo']
            ]
        );

        $builder->add(
            'crestFile',
            VichImageType::class,
            [
                'label' => 'Logo drużyny',
                'required' => false,
                'allow_delete' => true,
//                'download_label' => 'Zdjęcie lub dowolny obrazek',
                'download_uri' => true,
                'image_uri' => true,
            ]
        );

        $builder->add(
            'name',
            TextType::class,
            [
                'required' => true,
                'label' => 'Nazwa drużyny',
                'attr' => [
                    'class' => 'form-control',
                ],

            ]
        );

        $builder->add(
            'description',
            TextareaType::class,
            [
                'required' => false,
                'label' => 'Opis drużyny',
                'attr' => [
                    'class' => 'form-control'
                ],
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' =>  Team::class
        ]);
    }
}
