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
     * @Route("/team/list", name="app.teams")
     */
    public function list(Request $request, TeamRepository $teamRepository)
    {
        return $this->render(
            'teams.html.twig',
            [
                'teams' => $teamRepository->findAll(),
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
