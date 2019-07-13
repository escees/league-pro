<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 */
class Player
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $appearances;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateOfBirth;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="players")
     */
    private $team;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MatchEvent", mappedBy="player")
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAppearances(): ?int
    {
        return $this->appearances;
    }

    public function setAppearances(?int $appearances): self
    {
        $this->appearances = $appearances;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

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
            $matchEvent->setPlayer($this);
        }

        return $this;
    }

    public function removeMatchEvent(MatchEvent $matchEvent): self
    {
        if ($this->matchEvents->contains($matchEvent)) {
            $this->matchEvents->removeElement($matchEvent);
            // set the owning side to null (unless already changed)
            if ($matchEvent->getPlayer() === $this) {
                $matchEvent->setPlayer(null);
            }
        }

        return $this;
    }
}
