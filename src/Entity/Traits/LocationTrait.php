<?php

namespace AcMarche\EnquetePublique\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait LocationTrait
{
    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private $rue;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private $numero;

    /**
     * @var int|null
     * @ORM\Column(type="integer", nullable=false)
     */
    private $code_postal;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private $localite;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private $longitude;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private $latitude;

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(?string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(?string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCodePostal(): ?int
    {
        return $this->code_postal;
    }

    /**
     * @param int|null $code_postal
     */
    public function setCodePostal(?int $code_postal): void
    {
        $this->code_postal = $code_postal;
    }

    public function getLocalite(): ?string
    {
        return $this->localite;
    }

    public function setLocalite(?string $localite): self
    {
        $this->localite = $localite;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }
}
