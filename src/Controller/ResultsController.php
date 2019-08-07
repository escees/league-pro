<?php

namespace App\Controller;

use App\Repository\FootballMatchRepository;
use App\Repository\GoalRepository;
use App\Repository\TeamRepository;
use App\Service\CanadianPointsCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ResultsController extends AbstractController
{
    /**
     * @Route("/results", name="app.results")
     */
    public function index(
        Request $request,
        FootballMatchRepository $footballMatchRepository
    ) {
        return $this->render(
            'results.html.twig',
            [
                'results' => $footballMatchRepository->getAllPlayedMatchesOrderedByStartDateDescending(),
            ]
        );
    }
}
