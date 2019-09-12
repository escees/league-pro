<?php

namespace App\Controller;

use App\Repository\GoalRepository;
use App\Repository\TeamRepository;
use App\Service\CanadianPointsCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TableController extends AbstractController
{
    /**
     * @Route("/table", name="app.table")
     */
    public function index(
        Request $request,
        TeamRepository $teamRepository
    ) {
        return $this->render(
            'table-point.html.twig',
            [
                'teams' => $teamRepository->getTeamStandings(),
            ]
        );
    }
}
