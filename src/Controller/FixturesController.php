<?php

namespace App\Controller;

use App\Entity\League;
use App\Repository\LeagueRepository;
use App\Repository\MatchDayRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FixturesController extends AbstractController
{
    /**
     * @Route("/fixtures/{league}", name="app.fixtures")
     */
    public function results(
        Request $request,
        MatchDayRepository $matchDayRepository,
        LeagueRepository $leagueRepository,
        League $league
    ) {
        return $this->render(
            'fixtures.html.twig',
            [
                'matchdays' => $matchDayRepository->findAllOrderByDateAscendingForLeague($league),
                'leagues'=> $leagueRepository->findAll()
            ]
        );
    }
}
