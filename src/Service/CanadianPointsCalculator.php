<?php

namespace App\Service;

class CanadianPointsCalculator
{
    const NAME = 'name';
    const TEAM = 'team';
    const POINTS = 'points';
    const GOALS = 'goals';
    const ASSISTS = 'assists';

    public function calculate(array $scorers, array $assistants): array //@todo refactor
    {
        $playersCanadianPoints = [];
        foreach ($scorers as $scorer) {
            $scorerName = $scorer[self::NAME];
            if(!isset($playersCanadianPoints[$scorerName])) {
                $playersCanadianPoints[$scorerName] = [
                    self::NAME => $scorerName,
                    self::POINTS => $scorer[self::GOALS],
                    self::TEAM => $scorer[self::TEAM],
                ];
            }
            foreach ($assistants as $assistant) {
                $assistantName = $assistant[self::NAME];
                if(!isset($playersCanadianPoints[$assistantName])) {
                    $playersCanadianPoints[self::NAME] = [
                        self::NAME => $assistantName,
                        self::POINTS => $assistant[self::ASSISTS],
                        self::TEAM => $assistant[self::TEAM],
                    ];
                }

                if ($scorerName === $assistantName) {
                    $playersCanadianPoints[$scorerName] = [
                        self::NAME => $scorerName,
                        self::POINTS => $scorer[self::GOALS] + $assistant[self::ASSISTS],
                        self::TEAM => $scorer[self::TEAM],
                    ];
                }

            }
        }

        usort($playersCanadianPoints, function($a, $b) {
            return $b[self::POINTS] - $a[self::POINTS];
        });

        return $playersCanadianPoints;
    }
}
