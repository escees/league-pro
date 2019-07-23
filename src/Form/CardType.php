<?php

namespace App\Form;

use App\Entity\Card;
use App\Entity\Player;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add(
            'player',
            EntityType::class,
            [
                'class' => Player::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control'
                ],
            ]
        );

        $builder->add(
            'minute',
            NumberType::class,
            [
                'attr' => [
                    'class' => 'form-control'
                ],
            ]
        );


        $builder->add(
            'color',
            ChoiceType::class,
            [
                'choices' => ['Żółta' => 'yellow', 'Czerwona' => 'red'],
                'attr' => [
                    'class' => 'form-control'
                ],
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' =>  Card::class
        ]);
    }
}
