<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LeagueRepository")
 */
class League
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Season", mappedBy="league")
     */
    private $seasons;

//    /**
//     * @ORM\Column(type="boolean")
//     */
//    private $isPlayOff = false;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $mainRoundStandings;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isFinished = false;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $mainRoundStatistics;

//    /**
//     * @ORM\OneToOne(targetEntity="App\Entity\League", cascade={"persist", "remove"})
//     */
//    private $playOffLeague;

    public function __construct()
    {
        $this->seasons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Season[]
     */
    public function getSeasons(): Collection
    {
        return $this->seasons;
    }

    public function addSeason(Season $season): self
    {
        if (!$this->seasons->contains($season)) {
            $this->seasons[] = $season;
            $season->setLeague($this);
        }

        return $this;
    }

    public function removeSeason(Season $season): self
    {
        if ($this->seasons->contains($season)) {
            $this->seasons->removeElement($season);
            // set the owning side to null (unless already changed)
            if ($season->getLeague() === $this) {
                $season->setLeague(null);
            }
        }

        return $this;
    }

    public function hasTeams(): bool
    {
        foreach ($this->getSeasons() as $season) {
            if ($season->getTeams()->count() > 0) {
                return true;
            }
        }

        return false;
    }

    public function getMainRoundStandings(): ?string
    {
        return $this->mainRoundStandings;
    }

    public function setMainRoundStandings(?string $mainRoundStandings): self
    {
        $this->mainRoundStandings = $mainRoundStandings;

        return $this;
    }

    public function isFinished(): bool
    {
        return $this->isFinished;
    }

    public function setIsFinished(bool $isFinished): void
    {
        $this->isFinished = $isFinished;
    }

    public function getMainRoundStatistics(): ?string
    {
        return $this->mainRoundStatistics;
    }

    public function setMainRoundStatistics(?string $mainRoundStatistics): self
    {
        $this->mainRoundStatistics = $mainRoundStatistics;

        return $this;
    }
}
