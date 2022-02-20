<?php

namespace App\Controller;

use App\Entity\League;
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
//        $masters = $leagueRepository->findOneBy(['name' => 'Grupa Mistrzowska']);
//        /** @var League $masters */
//        $mastersTeams = $masters->getSeasons()->first()->getTeams();
//        /** @var League $losers */
//        $losers = $leagueRepository->findOneBy(['name' => 'Grupa Spadkowa']);
//        $losersTeams = $losers->getSeasons()->first()->getTeams();
        $extraclass = $leagueRepository->findOneBy(['name' => 'Ekstraklasa']);
        $firstLeague = $leagueRepository->findOneBy(['name' => 'I Liga']);

        return $this->render(
            'index.html.twig',
            [
                'leagues' => $leagueRepository->findAll(),
//                'masters' => $teamRepository->getTeamStandingsForLeagueAndDate($extraclass, new \Datetime('2021-10-30')), //@todo refactor
//                'losers' => $teamRepository->getTeamStandingsForLeagueAndDate($firstLeague, new \Datetime('2021-10-30')), //@todo refactor
                'teamsGroupA' => $teamRepository->getTeamStandings('Ekstraklasa', 8), //@todo refactor
                'teamsGroupB' => $teamRepository->getTeamStandings('I Liga',8),
                'resultsMasters' => $footballMatchRepository->getLastThreeMatchesForLeague('Grupa Mistrzowska'),
                'resultsLosers' => $footballMatchRepository->getLastThreeMatchesForLeague('Grupa Spadkowa'),
                'resultsGroupA' => $footballMatchRepository->getLastThreeMatchesForLeague('Grupa A'),
                'resultsGroupB' => $footballMatchRepository->getLastThreeMatchesForLeague('Grupa B'),
//                'bestScorersMasters' => $goalRepository->getBestScorersForTeams($mastersTeams->toArray()),
//                'bestScorersLosers' => $goalRepository->getBestScorersForTeams($losersTeams->toArray()),
                'bestScorersGroupA' => $goalRepository->getBestScorersForLeague('Ekstraklasa'),
                'bestScorersGroupB' => $goalRepository->getBestScorersForLeague('I Liga'),
                'nextMatch' => $footballMatchRepository->getNextMatch(),
                'fixtures' => $footballMatchRepository->getNumberOfFixturesOrderedByStartDateAscending(5),
                'news' => $news,
                'newsForSlider' => array_slice($news, 0, 3)
            ]
        );
    }
}
