<?php

namespace App\Controller;

use App\Repository\GoalRepository;
use App\Repository\TeamRepository;
use App\Service\CanadianPointsCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TableController extends AbstractController
{
    /**
     * @Route("/table", name="app.table")
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
            'table-point.html.twig',
            [
                'teams' => $teamRepository->getTeamStandings(),
                'bestScorers' => $bestScorers,
                'bestAssistants' => $bestAssistants,
                'canadianPoints' => $canadianPointsCalculator->calculate($bestScorers, $bestAssistants)
            ]
        );
    }
}
