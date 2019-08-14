<?php

namespace App\Controller;

use App\Entity\FootballMatch;
use App\Repository\FootballMatchRepository;
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
        FootballMatchRepository $footballMatchRepository
    ) {
        return $this->render(
            'results.html.twig',
            [
                'results' => $footballMatchRepository->getAllPlayedMatchesOrderedByStartDateDescending(),
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
