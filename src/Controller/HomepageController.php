<?php

namespace App\Controller;

use App\Repository\FootballMatchRepository;
use App\Repository\GoalRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="app.homepage")
     */
    public function index(
        Request $request,
        TeamRepository $teamRepository,
        FootballMatchRepository $footballMatchRepository,
        GoalRepository $goalRepository
    ) {
        return $this->render(
            'index.html.twig',
            [
                'teams' => $teamRepository->getTeamStandings(),
                'results' => $footballMatchRepository->getLastThreeMatches(),
                'bestScorers' => $goalRepository->getBestScorers(true),
                'nextMatch' => $footballMatchRepository->getNextMatch()
            ]
        );
    }
}
