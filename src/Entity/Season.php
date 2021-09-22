<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SeasonRepository")
 * @UniqueEntity("league", message="Sezon może być przypisany tylko do jednej ligi")
 */
class Season
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
     * @ORM\ManyToOne(targetEntity="App\Entity\League", inversedBy="seasons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $league;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Team", mappedBy="season")
     */
    private $teams;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MatchDay", mappedBy="season")
     */
    private $matchDays;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->matchDays = new ArrayCollection();
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

    public function getLeague(): ?League
    {
        return $this->league;
    }

    public function setLeague(?League $league): self
    {
        $this->league = $league;

        return $this;
    }

    /**
     * @return Collection|Team[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
            $team->setSeason($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
            // set the owning side to null (unless already changed)
            if ($team->getSeason() === $this) {
                $team->setSeason(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MatchDay[]
     */
    public function getMatchDays(): Collection
    {
        return $this->matchDays;
    }

    public function addMatchDay(MatchDay $matchDay): self
    {
        if (!$this->matchDays->contains($matchDay)) {
            $this->matchDays[] = $matchDay;
            $matchDay->setSeason($this);
        }

        return $this;
    }

    public function removeMatchDay(MatchDay $matchDay): self
    {
        if ($this->matchDays->contains($matchDay)) {
            $this->matchDays->removeElement($matchDay);
            // set the owning side to null (unless already changed)
            if ($matchDay->getSeason() === $this) {
                $matchDay->setSeason(null);
            }
        }

        return $this;
    }
}
