<?php

namespace App\Form;

use App\Entity\Card;
use App\Entity\Player;
use App\Repository\PlayerRepository;
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

        $homeTeam = $options['home_team'];
        $awayTeam = $options['away_team'];

        $builder->add(
            'player',
            EntityType::class,
            [
                'label' => false,
                'class' => Player::class,
                'choice_label' => function (Player $player) {
                    return $player->getName() . ' nr ' . $player->getNumber();
                },
                'query_builder' => function (PlayerRepository $playerRepository) use ($homeTeam, $awayTeam) {
                    return $playerRepository->findPlayersForTeamsParticipatingInMatchQueryBuilder($homeTeam, $awayTeam);
                } ,
                'attr' => [
                    'class' => 'form-control card-type-field'
                ],
                'placeholder' => 'Wybierz kartkowicza'
            ]
        );

        $builder->add(
            'minute',
            NumberType::class,
            [
                'label' => false,
                'attr' => [
                    'class' => 'form-control card-type-field',
                    'placeholder' => 'Minuta otrzymania kartki'
                ],

            ]
        );


        $builder->add(
            'color',
            ChoiceType::class,
            [
                'label' => false,
                'choices' => ['Żółta' => 'yellow', 'Czerwona' => 'red'],
                'attr' => [
                    'class' => 'form-control card-type-field'
                ],

            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' =>  Card::class,
            'home_team' => null,
            'away_team' => null
        ]);
    }
}
