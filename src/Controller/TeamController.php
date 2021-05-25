<?php

namespace App\Controller;

use App\Entity\League;
use App\Entity\Team;
use App\Repository\FootballMatchRepository;
use App\Repository\LeagueRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    private $leagueRepository;

    public function __construct(LeagueRepository $leagueRepository)
    {
        $this->leagueRepository = $leagueRepository;
    }

    /**
     * @Route("/team/list/{league}", name="app.teams")
     */
    public function list(Request $request, TeamRepository $teamRepository, League $league): Response
    {
        return $this->render(
            'teams.html.twig',
            [
                'teams' => $teamRepository->getAllTeamsForLeagueEntity($league),
                'leagues' => $this->leagueRepository->findAll()
            ]
        );
    }

    /**
     * @Route("/team/{team}", name="app.team.view")
     */
    public function view(Request $request, Team $team, FootballMatchRepository $matchRepository)
    {
        return $this->render(
            'single-team.html.twig',
            [
                'team' => $team,
                'fixtures' => $matchRepository->getAllFixturesByTeam($team),
                'results' => $matchRepository->getAllResultsOrderedByStartDateDescendingByTeam($team),
                'leagues' => $this->leagueRepository->findAll()
            ]
        );
    }
}
