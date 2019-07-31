<?php

namespace App\Controller;

use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminStatisticsController extends AbstractController
{
    /**
     * @Route("/statistics", name="app.admin.statistics")
     */
    public function index(Request $request, TeamRepository $teamRepository)
    {
//        dump($teamRepository->getTeamStandings());die;
        return $this->render(
            'admin/statistics/dashboard.html.twig',
            [
                'teams' => $teamRepository->getTeamStandings()
            ]
        );
    }

}
