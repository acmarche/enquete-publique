<?php


namespace AcMarche\EnquetePublique\Location;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class LocationUpdater
{
    /**
     * @var LocationInterface
     */
    private $location;

    public function __construct(LocationInterface $location)
    {
        $this->location = $location;
    }

    /**
     * @param LocationAbleInterface $object
     * @return bool
     * @throws \Exception
     */
    public function convertAddressToCoordinates(LocationAbleInterface $object): bool
    {
        if (!$object->getRue()) {
            throw new \Exception('Aucune rue encodée, pas de données de géolocalisation');
        }

        try {
            $response = $this->location->search($this->getAdresseString($object));

            //todo JSON_THROW_ON_ERROR 7.4
            $tab = json_decode($response, true);

            if (is_array($tab) && count($tab) == 0) {
                throw new \Exception('L\'adresse n\'a pas pu être convertie en latitude longitude:'.$response);
            }

            if ($tab == false) {
                throw new \Exception('Decode json error:'.$response);
            }

            if (is_array($tab) && count($tab) > 0) {
                $this->setLat($object, $tab);

                return true;
            } else {
                throw new \Exception('Convertion en latitude longitude error:'.$response);
            }
        } catch (ClientExceptionInterface $e) {
            throw new \Exception($e->getMessage());
        } catch (RedirectionExceptionInterface $e) {
            throw new \Exception($e->getMessage());
        } catch (ServerExceptionInterface $e) {
            throw new \Exception($e->getMessage());
        } catch (TransportExceptionInterface $e) {
            throw new \Exception($e->getMessage());
        }
    }

    private function setLat(LocationAbleInterface $object, array $data)
    {
        $object->setLatitude($data[0]['lat']);
        $object->setLongitude($data[0]['lon']);
    }

    private function getAdresseString(LocationAbleInterface $object): string
    {
        return $object->getNumero().' '.
            $object->getRue().', '.
            $object->getCodePostal().' '.
            $object->getLocalite();
    }

}
