<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\FootballMatch;
use App\Entity\Team;

class GoalsCounter
{
    public function countGoalsScored(Team $team): int
    {
        $goalsFromWon = array_sum($team->getMatchesWon()->map(function (FootballMatch $match) use ($team) {
            $matchDetails = $match->getMatchDetails();
            if ($team === $match->getHomeTeam()) {
                return $matchDetails->getHomeTeamGoals();
            }

            return $matchDetails->getAwayTeamGoals();
        })->toArray());

        $goalsFromTies = array_sum($team->getMatchesTied()->map(function (FootballMatch $match) {
            return $match->getMatchDetails()->getHomeTeamGoals(); // @todo no matter which team goals we will choose
        })->toArray());

        $goalsFromLost = array_sum($team->getMatchesLost()->map(function (FootballMatch $match) use ($team) {
            $matchDetails = $match->getMatchDetails();
            if ($team === $match->getHomeTeam()) {
                return $matchDetails->getHomeTeamGoals();
            }

            return $matchDetails->getAwayTeamGoals();
        })->toArray());

        return $goalsFromLost + $goalsFromTies + $goalsFromWon;
    }

    public function countGoalsConceded(Team $team): int
    {
        $goalsFromWon = array_sum($team->getMatchesWon()->map(function (FootballMatch $match) use ($team) {
            $matchDetails = $match->getMatchDetails();
            if ($team === $match->getHomeTeam()) {
                return $matchDetails->getAwayTeamGoals();
            }

            return $matchDetails->getHomeTeamGoals();
        })->toArray());

        $goalsFromTies = array_sum($team->getMatchesTied()->map(function (FootballMatch $match) {
            return $match->getMatchDetails()->getHomeTeamGoals(); // @todo no matter which team goals we will choose
        })->toArray());

        $goalsFromLost = array_sum($team->getMatchesLost()->map(function (FootballMatch $match) use ($team) {
            $matchDetails = $match->getMatchDetails();
            if ($team === $match->getHomeTeam()) {
                return $matchDetails->getAwayTeamGoals();
            }

            return $matchDetails->getHomeTeamGoals();
        })->toArray());

        return $goalsFromLost + $goalsFromTies + $goalsFromWon;
    }
}
