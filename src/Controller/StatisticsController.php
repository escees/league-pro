<?php

namespace App\Controller;

use App\Entity\League;
use App\Repository\GoalRepository;
use App\Repository\LeagueRepository;
use App\Service\CanadianPointsCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatisticsController extends AbstractController
{
    /**
     * @Route("/statistics/{league}", name="app.statistics")
     */
    public function statistics(
        GoalRepository $goalRepository,
        CanadianPointsCalculator $canadianPointsCalculator,
        LeagueRepository $leagueRepository,
        League $league
    ): Response {
        $bestScorers = [];
        $bestAssistants = [];
        $teams = $league->getSeasons()->first()->getTeams();
        if ($league->getName() === 'Grupa Mistrzowska' || $league->getName() === 'Grupa Spadkowa') {
            $bestScorers = $goalRepository->getBestScorersForTeams($teams->toArray());
            $bestAssistants = $goalRepository->getBestAssistantsForTeams($teams->toArray());
        } else if ($league->isFinished()) {
            $statistics = json_decode($league->getMainRoundStatistics(), true);
            $bestScorers = $statistics['best_scorers'];
            $bestAssistants = $statistics['best_assistants'];
        } else {
            $bestScorers = $goalRepository->getBestScorersForLeagueEntity($league);
            $bestAssistants = $goalRepository->getBestAssistantsForLeagueEntity($league);
        }


        return $this->render(
            'statistics/dashboard.html.twig',
            [
                'bestScorers' => $bestScorers,
                'bestAssistants' => $bestAssistants,
                'canadianPoints' => $canadianPointsCalculator->calculate($bestScorers, $bestAssistants),
                'leagues' => $leagueRepository->findAll()
            ]
        );
    }
}
