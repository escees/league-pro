<?php

namespace App\Controller;

use App\Repository\GoalRepository;
use App\Service\CanadianPointsCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StatisticsController extends AbstractController
{
    /**
     * @Route("/statistics/extraclass", name="app.statistics.extraclass")
     */
    public function statisticsExtraclass(
        GoalRepository $goalRepository,
        CanadianPointsCalculator $canadianPointsCalculator
    ) {
        $bestScorers = $goalRepository->getBestScorersForLeague('Ekstraklasa');
        $bestAssistants = $goalRepository->getBestAssistantsForLeague('Ekstraklasa');

        return $this->render(
            'statistics/dashboard.html.twig',
            [
                'bestScorers' => $bestScorers,
                'bestAssistants' => $bestAssistants,
                'canadianPoints' => $canadianPointsCalculator->calculate($bestScorers, $bestAssistants)
            ]
        );
    }

    /**
     * @Route("/statistics/first-league", name="app.statistics.first_league")
     */
    public function statisticsFirstLeague(
        GoalRepository $goalRepository,
        CanadianPointsCalculator $canadianPointsCalculator
    ) {
        $bestScorers = $goalRepository->getBestScorersForLeague('I liga');
        $bestAssistants = $goalRepository->getBestAssistantsForLeague('I liga');

        return $this->render(
            'statistics/dashboard.html.twig',
            [
                'bestScorers' => $bestScorers,
                'bestAssistants' => $bestAssistants,
                'canadianPoints' => $canadianPointsCalculator->calculate($bestScorers, $bestAssistants)
            ]
        );
    }
}
