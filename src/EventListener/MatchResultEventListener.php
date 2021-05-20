<?php

namespace App\EventListener;

use App\Event\LeagueProEvents;
use App\Event\MatchResultAddedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MatchResultEventListener implements EventSubscriberInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            LeagueProEvents::MATCH_RESULT_ADDED => 'onResultAdded',
        ];
    }

    public function onResultAdded(MatchResultAddedEvent $matchResultAddedEvent) //@todo try refactor
    {
        $match = $matchResultAddedEvent->getMatch();

        $homeTeam = $match->getHomeTeam();
        $awayTeam = $match->getAwayTeam();
        $matchDetails = $match->getMatchDetails();

        $awayTeamGoals = $matchDetails->getAwayTeamGoals();
        $homeTeamGoals = $matchDetails->getHomeTeamGoals();

        $homeTeam->addGoalsScored($homeTeamGoals);
        $homeTeam->addGoalsConceded($awayTeamGoals);
        $awayTeam->addGoalsScored($awayTeamGoals);
        $awayTeam->addGoalsConceded($homeTeamGoals);

        if ($homeTeamGoals > $awayTeamGoals) {
            $homeTeam->addWin();
            $awayTeam->addLose();
        }

        if ($homeTeamGoals < $awayTeamGoals) {
            $awayTeam->addWin();
            $homeTeam->addLose();
        }

        if ($homeTeamGoals === $awayTeamGoals) {
            $homeTeam->addDraw();
            $awayTeam->addDraw();
        }

        $match->setCompleteStats(true);

        $this->entityManager->persist($homeTeam);
        $this->entityManager->persist($awayTeam);
        $this->entityManager->flush();
    }
}
