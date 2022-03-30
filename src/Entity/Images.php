<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImagesRepository::class)
 */
class Images
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
     * @ORM\ManyToOne(targetEntity=Portfolio::class, inversedBy="images")
     */
    private $portfolio;

    /**
     * @ORM\ManyToOne(targetEntity=LMPages::class, inversedBy="images")
     */
    private $LMpages;

    /**
     * @ORM\ManyToOne(targetEntity=LMS::class, inversedBy="images")
     */
    private $LMS;

    /**
     * @ORM\ManyToOne(targetEntity=LUC::class, inversedBy="images")
     */
    private $LUC;

    /**
     * @ORM\ManyToOne(targetEntity=LUPages::class, inversedBy="images")
     */
    private $LUPages;

    /**
     * @ORM\ManyToOne(targetEntity=Monsters::class, inversedBy="images")
     */
    private $Monsters;

    /**
     * @ORM\ManyToOne(targetEntity=Characters::class, inversedBy="images")
     */
    private $Characters;

    /**
     * @ORM\ManyToOne(targetEntity=Actu::class, inversedBy="images")
     */
    private $Actu;

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

    public function getPortfolio(): ?Portfolio
    {
        return $this->portfolio;
    }

    public function setPortfolio(?Portfolio $portfolio): self
    {
        $this->portfolio = $portfolio;

        return $this;
    }

    public function getLMpages(): ?LMPages
    {
        return $this->LMpages;
    }

    public function setLMpages(?LMPages $LMpages): self
    {
        $this->LMpages = $LMpages;

        return $this;
    }

    public function getLMS(): ?LMS
    {
        return $this->LMS;
    }

    public function setLMS(?LMS $LMS): self
    {
        $this->LMS = $LMS;

        return $this;
    }

    public function getLUC(): ?LUC
    {
        return $this->LUC;
    }

    public function setLUC(?LUC $LUC): self
    {
        $this->LUC = $LUC;

        return $this;
    }

    public function getLUPages(): ?LUPages
    {
        return $this->LUPages;
    }

    public function setLUPages(?LUPages $LUPages): self
    {
        $this->LUPages = $LUPages;

        return $this;
    }

    public function getMonsters(): ?Monsters
    {
        return $this->Monsters;
    }

    public function setMonsters(?Monsters $Monsters): self
    {
        $this->Monsters = $Monsters;

        return $this;
    }

    public function getCharacters(): ?Characters
    {
        return $this->Characters;
    }

    public function setCharacters(?Characters $Characters): self
    {
        $this->Characters = $Characters;

        return $this;
    }

    public function getActu(): ?Actu
    {
        return $this->Actu;
    }

    public function setActu(?Actu $Actu): self
    {
        $this->Actu = $Actu;

        return $this;
    }
}
