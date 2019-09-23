<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ManOfTheMatchRepository")
 */
class ManOfTheMatch
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Player", inversedBy="mvps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\MatchDetails", inversedBy="mvp", cascade={"persist", "remove"})
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
