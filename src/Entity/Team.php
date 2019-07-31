<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 */
class Team
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Player", mappedBy="team")
     */
    private $players;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $wins = 0;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $winsAfterPenalties = 0;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $draws = 0;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $loses = 0;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="object", nullable=true)
     */
    private $crest;

    /**
     * @ORM\Column(type="object", nullable=true)
     */
    private $photo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FootballMatch", mappedBy="homeTeam")
     */
    private $homeFootballMatch;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FootballMatch", mappedBy="awayTeam")
     */
    private $awayFootballMatch;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $points = 0;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $goalsScored = 0;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $goalsConceded = 0;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $losesAfterPenalties = 0;

    public function __construct()
    {
        $this->players = new ArrayCollection();
        $this->homeFootballMatch = new ArrayCollection();
        $this->awayFootballMatch = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Player[]
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
            $player->setTeam($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->contains($player)) {
            $this->players->removeElement($player);
            // set the owning side to null (unless already changed)
            if ($player->getTeam() === $this) {
                $player->setTeam(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getWins(): ?int
    {
        return $this->wins;
    }

    public function setWins(?int $wins): self
    {
        $this->wins = $wins;

        return $this;
    }

    public function getWinsAfterPenalties(): ?int
    {
        return $this->winsAfterPenalties;
    }

    public function setWinsAfterPenalties(?int $winsAfterPenalties): self
    {
        $this->winsAfterPenalties = $winsAfterPenalties;

        return $this;
    }

    public function getDraws(): ?int
    {
        return $this->draws;
    }

    public function setDraws(?int $draws): self
    {
        $this->draws = $draws;

        return $this;
    }

    public function getLoses(): ?int
    {
        return $this->loses;
    }

    public function setLoses(?int $loses): self
    {
        $this->loses = $loses;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCrest()
    {
        return $this->crest;
    }

    public function setCrest($crest): self
    {
        $this->crest = $crest;

        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection|FootballMatch[]
     */
    public function getHomeFootballMatch(): Collection
    {
        return $this->homeFootballMatch;
    }

    public function addHomeFootballMatch(FootballMatch $homeFootballMatch): self
    {
        if (!$this->homeFootballMatch->contains($homeFootballMatch)) {
            $this->homeFootballMatch[] = $homeFootballMatch;
            $homeFootballMatch->setHomeTeam($this);
        }

        return $this;
    }

    public function removeHomeFootballMatch(FootballMatch $homeFootballMatch): self
    {
        if ($this->homeFootballMatch->contains($homeFootballMatch)) {
            $this->homeFootballMatch->removeElement($homeFootballMatch);
            // set the owning side to null (unless already changed)
            if ($homeFootballMatch->getHomeTeam() === $this) {
                $homeFootballMatch->setHomeTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FootballMatch[]
     */
    public function getAwayFootballMatch(): Collection
    {
        return $this->awayFootballMatch;
    }

    public function addAwayFootballMatch(FootballMatch $awayFootballMatch): self
    {
        if (!$this->awayFootballMatch->contains($awayFootballMatch)) {
            $this->awayFootballMatch[] = $awayFootballMatch;
            $awayFootballMatch->setAwayTeam($this);
        }

        return $this;
    }

    public function removeAwayFootballMatch(FootballMatch $awayFootballMatch): self
    {
        if ($this->awayFootballMatch->contains($awayFootballMatch)) {
            $this->awayFootballMatch->removeElement($awayFootballMatch);
            // set the owning side to null (unless already changed)
            if ($awayFootballMatch->getAwayTeam() === $this) {
                $awayFootballMatch->setAwayTeam(null);
            }
        }

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function addPoints(int $pointsToAdd)
    {
        $this->points += $pointsToAdd;
    }

    public function setPoints(?int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getGoalsScored(): ?int
    {
        return $this->goalsScored;
    }

    public function addGoalsScored(int $goals): void
    {
        $this->goalsScored += $goals;
    }

    public function setGoalsScored(?int $goalsScored): self
    {
        $this->goalsScored = $goalsScored;

        return $this;
    }

    public function getGoalsConceded(): ?int
    {
        return $this->goalsConceded;
    }


    public function addGoalsConceded(int $goals): void
    {
        $this->goalsConceded += $goals;
    }

    public function setGoalsConceded(?int $goalsConceded): self
    {
        $this->goalsConceded = $goalsConceded;

        return $this;
    }

    public function addWin()
    {
        $this->wins++;
        $this->addPoints(3);
    }

    public function addWinAfterPenalties()
    {
        $this->winsAfterExtraTime++;
        $this->addPoints(2);
    }

    public function addLose()
    {
        $this->loses++;
    }

    public function addLoseAfterPenalties()
    {
        $this->losesAfterPenalties++;
        $this->addPoints(1);
    }

    public function getLosesAfterPenalties(): ?int
    {
        return $this->losesAfterPenalties;
    }

    public function setLosesAfterPenalties(?int $losesAfterPenalties): self
    {
        $this->losesAfterPenalties = $losesAfterPenalties;

        return $this;
    }
}
