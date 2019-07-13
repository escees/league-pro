<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MatchEventRepository")
 * 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"matchEvent" = "MatchEvent",
 *      "goal" = "Goal",
 *      "card" = "Card"
 * })
 */
class MatchEvent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Player", inversedBy="matchEvents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    /**
     * @ORM\Column(type="integer")
     */
    private $minute;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MatchDetails", inversedBy="matchEvents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $matchDetails;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getMinute(): int
    {
        return $this->minute;
    }

    public function setMinute(int $minute): void
    {
        $this->minute = $minute;
    }

    public function getMatchDetails(): ?MatchDetails
    {
        return $this->matchDetails;
    }

    public function setMatchDetails(?MatchDetails $matchDetails): self
    {
        $this->matchDetails = $matchDetails;

        return $this;
    }
}
