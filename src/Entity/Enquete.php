<?php


namespace AcMarche\EnquetePublique\Entity;

use AcMarche\EnquetePublique\Entity\Traits\AvisFileTrait;
use AcMarche\EnquetePublique\Entity\Traits\DatesDiffusionTrait;
use AcMarche\EnquetePublique\Entity\Traits\LocationTrait;
use AcMarche\EnquetePublique\Location\LocationAbleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TimestampableInterface;
use Knp\DoctrineBehaviors\Model\Timestampable\TimestampableTrait;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="AcMarche\EnquetePublique\Repository\EnqueteRepository")
 *
 * @Vich\Uploadable
 */
class Enquete implements TimestampableInterface, LocationAbleInterface
{
    use LocationTrait;
    use DatesDiffusionTrait;
    use TimestampableTrait;
    use AvisFileTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private $intitule;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private $demandeur;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="enquetes")
     * @ORM\JoinColumn(nullable=true)
     */
    private $categorie;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="AcMarche\EnquetePublique\Entity\Document", mappedBy="enquete", cascade={"persist", "remove"})
     */
    private $documents;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
        $this->code_postal = 6900;
        $this->date_debut = new \DateTime();
        $this->date_fin = new \DateTime('+1 month');
    }

    public function __toString()
    {
        return $this->demandeur;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDemandeur(): ?string
    {
        return $this->demandeur;
    }

    public function setDemandeur(string $demandeur): self
    {
        $this->demandeur = $demandeur;

        return $this;
    }

    /**
     * @return Collection|Document[]
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setEnquete($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getEnquete() === $this) {
                $document->setEnquete(null);
            }
        }

        return $this;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

}
