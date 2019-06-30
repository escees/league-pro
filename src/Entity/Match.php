<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MatchRepository")
 */
class Match
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Team", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $homeTeam;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Team", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $awayTeam;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $result;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Goal", mappedBy="footballMatch", orphanRemoval=true)
     */
    private $homeTeamGoals;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Goal", mappedBy="footballMatch", orphanRemoval=true)
     */
    private $awayTeamGoals;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $video;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Card", mappedBy="footballMatch", orphanRemoval=true)
     */
    private $cards;

    public function __construct()
    {
        $this->homeTeamGoals = new ArrayCollection();
        $this->awayTeamGoals = new ArrayCollection();
        $this->cards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHomeTeam(): ?Team
    {
        return $this->homeTeam;
    }

    public function setHomeTeam(Team $homeTeam): self
    {
        $this->homeTeam = $homeTeam;

        return $this;
    }

    public function getAwayTeam(): ?Team
    {
        return $this->awayTeam;
    }

    public function setAwayTeam(Team $awayTeam): self
    {
        $this->awayTeam = $awayTeam;

        return $this;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(?string $result): self
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @return Collection|Goal[]
     */
    public function getHomeTeamGoals(): Collection
    {
        return $this->homeTeamGoals;
    }

    public function addHomeTeamGoal(Goal $homeTeamGoal): self
    {
        if (!$this->homeTeamGoals->contains($homeTeamGoal)) {
            $this->homeTeamGoals[] = $homeTeamGoal;
            $homeTeamGoal->setFootballMatch($this);
        }

        return $this;
    }

    public function removeHomeTeamGoal(Goal $homeTeamGoal): self
    {
        if ($this->homeTeamGoals->contains($homeTeamGoal)) {
            $this->homeTeamGoals->removeElement($homeTeamGoal);
            // set the owning side to null (unless already changed)
            if ($homeTeamGoal->getFootballMatch() === $this) {
                $homeTeamGoal->setFootballMatch(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Goal[]
     */
    public function getAwayTeamGoals(): Collection
    {
        return $this->awayTeamGoals;
    }

    public function addAwayTeamGoal(Goal $awayTeamGoal): self
    {
        if (!$this->awayTeamGoals->contains($awayTeamGoal)) {
            $this->awayTeamGoals[] = $awayTeamGoal;
            $awayTeamGoal->setFootballMatch($this);
        }

        return $this;
    }

    public function removeAwayTeamGoal(Goal $awayTeamGoal): self
    {
        if ($this->awayTeamGoals->contains($awayTeamGoal)) {
            $this->awayTeamGoals->removeElement($awayTeamGoal);
            // set the owning side to null (unless already changed)
            if ($awayTeamGoal->getFootballMatch() === $this) {
                $awayTeamGoal->setFootballMatch(null);
            }
        }

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    /**
     * @return Collection|Card[]
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
            $card->setFootballMatch($this);
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
            // set the owning side to null (unless already changed)
            if ($card->getFootballMatch() === $this) {
                $card->setFootballMatch(null);
            }
        }

        return $this;
    }
}
