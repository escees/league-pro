<?php

declare(strict_types=1);

namespace App\Service\Import\Csv;

use App\Entity\Team;
use App\Factory\PlayerFactory;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PlayerCsvImporter
{
    private $playerFactory;
    private $entityManager;

    public function __construct(PlayerFactory $playerFactory, EntityManagerInterface $entityManager)
    {
        $this->playerFactory = $playerFactory;
        $this->entityManager = $entityManager;
    }

    public function import(UploadedFile $uploadedFile, Team $team): void
    {
        $reader = Reader::createFromPath($uploadedFile->getPathName());
        $records = $reader->getRecords();
        foreach($records as $offset => $record) {
            if ($offset !== 0) {
                $player = $this->playerFactory->createFromCsv($record);
                $player->setTeam($team);
                $this->entityManager->persist($player);
            }
        }
        $this->entityManager->flush();
    }
}
