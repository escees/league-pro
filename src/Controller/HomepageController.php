<?php

namespace App\Controller;

use App\Repository\FootballMatchRepository;
use App\Repository\GoalRepository;
use App\Repository\LeagueRepository;
use App\Repository\NewsRepository;
use App\Repository\SeasonRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="app.homepage")
     */
    public function index(
        TeamRepository $teamRepository,
        FootballMatchRepository $footballMatchRepository,
        GoalRepository $goalRepository,
        NewsRepository $newsRepository,
        LeagueRepository $leagueRepository,
        SeasonRepository $seasonRepository
    ) {
        $news = $newsRepository->findPublishedNews(5);

        return $this->render(
            'index.html.twig',
            [
                'leagues' => $leagueRepository->findAll(),
                'teamsGroupA' => $teamRepository->getTeamStandings('Grupa A', 8), //@todo refactor
                'teamsGroupB' => $teamRepository->getTeamStandings('Grupa B',8),
                'resultsGroupA' => $footballMatchRepository->getLastThreeMatchesForLeague('Grupa A'),
                'resultsGroupB' => $footballMatchRepository->getLastThreeMatchesForLeague('Grupa B'),
                'bestScorersGroupA' => $goalRepository->getBestScorersForLeague('Grupa A'),
                'bestScorersGroupB' => $goalRepository->getBestScorersForLeague('Grupa B'),
                'nextMatch' => $footballMatchRepository->getNextMatch(),
                'fixtures' => $footballMatchRepository->getNumberOfFixturesOrderedByStartDateAscending(5),
                'news' => $news,
                'newsForSlider' => array_slice($news, 0, 3)
            ]
        );
    }
}
