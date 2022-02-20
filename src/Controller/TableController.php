<?php

namespace App\Controller;

use App\Entity\League;
use App\Entity\Team;
use App\Repository\LeagueRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TableController extends AbstractController
{
    /**
     * @Route("/table/{league}", name="app.table")
     */
    public function table(
        Request $request,
        TeamRepository $teamRepository,
        LeagueRepository $leagueRepository,
        League $league,
        SerializerInterface $serializer
    )
    {
        return $this->render(
            'table-point.html.twig',
            [
                'teams' => $teamRepository->getTeamStandingsForLeague($league), //@todo serwis ktory ma dwie strategie dla dwóch druzyn i wiecej ilosci druzyn, punkty mnozone razy 1000 i przy sprawdzeniu wyniku dodanie jakichś małych punktów które zmienią kolejność na poprawną wg meczy bezposrednich
                'leagues' => $leagueRepository->findAll()
            ]
        );
    }
//
//    private function updateStandings(array $oldStandings, array $standings): array
//    {
//        // @todo tutaj if punktu ze standings > oldStandings to tez ma dzialac dla grupy spadkowej!!!!!!!!!
//        foreach ($oldStandings as $oldStanding) {
//            foreach ($standings as $standing) {
//                /** @var Team $actualTeamStanding */
//                $actualTeamStanding = $standing['team'];
//                /** @var Team $oldTeamStanding */
//                $oldTeamStanding = $oldStanding['team'];
//                if ($actualTeamStanding->getName() === $oldTeamStanding->getName()) {
//                    $actualTeamStanding->setPoints($actualTeamStanding->getPoints() - $oldTeamStanding->getPoints());
//                    $actualTeamStanding->setPlayedMatches($actualTeamStanding->getPlayedMatches() - $oldTeamStanding->getPlayedMatches());
//                    $actualTeamStanding->setGoalsScored($actualTeamStanding->getGoalsScored() - $oldTeamStanding->getGoalsScored());
//                    $actualTeamStanding->setGoalsConceded($actualTeamStanding->getGoalsConceded() - $oldTeamStanding->getGoalsConceded());
//                }
//            }
//        }
//    }
}
