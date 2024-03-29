<?php

namespace AcMarche\EnquetePublique\Enquete\MessageHandler;

use AcMarche\EnquetePublique\Enquete\Message\EnqueteUpdated;
use AcMarche\EnquetePublique\Location\LocationUpdater;
use AcMarche\EnquetePublique\Repository\EnqueteRepository;
use Exception;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
class EnqueteUpdatedHandler
{
    private FlashBagInterface $flashBag;

    public function __construct(
        private EnqueteRepository $enqueteRepository,
        private LocationUpdater $locationUpdater,
        RequestStack $requestStack
    ) {
        $this->flashBag = $requestStack->getSession()->getFlashBag();
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
