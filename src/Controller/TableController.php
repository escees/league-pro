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
                'teams' => $teamRepository->getTeamStandingsForLeague($league), //@todo serwis ktory ma dwie strategie dla dwóch druzyn i wiecej ilosci druzyn, punkty mnozone razy 1000 i przy sprawdzeniu wyniku dodanie jakichś małych punktów które zmienią kolejność na poprawną wg meczy bezposrednich
                'leagues'=> $leagueRepository->findAll()
            ]
        );
    }
}
