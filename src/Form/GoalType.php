<?php

namespace App\Form;

use App\Entity\Goal;
use App\Entity\Player;
use App\Repository\PlayerRepository;
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

        $homeTeam = $options['home_team'];
        $awayTeam = $options['away_team'];

        $builder->add(
            'scorer',
            EntityType::class,
            [
                'label' => false,
                'class' => Player::class,
                'choice_label' => function (Player $player) {
                    return $player->getName() . ' nr ' . $player->getNumber();
                },
                'group_by' => 'team',
                'query_builder' => function (PlayerRepository $playerRepository) use ($homeTeam, $awayTeam) {
                    return $playerRepository->findPlayersForTeamsParticipatingInMatchQueryBuilder($homeTeam, $awayTeam);
                } ,
                'attr' => [
                    'class' => 'form-control goal-type-field col'
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
                    'class' => 'form-control goal-type-field col',
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
                'choice_label' => function (Player $player) {
                    return $player->getName() . ' nr ' . $player->getNumber();
                },
                'group_by' => 'team',
                'query_builder' => function (PlayerRepository $playerRepository) use ($homeTeam, $awayTeam) {
                    return $playerRepository->findPlayersForTeamsParticipatingInMatchQueryBuilder($homeTeam, $awayTeam);
                },
                'attr' => [
                    'class' => 'form-control goal-type-field col',
                ],
                'placeholder' => 'Asystent (opcjonalnie)'
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' =>  Goal::class,
            'home_team' => null,
            'away_team' => null
        ]);
    }
}
