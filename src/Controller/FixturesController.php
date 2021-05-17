<?php

namespace App\Controller;

use App\Repository\FootballMatchRepository;
use App\Repository\GoalRepository;
use App\Repository\MatchDayRepository;
use App\Repository\TeamRepository;
use App\Service\CanadianPointsCalculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FixturesController extends AbstractController
{
    /**
     * @Route("/fixtures/extraclass", name="app.fixtures.extraclass")
     */
    public function resultsExtraclass(
        Request $request,
        MatchDayRepository $matchDayRepository
    ) {
        return $this->render(
            'fixtures.html.twig',
            [
                'matchdays' => $matchDayRepository->findAllOrderByDateAscending('Ekstraklasa'),
            ]
        );
    }

    /**
     * @Route("/fixtures/first-league", name="app.fixtures.first_league")
     */
    public function resultsFirstLeague(
        Request $request,
        MatchDayRepository $matchDayRepository
    ) {
        return $this->render(
            'fixtures.html.twig',
            [
                'matchdays' => $matchDayRepository->findAllOrderByDateAscending('I liga'),
            ]
        );
    }
}
