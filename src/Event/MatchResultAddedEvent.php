<?php

namespace App\Event;

use App\Entity\FootballMatch;
use Symfony\Contracts\EventDispatcher\Event;

class MatchResultAddedEvent extends Event
{
    private $match;

    public function __construct(FootballMatch $match)
    {
        $this->match = $match;
    }

    public function getMatch(): FootballMatch
    {
        return $this->match;
    }
}
