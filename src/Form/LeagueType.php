<?php

namespace App\Form;

use App\Entity\League;
use App\Entity\Team;
use App\Repository\TeamRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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

        $builder->add(
            'teams',
            EntityType::class,
            [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
                'class' => Team::class,
                'query_builder' => function (TeamRepository $teamRepository) use ($league)  {
                    if ($league->getId()) {
                        return $teamRepository->createQueryBuilder('t')
                            ->where('t IN (:teams)')
                            ->orWhere('t.league IS NULL')
                            ->setParameter('teams', $league->getTeams());
                    }

                    return $teamRepository->createQueryBuilder('t')
                        ->where('t.league IS NULL');
                },
                'multiple' => true,
                'choice_label' => 'name',
                'label' => 'Wybierz drużyny które będą uczestniczyć w lidze',
                'by_reference' => false,
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' =>  League::class
        ]);
    }
}
