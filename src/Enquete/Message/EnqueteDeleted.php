<?php

namespace AcMarche\EnquetePublique\Enquete\Message;

final class EnqueteDeleted
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
