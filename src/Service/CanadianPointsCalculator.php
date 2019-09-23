<?php

namespace App\Service;

class CanadianPointsCalculator
{
    const NAME = 'name';
    const TEAM = 'team';
    const POINTS = 'points';
    const GOALS = 'goals';
    const ASSISTS = 'assists';
    const TEAM_ID = 'team_id';

    public function calculate(array $scorers, array $assistants): array //@todo refactor
    {
        $canadianPointsPerPlayer = [];
        foreach ($scorers as $scorer) {
            $scorerName = $scorer[self::NAME];
            if(!isset($canadianPointsPerPlayer[$scorerName])) {
                $canadianPointsPerPlayer[$scorerName] = [
                    self::NAME => $scorerName,
                    self::POINTS => $scorer[self::GOALS],
                    self::TEAM => $scorer[self::TEAM],
                    self::TEAM_ID => $scorer[self::TEAM_ID]
                ];
            }
            foreach ($assistants as $assistant) {
                $assistantName = $assistant[self::NAME];
                if(!isset($canadianPointsPerPlayer[$assistantName])) {
                    $canadianPointsPerPlayer[self::NAME] = [
                        self::NAME => $assistantName,
                        self::POINTS => $assistant[self::ASSISTS],
                        self::TEAM => $assistant[self::TEAM],
                        self::TEAM_ID => $assistant[self::TEAM_ID]
                    ];
                }

                if ($scorerName === $assistantName) {
                    $canadianPointsPerPlayer[$scorerName] = [
                        self::NAME => $scorerName,
                        self::POINTS => $scorer[self::GOALS] + $assistant[self::ASSISTS],
                        self::TEAM => $scorer[self::TEAM],
                        self::TEAM_ID => $scorer[self::TEAM_ID]
                    ];
                }

            }
        }

        usort($canadianPointsPerPlayer, function($a, $b) {
            return $b[self::POINTS] - $a[self::POINTS];
        });

        return $canadianPointsPerPlayer;
    }
}
