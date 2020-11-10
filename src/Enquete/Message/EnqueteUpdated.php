<?php

namespace AcMarche\EnquetePublique\Enquete\Message;

class EnqueteUpdated
{
    private $enqueteId;
    /**
     * @var string|null
     */
    private $oldRue;

    public function __construct(int $enqueteId, ?string $oldRue)
    {
        $this->enqueteId = $enqueteId;
        $this->oldRue = $oldRue;
    }

    public function getEnqueteId(): int
    {
        return $this->enqueteId;
    }

    /**
     * @return string|null
     */
    public function getOldRue(): ?string
    {
        return $this->oldRue;
    }

}
