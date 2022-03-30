<?php

namespace App\Entity;

use App\Repository\LMSRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=LMSRepository::class)
 */
class LMS
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $numbers;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_valid;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=LMPages::class, mappedBy="story")
     */
    private $lMPages;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="LMS", orphanRemoval=true, cascade={"persist"})
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="story")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=Monsters::class, mappedBy="story")
     */
    private $monsters;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->lMPages = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->monsters = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->name;
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

    public function getNumbers(): ?int
    {
        return $this->numbers;
    }

    public function setNumbers(int $numbers): self
    {
        $this->numbers = $numbers;

        return $this;
    }

    public function getIsValid(): ?bool
    {
        return $this->is_valid;
    }

    public function setIsValid(bool $is_valid): self
    {
        $this->is_valid = $is_valid;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|LMPages[]
     */
    public function getLMPages(): Collection
    {
        return $this->lMPages;
    }

    public function addLMPage(LMPages $lMPage): self
    {
        if (!$this->lMPages->contains($lMPage)) {
            $this->lMPages[] = $lMPage;
            $lMPage->setStory($this);
        }

        return $this;
    }

    public function removeLMPage(LMPages $lMPage): self
    {
        if ($this->lMPages->removeElement($lMPage)) {
            // set the owning side to null (unless already changed)
            if ($lMPage->getStory() === $this) {
                $lMPage->setStory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Images[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setLMS($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getLMS() === $this) {
                $image->setLMS(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setStory($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getStory() === $this) {
                $comment->setStory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Monsters[]
     */
    public function getMonsters(): Collection
    {
        return $this->monsters;
    }

    public function addMonster(Monsters $monster): self
    {
        if (!$this->monsters->contains($monster)) {
            $this->monsters[] = $monster;
            $monster->setStory($this);
        }

        return $this;
    }

    public function removeMonster(Monsters $monster): self
    {
        if ($this->monsters->removeElement($monster)) {
            // set the owning side to null (unless already changed)
            if ($monster->getStory() === $this) {
                $monster->setStory(null);
            }
        }

        return $this;
    }
}
