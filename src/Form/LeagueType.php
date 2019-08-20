<?php

namespace App\Form;

use App\Entity\League;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LeagueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $league = $options['data'];

        $builder->add(
            'name',
            TextType::class,
            [
                'required' => true,
                'label' => 'Nazwa ligi',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nazwa ligi'
                ],
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' =>  League::class
        ]);
    }
}
