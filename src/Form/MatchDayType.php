<?php

namespace App\Form;

use App\Entity\League;
use App\Entity\MatchDay;
use App\Entity\Season;
use App\Entity\Team;
use App\Repository\LeagueRepository;
use App\Repository\TeamRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatchDayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $matchday = $options['data'];

        $builder->add(
            'name',
            TextType::class,
            [
                'required' => true,
                'label' => 'Nazwa kolejki',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'np Kolejka 10'
                ],
            ]
        );

        $builder->add(
            'startDate',
            DateTimeType::class,
            [
                'required' => true,
                'attr' => [
                    'class' => 'form-control datepicker',
                    'autocomplete' => 'off',
                ],
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'label' => 'Data rozpoczęcia kolejki',
            ]
        );

        $builder->add(
            'endDate',
            DateTimeType::class,
            [
                'required' => true,
                'attr' => [
                    'class' => 'form-control datepicker',
                    'autocomplete' => 'off',
                ],
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'label' => 'Data końca kolejki',
            ]
        );

        $builder->add(
            'season',
            EntityType::class,
            [
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                'class' => Season::class,
                'choice_label' => function (Season $season) {
                    return $season->getLeague()->getName() . ' ' . $season->getName();
                },
                'label' => 'Sezon do którego chcesz przypisać tą kolejkę',
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' =>  MatchDay::class
        ]);
    }
}
