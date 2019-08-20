<?php

namespace App\Form;

use App\Entity\League;
use App\Entity\Season;
use App\Entity\Team;
use App\Repository\LeagueRepository;
use App\Repository\TeamRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SeasonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $season = $options['data'];

        $builder->add(
            'name',
            TextType::class,
            [
                'required' => true,
                'label' => 'Nazwa sezonu',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'np Jesień 2019'
                ],
            ]
        );

        $builder->add(
            'teams',
            EntityType::class,
            [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
                'class' => Team::class,
                'query_builder' => function (TeamRepository $teamRepository) use ($season)  {
                    if ($season->getId()) {
                        return $teamRepository->createQueryBuilder('t')
                            ->where('t IN (:teams)')
                            ->orWhere('t.season IS NULL')
                            ->setParameter('teams', $season->getTeams());
                    }

                    return $teamRepository->createQueryBuilder('t')
                        ->where('t.season IS NULL');
                },
                'multiple' => true,
                'choice_label' => 'name',
                'label' => 'Wybierz drużyny które będą uczestniczyć w tym sezonie',
                'by_reference' => false,
            ]
        );

        $builder->add(
            'league',
            EntityType::class,
            [
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                'class' => League::class,
                'query_builder' => function (LeagueRepository $leagueRepository) {
                    return $leagueRepository->createQueryBuilder('l');
                },
                'multiple' => false,
                'choice_label' => 'name',
                'label' => 'Wybierz ligę dla tego sezonu',
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' =>  Season::class
        ]);
    }
}
