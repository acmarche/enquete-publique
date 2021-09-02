<?php


namespace AcMarche\EnquetePublique\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AcMarche\EnquetePublique\Repository\CategorieRepository")
 *
 */
class Categorie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string")
     */
    private ?string $nom = null;

    /**
     * @ORM\OneToMany(targetEntity=Enquete::class, mappedBy="categorie", orphanRemoval=true)
     */
    private iterable $enquetes;

    public function __construct()
    {
        $this->enquetes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nom;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|Enquete[]
     */
    public function getEnquetes(): iterable
    {
        return $this->enquetes;
    }

    public function addEnquete(Enquete $enquete): self
    {
        if (!$this->enquetes->contains($enquete)) {
            $this->enquetes[] = $enquete;
            $enquete->setCategorie($this);
        }

        return $this;
    }

    public function removeEnquete(Enquete $enquete): self
    {
        // set the owning side to null (unless already changed)
        if ($this->enquetes->removeElement($enquete) && $enquete->getCategorie() === $this) {
            $enquete->setCategorie(null);
        }

        return $this;
    }

}
