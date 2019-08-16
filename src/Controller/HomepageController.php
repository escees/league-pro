<?php

namespace App\Controller;

use App\Repository\FootballMatchRepository;
use App\Repository\GoalRepository;
use App\Repository\NewsRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="app.homepage")
     */
    public function index(
        Request $request,
        TeamRepository $teamRepository,
        FootballMatchRepository $footballMatchRepository,
        GoalRepository $goalRepository,
        NewsRepository $newsRepository
    ) {
        $news = $newsRepository->findPublishedNews(5);

        return $this->render(
            'index.html.twig',
            [
                'teams' => $teamRepository->getTeamStandings(),
                'results' => $footballMatchRepository->getLastThreeMatches(),
                'bestScorers' => $goalRepository->getBestScorers(true),
                'nextMatch' => $footballMatchRepository->getNextMatch(),
                'fixtures' => $footballMatchRepository->getNumberOfFixturesOrderedByStartDateAscending(5),
                'news' => $news,
                'newsForSlider' => array_slice($news, 0, 3)
            ]
        );
    }
}
