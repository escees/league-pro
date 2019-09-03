<?php

namespace App\Form;

use App\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'title',
            TextType::class,
            [
                'required' => true,
                'label' => 'Tytuł',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Tytuł'
                ],

            ]
        );

        $builder->add(
            'text',
            TextareaType::class,
            [
                'required' => false,
                'label' => 'Treść newsa',
                'attr' => [
                    'class' => 'form-control tinymce'
                ],
            ]
        );

        $builder->add(
            'photoFile',
            VichImageType::class,
            [
                'label' => 'Zdjęcie dla newsa',
                'required' => false,
                'allow_delete' => true,
//                'download_label' => 'Zdjęcie lub dowolny obrazek',
                'download_uri' => true,
                'image_uri' => true,
            ]
        );

        $builder->add(
            'video',
            TextType::class,
            [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Link do video'
                ],
            ]
        );

        $builder->add(
            'published',
            CheckboxType::class,
            [
                'required' => false,
                'label' => 'Opublikować?',
                'label_attr' => [
                    'class' => ''
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' =>  News::class
        ]);
    }
}
