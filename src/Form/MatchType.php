<?php

namespace App\Form;

use App\Entity\FootballMatch;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToHtml5LocalDateTimeTransformer;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add(
            'homeTeam',
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
            'awayTeam',
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
            'startDate',
            DateTimeType::class,
            [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy HH:mm',
                'attr' => [
                    'class' => 'form-control datepicker',
                    'autocomplete' => 'off'
                ],
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
//        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class' =>  FootballMatch::class
        ]);
    }
}
