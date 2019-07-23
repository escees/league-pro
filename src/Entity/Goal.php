<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GoalRepository")
 */
class Goal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Player", cascade={"persist", "remove"})
     */
    private $assistant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Player", inversedBy="goals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $scorer;

    /**
     * @ORM\Column(type="integer")
     */
    private $minute;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MatchDetails", inversedBy="goals")
     * @ORM\JoinColumn(nullable=true)
     */
    private $matchDetails;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssistant(): ?Player
    {
        return $this->assistant;
    }

    public function setAssistant(?Player $assistant): self
    {
        $this->assistant = $assistant;

        return $this;
    }

    public function getScorer(): ?Player
    {
        return $this->scorer;
    }

    public function setScorer(?Player $scorer): self
    {
        $this->scorer = $scorer;

        return $this;
    }

    public function getMinute(): ?int
    {
        return $this->minute;
    }

    public function setMinute(int $minute): self
    {
        $this->minute = $minute;

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
