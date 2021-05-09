<?php

namespace App\Form;

use App\Entity\Team;
use App\Model\PlayerImport;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerImportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'playerFile',
            FileType::class,
            [
                'mapped' => false,
                'label' => 'Plik CSV z zawodnikami'
            ]
        );

        $builder->add(
            'team',
            EntityType::class,
            [
                'label' => false,
                'required' => true,
                'class' => Team::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control'
                ],
                'placeholder' => 'Wybierz drużynę dla zawodników'
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null
        ]);
    }
}
