<?php

namespace App\Form;

use App\Entity\FootballMatch;
use App\Entity\Team;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
                'choice_label' => 'name'
            ]
        );

        $builder->add(
            'awayTeam',
            EntityType::class,
            [
                'class' => Team::class,
                'choice_label' => 'name'
            ]
        );

        $builder->add(
            'startDate',
            DateType::class,
            [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => 'datepicker'
                ]
            ]
        );

        $builder->add(
            'startTime',
            TimeType::class,
            [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => 'datepicker timepicker'
                ]
            ]
        );

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
           $form = $event->getForm();
           $match = $event->getData();
//           dump($match);die;
            $datetime = new \DateTime($form->get('startDate')->getViewData());
            $match['startDate'] = $datetime->format('Y-m-d');
//           dump($match);die;

            $form->get('startDate')->setData(DateTime::createFromFormat('Y-m-d', $match['startDate']));
//            dump();die;
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class' =>  FootballMatch::class
        ]);
    }
}
