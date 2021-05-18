<?php

namespace App\Controller\Admin;

use App\Repository\GoalRepository;
use App\Repository\TeamRepository;
use App\Service\CanadianPointsCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminStatisticsController extends AbstractController
{
    /**
     * @Route("/admin/statistics", name="app.admin.statistics")
     */
    public function index(
        TeamRepository $teamRepository,
        GoalRepository $goalRepository,
        CanadianPointsCalculator $canadianPointsCalculator
    ) {
        $bestScorersExtraclass = $goalRepository->getBestScorersForLeague('Ekstraklasa');
        $bestScorersFirstLeague = $goalRepository->getBestScorersForLeague('I liga');
        $bestAssistantsExtraclass = $goalRepository->getBestAssistantsForLeague('Ekstraklasa');
        $bestAssistantsFirstLeague = $goalRepository->getBestAssistantsForLeague('I liga');

        return $this->render(
            'admin/statistics/dashboard.html.twig',
            [
                'teamsExtraclass' => $teamRepository->getTeamStandings('Ekstraklasa'),
                'teamsFirstLeague' => $teamRepository->getTeamStandings('I liga'),
                'bestScorersExtraclass' => $bestScorersExtraclass,
                'bestScorersFirstLeague' => $bestScorersFirstLeague,
                'bestAssistantsExtraclass' => $bestAssistantsExtraclass,
                'bestAssistantsFirstLeague' => $bestAssistantsFirstLeague,
                'canadianPointsExtraclass' => $canadianPointsCalculator->calculate($bestScorersExtraclass, $bestAssistantsExtraclass),
                'canadianPointsFirstLeague' => $canadianPointsCalculator->calculate($bestScorersFirstLeague, $bestAssistantsFirstLeague)
            ]
        );
    }
}
