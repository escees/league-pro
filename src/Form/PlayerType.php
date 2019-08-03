<?php

namespace App\Form;

use App\Entity\FootballMatch;
use App\Entity\Player;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            TextType::class,
            [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Imię i nazwisko'
                ],
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
                'placeholder' => 'Wybierz drużynę dla zawodnika'
            ]
        );


        $builder->add(
            'dateOfBirth',
            DateTimeType::class,
            [
                'label' => false,
                'required' => false,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'attr' => [
                    'class' => 'form-control datepicker',
                    'autocomplete' => 'off',
                    'placeholder' => 'Data urodzenia'
                ],
            ]
        );

        $builder->add(
            'position',
            ChoiceType::class,
            [
                'label' => false,
                'required' => false,
                'choices' => ['Bramkarz' => 'goalkeeper', 'Obrońca' => 'defender', 'Pomocnik' => 'midfielder', 'Napastnik' => 'forward'],
                'attr' => [
                    'class' => 'form-control',

                ],
                'placeholder' => 'Pozycja'
            ]
        );

        $builder->add(
            'number',
            IntegerType::class,
            [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Numer'
                ],
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' =>  Player::class
        ]);
    }
}
