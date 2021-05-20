<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 * @UniqueEntity("name", message="Taka nazwa drużyny jest już zajęta.")
 * @Vich\Uploadable
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
     * @Assert\NotNull(message="Proszę podać nazwę drużyny.")
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
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(
     *     mapping="team_crest_image",
     *     fileNameProperty="crest.name",
     *     size="crest.size",
     *     mimeType="crest.mimeType",
     *     originalName="crest.originalName",
     *     dimensions="crest.dimensions"
     * )
     *
     * @var File
     */
    private $crestFile;

    /**
     * @ORM\Embedded(class="Vich\UploaderBundle\Entity\File")
     *
     * @var EmbeddedFile
     */
    private $crest;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(
     *     mapping="team_photo_image",
     *     fileNameProperty="photo.name",
     *     size="photo.size",
     *     mimeType="photo.mimeType",
     *     originalName="photo.originalName",
     *     dimensions="photo.dimensions"
     * )
     *
     * @var File
     */
    private $photoFile;

    /**
     * @ORM\Embedded(class="Vich\UploaderBundle\Entity\File")
     *
     * @var EmbeddedFile
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

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Season", inversedBy="teams")
     */
    private $season;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;

    public function __construct()
    {
        $this->players = new ArrayCollection();
        $this->homeFootballMatch = new ArrayCollection();
        $this->awayFootballMatch = new ArrayCollection();
        $this->crest = new EmbeddedFile();
        $this->photo = new EmbeddedFile();
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

    public function getCrest(): ?EmbeddedFile
    {
        return $this->crest;
    }

    public function setCrest(EmbeddedFile $crest): self
    {
        $this->crest = $crest;

        return $this;
    }

    public function getPhoto(): ?EmbeddedFile
    {
        return $this->photo;
    }

    public function setPhoto(EmbeddedFile $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @param File|UploadedFile $imageFile
     */
    public function setCrestFile(?File $crestFile = null)
    {
        $this->crestFile = $crestFile;

        if (null !== $crestFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getCrestFile(): ?File
    {
        return $this->crestFile;
    }

    /**
     * @param File|UploadedFile $imageFile
     */
    public function setPhotoFile(?File $photoFile = null)
    {
        $this->photoFile = $photoFile;

        if (null !== $photoFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getPhotoFile(): ?File
    {
        return $this->photoFile;
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
        $this->winsAfterPenalties++;
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

    public function getSeason(): ?Season
    {
        return $this->season;
    }

    public function setSeason(?Season $season): self
    {
        $this->season = $season;

        return $this;
    }

    public function canBeDeleted(): bool
    {
        return $this->getAwayFootballMatch()->isEmpty() && $this->getHomeFootballMatch()->isEmpty();
    }

    public function addDraw(): void
    {
        $this->draws++;
        $this->addPoints(1);
    }
}
