<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\FootballMatch;
use App\Entity\Team;

class GoalsCounter
{
    public function countGoalsScored(Team $team): int
    {
        $goalsFromWon = $this->countGoalsScoredFromWonGames($team);

        $goalsFromTies = $this->countGoalsFromTies($team);

        $goalsFromLost = $this->countGoalsFromLostGames($team);

        return $goalsFromLost + $goalsFromTies + $goalsFromWon;
    }

    public function countGoalsConceded(Team $team): int
    {
        $goalsFromWon = $this->countGoalsConcededFromWonGames($team);

        $goalsFromTies = $this->countGoalsConcededFromTies($team);

        $goalsFromLost = $this->countGoalsConcededFromLostGames($team);

        return $goalsFromLost + $goalsFromTies + $goalsFromWon;
    }

    private function countGoalsScoredFromWonGames(Team $team): int
    {
        return array_sum($team->getMatchesWon()->map(function (FootballMatch $match) use ($team) {
            $matchDetails = $match->getMatchDetails();
            if ($team === $match->getHomeTeam()) {
                return $matchDetails->getHomeTeamGoals();
            }

            return $matchDetails->getAwayTeamGoals();
        })->toArray());
    }

    private function countGoalsFromTies(Team $team): int
    {
        return array_sum($team->getMatchesTied()->map(function (FootballMatch $match) {
            return $match->getMatchDetails()->getHomeTeamGoals(); // @todo no matter which team goals we will choose
        })->toArray());
    }

    private function countGoalsFromLostGames(Team $team): int
    {
        return array_sum($team->getMatchesLost()->map(function (FootballMatch $match) use ($team) {
            $matchDetails = $match->getMatchDetails();
            if ($team === $match->getHomeTeam()) {
                return $matchDetails->getHomeTeamGoals();
            }

            return $matchDetails->getAwayTeamGoals();
        })->toArray());
    }

    private function countGoalsConcededFromWonGames(Team $team): int
    {
        return array_sum($team->getMatchesWon()->map(function (FootballMatch $match) use ($team) {
            $matchDetails = $match->getMatchDetails();
            if ($team === $match->getHomeTeam()) {
                return $matchDetails->getAwayTeamGoals();
            }

            return $matchDetails->getHomeTeamGoals();
        })->toArray());
    }

    private function countGoalsConcededFromTies(Team $team): int
    {
        return array_sum($team->getMatchesTied()->map(function (FootballMatch $match) {
            return $match->getMatchDetails()->getHomeTeamGoals(); // @todo no matter which team goals we will choose
        })->toArray());
    }

    private function countGoalsConcededFromLostGames(Team $team): int
    {
        return array_sum($team->getMatchesLost()->map(function (FootballMatch $match) use ($team) {
            $matchDetails = $match->getMatchDetails();
            if ($team === $match->getHomeTeam()) {
                return $matchDetails->getAwayTeamGoals();
            }

            return $matchDetails->getHomeTeamGoals();
        })->toArray());
    }
}
