<?php

namespace App\Entity;

use App\Repository\LUPagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LUPagesRepository::class)
 */
class LUPages
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=LUC::class, inversedBy="lUPages")
     */
    private $chapter;

    /**
     * @ORM\Column(type="integer")
     */
    private $pagesNumbers;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="LUPages", orphanRemoval=true, cascade={"persist"})
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

    public function getChapter(): ?LUC
    {
        return $this->chapter;
    }

    public function setChapter(?LUC $chapter): self
    {
        $this->chapter = $chapter;

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
            $image->setLUPages($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getLUPages() === $this) {
                $image->setLUPages(null);
            }
        }

        return $this;
    }
}
