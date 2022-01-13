<?php

namespace AcMarche\EnquetePublique\Enquete\Message;

class EnqueteCreated
{
    public function __construct(private int $enqueteId)
    {
    }

    public function getEnqueteId(): int
    {
        return $this->enqueteId;
    }
}
