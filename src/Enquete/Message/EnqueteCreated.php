<?php

namespace AcMarche\EnquetePublique\Enquete\Message;

class EnqueteCreated
{
    private $enqueteId;

    public function __construct(int $enqueteId)
    {
        $this->enqueteId = $enqueteId;
    }

    public function getEnqueteId(): int
    {
        return $this->enqueteId;
    }

}
