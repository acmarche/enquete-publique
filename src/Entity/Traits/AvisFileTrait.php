<?php

namespace AcMarche\EnquetePublique\Entity\Traits;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

trait AvisFileTrait
{
    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="avis_file", fileNameProperty="avisName", size="avisSize")
     *
     * @var File|null
     */
    #[Assert\File(maxSize: '16384k', mimeTypes: ['application/pdf', 'application/x-pdf', 'image/*'], mimeTypesMessage: 'Uniquement des PDF ou images')]
    private $avisFile;

    /**
     * @var string|null
     */
    #[ORM\Column(type: 'string', nullable: true)]
    private $avisName;

    /**
     * @var int|null
     */
    #[ORM\Column(type: 'integer', nullable: true)]
    private $avisSize;

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     */
    public function setAvisFile(?File $avisFile = null): void
    {
        $this->avisFile = $avisFile;

        if (null !== $avisFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTimeImmutable();
        }
    }

    public function getAvisFile(): ?File
    {
        return $this->avisFile;
    }

    public function setAvisName(?string $avisName): void
    {
        $this->avisName = $avisName;
    }

    public function getAvisName(): ?string
    {
        return $this->avisName;
    }

    public function setAvisSize(?int $avisSize): void
    {
        $this->avisSize = $avisSize;
    }

    public function getAvisSize(): ?int
    {
        return $this->avisSize;
    }
}
