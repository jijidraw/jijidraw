<?php

namespace App\Entity;

use App\Repository\LMPagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LMPagesRepository::class)
 */
class LMPages
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=LMS::class, inversedBy="lMPages")
     */
    private $story;

    /**
     * @ORM\Column(type="integer")
     */
    private $pagesNumbers;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="LMpages", orphanRemoval=true, cascade={"persist"})
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStory(): ?LMS
    {
        return $this->story;
    }

    public function setStory(?LMS $story): self
    {
        $this->story = $story;

        return $this;
    }

    public function getPagesNumbers(): ?int
    {
        return $this->pagesNumbers;
    }

    public function setPagesNumbers(int $pagesNumbers): self
    {
        $this->pagesNumbers = $pagesNumbers;

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
            $image->setLMpages($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getLMpages() === $this) {
                $image->setLMpages(null);
            }
        }

        return $this;
    }
}
