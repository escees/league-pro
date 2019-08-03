<?php

namespace App\Form;

use App\Entity\MatchDetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatchDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add(
            'homeTeamGoals',
            NumberType::class,
            [
                'attr' => [
                    'class' => 'form-control col-sm-3'
                ],
            ]
        );

        $builder->add(
            'awayTeamGoals',
            NumberType::class,
            [
                'attr' => [
                    'class' => 'form-control col-sm-3'
                ],
            ]
        );

        $builder->add(
            'goals',
            CollectionType::class,
            [
                'entry_type' => GoalType::class,
                'attr' => [
                    'class' => 'form-control'
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
                'entry_options' => [
                    'label' => false,
                ],
            ]
        );

        $builder->add(
            'cards',
            CollectionType::class,
            [
                'entry_type' => CardType::class,
                'attr' => [
                    'class' => 'form-control'
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
                'entry_options' => [
                    'label' => false,
                ],
            ]
        );

        $builder->add(
            'homeTeamPenalties',
            NumberType::class,
            [
                'attr' => [
                    'class' => 'form-control col-sm-3'
                ],
            ]
        );

        $builder->add(
            'awayTeamPenalties',
            NumberType::class,
            [
                'attr' => [
                    'class' => 'form-control col-sm-3'
                ],
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MatchDetails::class
        ]);
    }
}
