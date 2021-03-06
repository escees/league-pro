<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CardRepository")
 */
class Card
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Choice(
     *     choices={"yellow", "red"}
     * )
     *
     * @ORM\Column(type="string", length=255)
     */
    private $color;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Player", inversedBy="cards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    //@todo add handling form errors for collection fields in edit result form
    /**
     * @Assert\NotBlank(message="Proszę podać minutę w której padła bramka")
     * @Assert\GreaterThan(value="0", message="Minuta musi być większa od zera")
     *
     * @ORM\Column(type="integer")
     */
    private $minute;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MatchDetails", inversedBy="cards")
     * @ORM\JoinColumn(nullable=true)
     */
    private $matchDetails;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

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
