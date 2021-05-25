<?php

namespace App\Controller;

use App\Entity\League;
use App\Repository\LeagueRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TableController extends AbstractController
{
    /**
     * @Route("/table/{league}", name="app.table")
     */
    public function table(
        Request $request,
        TeamRepository $teamRepository,
        LeagueRepository $leagueRepository,
        League $league
    ) {
        return $this->render(
            'table-point.html.twig',
            [
                'teams' => $teamRepository->getTeamStandingsForLeague($league),
                'leagues'=> $leagueRepository->findAll()
            ]
        );
    }
}
