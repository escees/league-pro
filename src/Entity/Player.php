<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 * @Vich\Uploadable
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
     * @Assert\NotNull(message="Proszę podać imię i nazwisko zawodnika.")
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @Groups({"standings"})
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
     * @Assert\NotNull(message="Proszę wybrac drużynę dla zawodnika.")
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", inversedBy="players")
     */
    private $team;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Goal", mappedBy="scorer")
     */
    private $goals;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Card", mappedBy="player")
     */
    private $cards;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Goal", mappedBy="assistant")
     */
    private $assists;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $position;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $number;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(
     *     mapping="player_photo_image",
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
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ManOfTheMatch", mappedBy="player")
     */
    private $mvps;

    public function __construct()
    {
        $this->goals = new ArrayCollection();
        $this->cards = new ArrayCollection();
        $this->assists = new ArrayCollection();
        $this->photo = new EmbeddedFile();
        $this->mvps = new ArrayCollection();
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
            $goal->setScorer($this);
        }

        return $this;
    }

    public function removeGoal(Goal $goal): self
    {
        if ($this->goals->contains($goal)) {
            $this->goals->removeElement($goal);
            // set the owning side to null (unless already changed)
            if ($goal->getScorer() === $this) {
                $goal->setScorer(null);
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
            $card->setPlayer($this);
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
            // set the owning side to null (unless already changed)
            if ($card->getPlayer() === $this) {
                $card->setPlayer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Goal[]
     */
    public function getAssists(): Collection
    {
        return $this->assists;
    }

    public function addAssist(Goal $assist): self
    {
        if (!$this->assists->contains($assist)) {
            $this->assists[] = $assist;
            $assist->setAssistant($this);
        }

        return $this;
    }

    public function removeAssist(Goal $assist): self
    {
        if ($this->assists->contains($assist)) {
            $this->assists->removeElement($assist);
            // set the owning side to null (unless already changed)
            if ($assist->getAssistant() === $this) {
                $assist->setAssistant(null);
            }
        }

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(?int $number): self
    {
        $this->number = $number;

        return $this;
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
     * @return Collection|ManOfTheMatch[]
     */
    public function getMvps(): Collection
    {
        return $this->mvps;
    }

    public function addMvp(ManOfTheMatch $mvp): self
    {
        if (!$this->mvps->contains($mvp)) {
            $this->mvps[] = $mvp;
            $mvp->setPlayer($this);
        }

        return $this;
    }

    public function removeMvp(ManOfTheMatch $mvp): self
    {
        if ($this->mvps->contains($mvp)) {
            $this->mvps->removeElement($mvp);
            // set the owning side to null (unless already changed)
            if ($mvp->getPlayer() === $this) {
                $mvp->setPlayer(null);
            }
        }

        return $this;
    }
}
