<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MatchDetailsRepository")
 */
class MatchDetails
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $homeTeamGoals;

    /**
     * @ORM\Column(type="integer")
     */
    private $awayTeamGoals;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\FootballMatch", mappedBy="matchDetails", cascade={"persist", "remove"})
     */
    private $footballMatch;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MatchEvent", mappedBy="matchDetails")
     */
    private $matchEvents;

    public function __construct()
    {
        $this->matchEvents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHomeTeamGoals(): ?int
    {
        return $this->homeTeamGoals;
    }

    public function setHomeTeamGoals(int $homeTeamGoals): self
    {
        $this->homeTeamGoals = $homeTeamGoals;

        return $this;
    }

    public function getAwayTeamGoals(): ?int
    {
        return $this->awayTeamGoals;
    }

    public function setAwayTeamGoals(int $awayTeamGoals): self
    {
        $this->awayTeamGoals = $awayTeamGoals;

        return $this;
    }

    public function getFootballMatch(): ?FootballMatch
    {
        return $this->footballMatch;
    }

    public function setFootballMatch(?FootballMatch $footballMatch): self
    {
        $this->footballMatch = $footballMatch;

        // set (or unset) the owning side of the relation if necessary
        $newMatchDetails = $footballMatch === null ? null : $this;
        if ($newMatchDetails !== $footballMatch->getMatchDetails()) {
            $footballMatch->setMatchDetails($newMatchDetails);
        }

        return $this;
    }

    /**
     * @return Collection|MatchEvent[]
     */
    public function getMatchEvents(): Collection
    {
        return $this->matchEvents;
    }

    public function addMatchEvent(MatchEvent $matchEvent): self
    {
        if (!$this->matchEvents->contains($matchEvent)) {
            $this->matchEvents[] = $matchEvent;
            $matchEvent->setMatchDetails($this);
        }

        return $this;
    }

    public function removeMatchEvent(MatchEvent $matchEvent): self
    {
        if ($this->matchEvents->contains($matchEvent)) {
            $this->matchEvents->removeElement($matchEvent);
            // set the owning side to null (unless already changed)
            if ($matchEvent->getMatchDetails() === $this) {
                $matchEvent->setMatchDetails(null);
            }
        }

        return $this;
    }
}
