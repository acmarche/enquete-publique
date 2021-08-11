<?php

namespace AcMarche\EnquetePublique\Enquete\MessageHandler;

use AcMarche\EnquetePublique\Enquete\Message\EnqueteDeleted;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class EnqueteDeletedHandler implements MessageHandlerInterface
{
    private FlashBagInterface $flashBag;

    public function __construct(FlashBagInterface $flashBag)
    {
        $this->flashBag = $flashBag;
    }

    public function __invoke(EnqueteDeleted $enqueteDeleted)
    {
        $this->flashBag->add('success', 'L\'enquête a bien été supprimée');
    }
}
