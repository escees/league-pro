<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank(message="Ilość bramek gospodarzy nie może być pusta")
     * @ORM\Column(type="integer")
     */
    private $homeTeamGoals;

    /**
     * @Assert\NotBlank(message="Ilość bramek przyjezdnych nie może być pusta")
     * @ORM\Column(type="integer")
     */
    private $awayTeamGoals;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\FootballMatch", mappedBy="matchDetails", cascade={"persist", "remove"})
     */
    private $footballMatch;

    /**
     * @Assert\Valid()
     * @ORM\OneToMany(targetEntity="App\Entity\Goal", mappedBy="matchDetails", cascade={"persist", "remove"})
     */
    private $goals;

    /**
     * @Assert\Valid()
     * @ORM\OneToMany(targetEntity="App\Entity\Card", mappedBy="matchDetails", cascade={"persist", "remove"})
     */
    private $cards;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $homeTeamPenalties;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $awayTeamPenalties;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\JoinColumn(nullable=true)
     * @ORM\OneToOne(targetEntity="App\Entity\ManOfTheMatch", mappedBy="matchDetails", cascade={"persist", "remove"})
     */
    private $mvp;

    public function __construct()
    {
        $this->goals = new ArrayCollection();
        $this->cards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHomeTeamGoals(): ?int
    {
        return $this->homeTeamGoals;
    }

    public function setHomeTeamGoals(?int $homeTeamGoals): self
    {
        $this->homeTeamGoals = $homeTeamGoals;

        return $this;
    }

    public function getAwayTeamGoals(): ?int
    {
        return $this->awayTeamGoals;
    }

    public function setAwayTeamGoals(?int $awayTeamGoals): self
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
     * @return Collection|Goal[]
     */
    public function getGoals(): Collection
    {
        return $this->goals;
    }

    public function addGoal(Goal $goal): self
    {
        if (!$this->goals->contains($goal)) {
            $this->goals[] = $goal;
            $goal->setMatchDetails($this);
        }

        return $this;
    }

    public function removeGoal(Goal $goal): self
    {
        if ($this->goals->contains($goal)) {
            $this->goals->removeElement($goal);
            // set the owning side to null (unless already changed)
            if ($goal->getMatchDetails() === $this) {
                $goal->setMatchDetails(null);
            }
        }

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
            $card->setMatchDetails($this);
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
            // set the owning side to null (unless already changed)
            if ($card->getMatchDetails() === $this) {
                $card->setMatchDetails(null);
            }
        }

        return $this;
    }

    public function getHomeTeamPenalties(): ?int
    {
        return $this->homeTeamPenalties;
    }

    public function setHomeTeamPenalties(?int $homeTeamPenalties): self
    {
        $this->homeTeamPenalties = $homeTeamPenalties;

        return $this;
    }

    public function getAwayTeamPenalties(): ?int
    {
        return $this->awayTeamPenalties;
    }

    public function setAwayTeamPenalties(?int $awayTeamPenalties): self
    {
        $this->awayTeamPenalties = $awayTeamPenalties;

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

    public function getMvp(): ?ManOfTheMatch
    {
        return $this->mvp;
    }

    public function setMvp(?ManOfTheMatch $mvp): self
    {
        $this->mvp = $mvp;

        // set (or unset) the owning side of the relation if necessary
        $newMatchDetails = $mvp === null ? null : $this;
        if ($newMatchDetails !== $mvp->getMatchDetails()) {
            $mvp->setMatchDetails($newMatchDetails);
        }

        return $this;
    }

    public function hasGoals(): bool
    {
        return !$this->getGoals()->isEmpty();
    }

    public function hasCards(): bool
    {
        return !$this->getCards()->isEmpty();
    }
}
