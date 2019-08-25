<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContext;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FootballMatchRepository")
 */
class FootballMatch
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

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
     * @Assert\Valid()
     * @ORM\OneToOne(targetEntity="App\Entity\MatchDetails", inversedBy="footballMatch", cascade={"persist", "remove"})
     */
    private $matchDetails;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="homeFootballMatch")
     * @ORM\JoinColumn(nullable=false)
     */
    private $homeTeam;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="awayFootballMatch")
     * @ORM\JoinColumn(nullable=false)
     */
    private $awayTeam;

    /**
     * @ORM\Column(type="boolean")
     */
    private $completeStats = 0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MatchDay", inversedBy="matches")
     */
    private $matchDay;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMatchDetails(): ?MatchDetails
    {
        return $this->matchDetails;
    }

    public function setMatchDetails(?MatchDetails $matchDetails): self
    {
        $this->matchDetails = $matchDetails;

        return $this;
    }

    public function getHomeTeam(): ?Team
    {
        return $this->homeTeam;
    }

    public function setHomeTeam(?Team $homeTeam): self
    {
        $this->homeTeam = $homeTeam;

        return $this;
    }

    public function getAwayTeam(): ?Team
    {
        return $this->awayTeam;
    }

    public function setAwayTeam(?Team $awayTeam): self
    {
        $this->awayTeam = $awayTeam;

        return $this;
    }

    public function isFixture(): bool
    {
        return $this->startDate > new \DateTime();
    }

    public function hasCompleteStats(): ?bool
    {
        return $this->completeStats;
    }

    public function setCompleteStats(bool $completeStats): self
    {
        $this->completeStats = $completeStats;

        return $this;
    }

    /**
     * @Assert\Callback()
     */
    public function validateTeams(ExecutionContextInterface $context)
    {
        if ($this->homeTeam === $this->awayTeam) {
            $context
                ->buildViolation('Te same drużyny nie mogą grać ze sobą meczu')
                ->atPath('homeTeam')
                ->addViolation();
        }
    }

    public function getMatchDay(): ?MatchDay
    {
        return $this->matchDay;
    }

    public function setMatchDay(?MatchDay $matchDay): self
    {
        $this->matchDay = $matchDay;

        return $this;
    }
}
