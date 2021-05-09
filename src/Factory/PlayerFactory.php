<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Player;
use DateTime;

class PlayerFactory
{
    public function createFromCsv(array $csvRecord): Player
    {
        $player = new Player();
        $player->setName($csvRecord[0]);
        $player->setDateOfBirth(new Datetime($csvRecord[1]));
        $player->setPosition($csvRecord[2]);
        $player->setNumber((int)$csvRecord[3]);

        return $player;
    }
}
