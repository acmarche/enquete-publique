<?php

namespace AcMarche\EnquetePublique\Enquete\MessageHandler;

use Exception;
use AcMarche\EnquetePublique\Enquete\Message\EnqueteCreated;
use AcMarche\EnquetePublique\Entity\Enquete;
use AcMarche\EnquetePublique\Location\LocationUpdater;
use AcMarche\EnquetePublique\Repository\EnqueteRepository;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class EnqueteCreatedHandler implements MessageSubscriberInterface
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

    public function __invoke(EnqueteCreated $enqueteCreated)
    {
        $enquete = $this->enqueteRepository->find($enqueteCreated->getEnqueteId());
        $this->flashBag->add('success','L\'enquête a bien été ajoutée');
        $this->setLocation($enquete);
        $this->enqueteRepository->flush();
    }

    private function setLocation(Enquete $enquete): void
    {
        try {
            $this->locationUpdater->convertAddressToCoordinates($enquete);
        } catch (Exception $e) {
            $this->flashBag->add(
                'danger',
                $e->getMessage()
            );
        }
    }

    /**
     * @inheritDoc
     */
    public static function getHandledMessages(): iterable
    {
        // handle this message on __invoke
        yield EnqueteCreated::class;

        // also handle this message on handleOtherSmsNotification
        yield EnqueteCreated::class => [
            //  'method' => 'handleElastic',
            //'priority' => 0,
            //'bus' => 'messenger.bus.default',
        ];
    }
}
