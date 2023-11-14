<?php

namespace AcMarche\EnquetePublique\Entity\Traits;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

trait DatesDiffusionTrait
{
    #[ORM\Column(type: 'date')]
    private DateTimeInterface|null $date_debut;

    #[ORM\Column(type: 'date')]
    private DateTimeInterface|null $date_fin;

    public function getDateDebut(): ?DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(?DateTimeInterface $date_debut): void
    {
        $this->date_debut = $date_debut;
    }

    public function getDateFin(): ?DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(?DateTimeInterface $date_fin): void
    {
        $this->date_fin = $date_fin;
    }
}
