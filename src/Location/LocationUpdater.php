<?php

namespace AcMarche\EnquetePublique\Location;

use Exception;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class LocationUpdater
{
    public function __construct(private LocationInterface $location)
    {
    }

    /**
     * @throws Exception
     */
    public function convertAddressToCoordinates(LocationAbleInterface $object): bool
    {
        if (!$object->getRue()) {
            throw new Exception('Aucune rue encodée, pas de données de géolocalisation');
        }

        try {
            $response = $this->location->search($this->getAdresseString($object));

            $tab = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

            if (\is_array($tab) && 0 == \count($tab)) {
                throw new Exception('L\'adresse n\'a pas pu être convertie en latitude longitude:'.$response);
            }

            if (false == $tab) {
                throw new Exception('Decode json error:'.$response);
            }

            if (\is_array($tab) && [] !== $tab) {
                $this->setLat($object, $tab);

                return true;
            } else {
                throw new Exception('Convertion en latitude longitude error:'.$response);
            }
        } catch (ClientExceptionInterface|ServerExceptionInterface|RedirectionExceptionInterface|TransportExceptionInterface $e) {
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    private function setLat(LocationAbleInterface $object, array $data): void
    {
        $object->setLatitude($data[0]['lat']);
        $object->setLongitude($data[0]['lon']);
    }

    private function getAdresseString(LocationAbleInterface $object): string
    {
        return $object->getNumero().' LocationUpdater.php'.
            $object->getRue().', '.
            $object->getCodePostal().' '.
            $object->getLocalite();
    }
}
