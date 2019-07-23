<?php

namespace App\Form;

use App\Entity\FootballMatch;
use App\Entity\MatchDetails;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatchResultType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        parent::buildForm($builder, $options);

//        $builder->remove('startDate');
//        $builder->remove('awayTeam');
//        $builder->remove('homeTeam');

        $builder->add(
            'matchDetails',
            MatchDetailsType::class,
            [
                'attr' => [
                    'class' => 'form-control'
                ],
            ]
        );
    }

//    public function getParent()
//    {
//        return MatchType::class;
//    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' =>  FootballMatch::class
        ]);
    }
}
