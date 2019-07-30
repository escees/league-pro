<?php

namespace App\Event;

final class LeagueProEvents
{
    /**
     * is dispatched when match score/result is added.
     *
     * @see MatchResultAddedEvent
     *
     * @var string
     */
    const MATCH_RESULT_ADDED = 'league.match_result.added';
}
