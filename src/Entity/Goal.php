<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Player", inversedBy="goals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $scorer;

    //@todo add handling form errors for collection fields in edit result form
    /**
     * @Assert\NotBlank(message="Proszę podać minutę w której padła bramka")
     * @Assert\GreaterThan(value="0", message="Minuta musi być większa od zera")
     *
     * @ORM\Column(type="integer")
     */
    private $minute;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MatchDetails", inversedBy="goals")
     * @ORM\JoinColumn(nullable=true)
     */
    private $matchDetails;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Player", inversedBy="assists")
     */
    private $assistant;

    public function getId(): ?int
    {
        return $this->id;
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

    public function setMinute(?int $minute): self
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

    public function getAssistant(): ?Player
    {
        return $this->assistant;
    }

    public function setAssistant(?Player $assistant): self
    {
        $this->assistant = $assistant;

        return $this;
    }
}
