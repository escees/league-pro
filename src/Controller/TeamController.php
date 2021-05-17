<?php

namespace App\Controller;

use App\Entity\Team;
use App\Repository\FootballMatchRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    /**
     * @Route("/team/list/extraclass", name="app.teams.extraclass")
     */
    public function listExtraclass(Request $request, TeamRepository $teamRepository)
    {
        return $this->render(
            'teams.html.twig',
            [
                'teams' => $teamRepository->getAllTeamsForLeague('Ekstraklasa'),
            ]
        );
    }

    /**
     * @Route("/team/list/first-league", name="app.teams.first_league")
     */
    public function listFirstLeague(Request $request, TeamRepository $teamRepository)
    {
        return $this->render(
            'teams.html.twig',
            [
                'teams' => $teamRepository->getAllTeamsForLeague('I liga'),
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
                'results' => $matchRepository->getAllResultsOrderedByStartDateDescendingByTeam($team)
            ]
        );
    }
}
