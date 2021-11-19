<?php

namespace App\EventListener;

use App\Event\LeagueProEvents;
use App\Event\MatchResultAddedEvent;
use App\Service\GoalsCounter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MatchResultEventListener implements EventSubscriberInterface
{
    private $entityManager;
    private $goalsUpdater;

    public function __construct(EntityManagerInterface $entityManager, GoalsCounter $goalsUpdater)
    {
        $this->entityManager = $entityManager;
        $this->goalsUpdater = $goalsUpdater;
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

        if ($homeTeamGoals > $awayTeamGoals) {
            $match->setWinner($homeTeam);
            $match->setLoser($awayTeam);
        }

        if ($homeTeamGoals < $awayTeamGoals) {
            $match->setWinner($awayTeam);
            $match->setLoser($homeTeam);
        }

        if ($homeTeamGoals === $awayTeamGoals) {
            $match->addDrawer($homeTeam);
            $match->addDrawer($awayTeam);
        }

        $this->entityManager->persist($homeTeam);
        $this->entityManager->persist($awayTeam);
        $this->entityManager->persist($match);

        $this->entityManager->flush();

        $homeTeam->setGoalsScored($this->goalsUpdater->countGoalsScored($homeTeam));
        $awayTeam->setGoalsScored($this->goalsUpdater->countGoalsScored($awayTeam));
        $homeTeam->setGoalsConceded($this->goalsUpdater->countGoalsConceded($homeTeam));
        $awayTeam->setGoalsConceded($this->goalsUpdater->countGoalsConceded($awayTeam));

        $this->entityManager->flush();
    }
}
