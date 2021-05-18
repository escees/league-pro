<?php

namespace App\Form;

use App\Entity\FootballMatch;
use App\Entity\MatchDay;
use App\Entity\Team;
use App\Repository\MatchDayRepository;
use App\Repository\TeamRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'homeTeam',
            EntityType::class,
            [
                'class' => Team::class,
                'choice_label' => 'name',
                'query_builder' => function (TeamRepository $teamRepository) {
                    return $teamRepository->getAllTeamsWithLeague();
                },
                'attr' => [
                    'class' => 'form-control'
                ],
                'placeholder' => 'Wybierz gospodarza'
            ]
        );

        $builder->add(
            'awayTeam',
            EntityType::class,
            [
                'class' => Team::class,
                'choice_label' => 'name',
                'query_builder' => function (TeamRepository $teamRepository) {
                    return $teamRepository->getAllTeamsWithLeague();
                },
                'attr' => [
                    'class' => 'form-control'
                ],
                'placeholder' => 'Wybierz drużynę przyjezdną'
            ]
        );


        $builder->add(
            'startDate',
            DateTimeType::class,
            [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy HH:mm',
                'attr' => [
                    'class' => 'form-control match-datepicker',
                    'autocomplete' => 'off',
                    'placeholder' => 'Data i godzina rozgrywania meczu'
                ],
            ]
        );

        $builder->add(
            'matchDay',
            EntityType::class,
            [
                'class' => MatchDay::class,
                'choice_label' => 'name',
                'group_by' => 'season.name',
                'query_builder' => function (MatchDayRepository $matchDayRepository) {
                    return $matchDayRepository->createQueryBuilder('m');
                },
                'attr' => [
                    'class' => 'form-control'
                ],
                'placeholder' => 'Wybierz kolejkę'
            ]
        );

        $builder->add(
            'arena',
            ChoiceType::class,
            [
                'required' => false,
                'choices' => ['TZN' => 'TZN', 'Dźbów' => 'Dźbów'],
                'placeholder' => 'Wybierze miejsce',
                'attr' => [
                    'class' => 'form-control',
                ],
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' =>  FootballMatch::class
        ]);
    }
}
