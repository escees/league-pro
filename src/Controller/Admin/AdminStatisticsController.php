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
        Request $request,
        TeamRepository $teamRepository,
        GoalRepository $goalRepository,
        CanadianPointsCalculator $canadianPointsCalculator
    ) {
        $bestScorers = $goalRepository->getBestScorers();
        $bestAssistants = $goalRepository->getBestAssistants();

        return $this->render(
            'admin/statistics/dashboard.html.twig',
            [
                'teams' => $teamRepository->getTeamStandings(),
                'bestScorers' => $bestScorers,
                'bestAssistants' => $bestAssistants,
                'canadianPoints' => $canadianPointsCalculator->calculate($bestScorers, $bestAssistants)
            ]
        );
    }

}
