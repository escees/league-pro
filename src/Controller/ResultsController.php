<?php

namespace App\Controller;

use App\Entity\FootballMatch;
use App\Repository\FootballMatchRepository;
use App\Repository\MatchDayRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ResultsController extends AbstractController
{
    /**
     * @Route("/results", name="app.results")
     */
    public function results(
        Request $request,
        MatchDayRepository $matchDayRepository
    ) {
        return $this->render(
            'results.html.twig',
            [
                'matchdays' => $matchDayRepository->getAllResults(),
            ]
        );
    }

    /**
     * @Route("/single-result/{match}", name="app.single_result")
     */
    public function singleResult(
        Request $request,
        FootballMatch $match
    ) {
        return $this->render(
            'single-result.html.twig',
            [
                'match' => $match,
            ]
        );
    }
}
