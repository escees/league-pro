<?php

namespace App\Form;

use App\Entity\Goal;
use App\Entity\Player;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
                'class' => Player::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control'
                ],
                'placeholder' => 'Wybierz gospodarza'
            ]
        );

        $builder->add(
            'minute',
            EntityType::class,
            [
                'class' => Team::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control'
                ],
            ]
        );

        $builder->add(
            'assistant',
            EntityType::class,
            [
                'class' => Player::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control'
                ],
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
