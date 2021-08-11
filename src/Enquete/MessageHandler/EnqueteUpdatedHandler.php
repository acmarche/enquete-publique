<?php

namespace AcMarche\EnquetePublique\Enquete\MessageHandler;

use Exception;
use AcMarche\EnquetePublique\Enquete\Message\EnqueteUpdated;
use AcMarche\EnquetePublique\Location\LocationUpdater;
use AcMarche\EnquetePublique\Repository\EnqueteRepository;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class EnqueteUpdatedHandler implements MessageHandlerInterface
{
    private EnqueteRepository $enqueteRepository;
    private FlashBagInterface $flashBag;
    private LocationUpdater $locationUpdater;

    public function __construct(
        EnqueteRepository $enqueteRepository,
        LocationUpdater $locationUpdater,
        FlashBagInterface $flashBag
    ) {
        $this->enqueteRepository = $enqueteRepository;
        $this->flashBag = $flashBag;
        $this->locationUpdater = $locationUpdater;
    }

    public function __invoke(EnqueteUpdated $enqueteCreated)
    {
        $this->flashBag->add('success', 'L\'enquête a bien été modifiée');

        $enquete = $this->enqueteRepository->find($enqueteCreated->getEnqueteId());
        $oldRue = $enqueteCreated->getOldRue();

        if ($oldRue !== $enquete->getRue()) {
            try {
                $this->locationUpdater->convertAddressToCoordinates($enquete);
                $this->enqueteRepository->flush();
            } catch (Exception $e) {
                $this->flashBag->add(
                    'danger',
                    $e->getMessage()
                );
            }
        }
    }

}
