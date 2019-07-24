<?php

namespace App\Form;

use App\Entity\Goal;
use App\Entity\Player;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GoalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add(
            'scorer',
            EntityType::class,
            [
                'label' => false,
                'class' => Player::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control goal-type-field'
                ],
                'placeholder' => 'Wybierz strzelca'
            ]
        );

        $builder->add(
            'minute',
            IntegerType::class,
            [
                'label' => false,
                'attr' => [
                    'class' => 'form-control goal-type-field',
                    'placeholder' => 'Minuta strzelonej bramki'

                ],
            ]
        );

        $builder->add(
            'assistant',
            EntityType::class,
            [
                'label' => false,
                'required' => false,
                'class' => Player::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control goal-type-field',
                ],
                'placeholder' => 'Asystent(opcjonalnie)'
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' =>  Goal::class
        ]);
    }
}
