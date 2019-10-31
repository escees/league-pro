<?php

namespace App\Form;

use App\Entity\Card;
use App\Entity\FootballMatch;
use App\Entity\Goal;
use App\Entity\MatchDetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatchStartDateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->remove('homeTeam');
        $builder->remove('awayTeam');
        $builder->remove('matchDay');
    }

    public function getParent()
    {
        return MatchType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FootballMatch::class
        ]);
    }
}
