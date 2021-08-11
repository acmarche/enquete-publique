<?php

namespace AcMarche\EnquetePublique\Enquete\Message;

class EnqueteCreated
{
    private int $enqueteId;

    public function __construct(int $enqueteId)
    {
        $this->enqueteId = $enqueteId;
    }

    public function getEnqueteId(): int
    {
        return $this->enqueteId;
    }

}
