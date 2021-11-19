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
        $masters = $leagueRepository->findOneBy(['name' => 'Grupa Mistrzowska']);
        /** @var League $masters */
        $mastersTeams = $masters->getSeasons()->first()->getTeams();
        /** @var League $losers */
        $losers = $leagueRepository->findOneBy(['name' => 'Grupa Spadkowa']);
        $losersTeams = $losers->getSeasons()->first()->getTeams();
        $groupA = $leagueRepository->findOneBy(['name' => 'Grupa A']);
        $groupB = $leagueRepository->findOneBy(['name' => 'Grupa B']);

        return $this->render(
            'index.html.twig',
            [
                'leagues' => $leagueRepository->findAll(),
                'masters' => $teamRepository->getTeamStandingsForLeagueAndDate($masters, new \Datetime('2021-10-30')), //@todo refactor
                'losers' => $teamRepository->getTeamStandingsForLeagueAndDate($losers, new \Datetime('2021-10-30')), //@todo refactor
                'teamsGroupA' => $groupA->isFinished() ? json_decode($groupA->getMainRoundStandings(), true) : $teamRepository->getTeamStandings('Grupa A', 8), //@todo refactor
                'teamsGroupB' => $groupB->isFinished() ? json_decode($groupB->getMainRoundStandings(), true) : $teamRepository->getTeamStandings('Grupa B',8),
                'resultsMasters' => $footballMatchRepository->getLastThreeMatchesForLeague('Grupa Mistrzowska'),
                'resultsLosers' => $footballMatchRepository->getLastThreeMatchesForLeague('Grupa Spadkowa'),
                'resultsGroupA' => $footballMatchRepository->getLastThreeMatchesForLeague('Grupa A'),
                'resultsGroupB' => $footballMatchRepository->getLastThreeMatchesForLeague('Grupa B'),
                'bestScorersMasters' => $goalRepository->getBestScorersForTeams($mastersTeams->toArray()),
                'bestScorersLosers' => $goalRepository->getBestScorersForTeams($losersTeams->toArray()),
                'bestScorersGroupA' => $groupA->isFinished() ? json_decode($groupA->getMainRoundStatistics(), true)['best_scorers'] :$goalRepository->getBestScorersForLeague('Grupa A'),
                'bestScorersGroupB' => $groupB->isFinished() ? json_decode($groupB->getMainRoundStatistics(), true)['best_scorers'] :$goalRepository->getBestScorersForLeague('Grupa B'),
                'nextMatch' => $footballMatchRepository->getNextMatch(),
                'fixtures' => $footballMatchRepository->getNumberOfFixturesOrderedByStartDateAscending(5),
                'news' => $news,
                'newsForSlider' => array_slice($news, 0, 3)
            ]
        );
    }
}
