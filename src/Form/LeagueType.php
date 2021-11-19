<?php

namespace App\Form;

use App\Entity\League;
use App\Repository\LeagueRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LeagueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $league = $options['data'];

        $builder->add(
            'name',
            TextType::class,
            [
                'required' => true,
                'label' => 'Nazwa ligi',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nazwa ligi'
                ],
            ]
        );

//        $builder->add(
//            'isPlayOff',
//            CheckboxType::class,
//            [
//                'required' => false,
//                'label' => 'Czy to są play off\'y?',
//                'attr' => [
//                    'class' => 'form-control form-inline',
//                ],
//            ]
//        );
//
//        $builder->add(
//            'playOffLeague',
//            EntityType::class,
//            [
//                'required' => false,
//                'class' => League::class,
//                'choice_label' => function (League $league) {
//                    return $league->getName();
//                },
//                'query_builder' => function (LeagueRepository $leagueRepository) use ($league) {
//                    return $leagueRepository->getLeaguesToChooseForPlayoffs($league);
//                },
//                'attr' => [
//                    'class' => 'form-control',
//                ],
//                'label' => 'Wybierz ligę dla której są to play off\'y',
//                'placeholder' => ''
//            ]
//        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' =>  League::class
        ]);
    }
}
