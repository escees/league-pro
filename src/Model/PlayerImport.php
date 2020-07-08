<?php

declare(strict_types=1);

namespace App\Model;

use App\Entity\Team;
use Symfony\Component\HttpFoundation\File\File;

class PlayerImport //@todo check if I can use this class as a data_class in PlayerImportType
{
    private $team;
    private $playerFile;

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(Team $team): void
    {
        $this->team = $team;
    }

    public function getPlayerFile(): ?File
    {
        return $this->playerFile;
    }

    public function setPlayerFile(File $playerFile): void
    {
        $this->playerFile = $playerFile;
    }
}
