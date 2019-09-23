<?php

namespace App\Form;

use App\Entity\FootballMatch;
use App\Entity\ManOfTheMatch;
use App\Entity\MatchDetails;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatchDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        /** @var FootballMatch $match */
        $match = $options['match'];

        $homeTeam = $match instanceof FootballMatch ? $match->getHomeTeam() : null;
        $awayTeam = $match instanceof FootballMatch ? $match->getAwayTeam() : null;

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
                    'home_team' => $homeTeam,
                    'away_team' => $awayTeam
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
                    'home_team' => $homeTeam,
                    'away_team' => $awayTeam
                ],
            ]
        );

        $builder->add(
            'mvp',
            ManOfTheMatchType::class,
            [
                'label' => false,
                'home_team' => $homeTeam,
                'away_team' => $awayTeam
            ]
        );

        $builder->add(
            'homeTeamPenalties',
            NumberType::class,
            [
                'required' => false,
                'attr' => [
                    'class' => 'form-control col-sm-3'
                ],
            ]
        );

        $builder->add(
            'awayTeamPenalties',
            NumberType::class,
            [
                'required' => false,
                'attr' => [
                    'class' => 'form-control col-sm-3'
                ],
            ]
        );

        $builder->add(
            'description',
            TextareaType::class,
            [
                'required' => false,
                'label' => 'Opis meczu',
                'attr' => [
                    'class' => 'form-control tinymce'
                ],
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MatchDetails::class,
            'match' => null
        ]);
    }
}
