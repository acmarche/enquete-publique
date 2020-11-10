<?php


namespace AcMarche\EnquetePublique\Entity\Traits;


use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

trait DatesDiffusionTrait
{
    /**
     * @var DateTimeInterface|null
     * @ORM\Column(type="date")
     */
    private $date_debut;

    /**
     * @var DateTimeInterface|null
     * @ORM\Column(type="date")
     */
    private $date_fin;

    /**
     * @return DateTimeInterface|null
     */
    public function getDateDebut(): ?DateTimeInterface
    {
        return $this->date_debut;
    }

    /**
     * @param DateTimeInterface|null $date_debut
     */
    public function setDateDebut(?DateTimeInterface $date_debut): void
    {
        $this->date_debut = $date_debut;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDateFin(): ?DateTimeInterface
    {
        return $this->date_fin;
    }

    /**
     * @param DateTimeInterface|null $date_fin
     */
    public function setDateFin(?DateTimeInterface $date_fin): void
    {
        $this->date_fin = $date_fin;
    }


}
