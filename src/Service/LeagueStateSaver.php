<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\League;
use App\Repository\GoalRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class LeagueStateSaver
{
    private $teamRepository;
    private $serializer;
    private $entityManager;
    private $goalRepository;
    private $canadianPointsCalculator;

    public function __construct(
        TeamRepository $teamRepository,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager,
        GoalRepository $goalRepository,
        CanadianPointsCalculator $canadianPointsCalculator
    ) {
        $this->teamRepository = $teamRepository;
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
        $this->goalRepository = $goalRepository;
        $this->canadianPointsCalculator = $canadianPointsCalculator;
    }

    public function saveStandings(League $league): void
    {
        $teamStandings = $this->teamRepository->getTeamStandingsForLeague($league);

        $league->setMainRoundStandings($this->serializer->serialize($teamStandings, 'json', ['groups' => ['standings']]));
        $teams = $league->getSeasons()->first()->getTeams();
        $bestScorers = $this->goalRepository->getBestScorersForTeams($teams->toArray());
        $bestAssistants = $this->goalRepository->getBestAssistantsForTeams($teams->toArray());

        $statistics = [
            'best_scorers' => $bestScorers,
            'best_assistants' => $bestAssistants,
            'canadian_points' => $this->canadianPointsCalculator->calculate($bestScorers, $bestAssistants)
        ];

        $league->setMainRoundStatistics($this->serializer->serialize($statistics, 'json', ['groups' => ['standings']]));

        $this->entityManager->persist($league);
        $this->entityManager->flush();
    }
}
