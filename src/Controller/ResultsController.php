<?php

namespace App\Controller;

use App\Entity\FootballMatch;
use App\Entity\League;
use App\Repository\FootballMatchRepository;
use App\Repository\LeagueRepository;
use App\Repository\MatchDayRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ResultsController extends AbstractController
{
    /**
     * @Route("/results/{league}", name="app.results")
     */
    public function results(
        Request $request,
        MatchDayRepository $matchDayRepository,
        LeagueRepository $leagueRepository,
        League $league
    ) {
        return $this->render(
            'results.html.twig',
            [
                'matchdays' => $matchDayRepository->getAllResultsForLeagueEntity($league),
                'leagues' => $leagueRepository->findAll()
            ]
        );
    }

    /**
     * @Route("/single-result/{match}", name="app.single_result")
     */
    public function singleResult(
        Request $request,
        FootballMatch $match,
        LeagueRepository $leagueRepository
    ) {
        return $this->render(
            'single-result.html.twig',
            [
                'match' => $match,
                'leagues' => $leagueRepository->findAll()
            ]
        );
    }
}
