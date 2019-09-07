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
     * @Route("/statistics", name="app.statistics")
     */
    public function index(
        Request $request,
        GoalRepository $goalRepository,
        CanadianPointsCalculator $canadianPointsCalculator
    ) {
        $bestScorers = $goalRepository->getBestScorers(false);
        $bestAssistants = $goalRepository->getBestAssistants();

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
