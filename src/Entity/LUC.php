<?php

namespace App\Entity;

use App\Repository\LUCRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=LUCRepository::class)
 * @ORM\Table(name="luc", indexes={@ORM\Index(columns={"name"}, flags={"fulltext"})})
 */
class LUC
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
     * @ORM\OneToMany(targetEntity=LUPages::class, mappedBy="chapter")
     */
    private $lUPages;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="LUC", orphanRemoval=true, cascade={"persist"})
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="chapter")
     */
    private $comments;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->lUPages = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->comments = new ArrayCollection();
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
     * @return Collection|LUPages[]
     */
    public function getLUPages(): Collection
    {
        return $this->lUPages;
    }

    public function addLUPage(LUPages $lUPage): self
    {
        if (!$this->lUPages->contains($lUPage)) {
            $this->lUPages[] = $lUPage;
            $lUPage->setChapter($this);
        }

        return $this;
    }

    public function removeLUPage(LUPages $lUPage): self
    {
        if ($this->lUPages->removeElement($lUPage)) {
            // set the owning side to null (unless already changed)
            if ($lUPage->getChapter() === $this) {
                $lUPage->setChapter(null);
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
            $image->setLUC($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getLUC() === $this) {
                $image->setLUC(null);
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
            $comment->setChapter($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getChapter() === $this) {
                $comment->setChapter(null);
            }
        }

        return $this;
    }
}
