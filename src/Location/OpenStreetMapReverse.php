<?php

namespace AcMarche\EnquetePublique\Location;

use Exception;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * https://nominatim.org/release-docs/develop/api/Overview/
 * Class OpenStreetMapReverse.
 */
class OpenStreetMapReverse implements LocationReverseInterface
{
    private readonly string $baseUrl;

    private readonly HttpClientInterface $httpClient;

    private array $result = [];

    public function __construct()
    {
        $this->baseUrl = 'https://nominatim.openstreetmap.org/reverse';
        $this->httpClient = HttpClient::create();
    }

    /**
     * @param $latitude
     * @param $longitude
     *
     * @throws Exception
     */
    public function reverse($latitude, $longitude): array
    {
        sleep(1); //policy
        try {
            $request = $this->httpClient->request(
                'GET',
                $this->baseUrl,
                [
                    'query' => [
                        'format' => 'json',
                        'zoom' => 16,
                        'addressdetails' => 1,
                        'namedetails' => 0,
                        'extratags' => 0,
                        'lat' => $latitude,
                        'lon' => $longitude,
                    ],
                ]
            );

            $this->result = json_decode((string) $request->getContent(), true, 512, JSON_THROW_ON_ERROR);

            return $this->result;
        } catch (ClientException $clientException) {
            throw new Exception($clientException->getMessage(), $clientException->getCode(), $clientException);
        }
    }

    public function getRoad(): ?string
    {
        return $this->extractRoad();
    }

    protected function extractRoad(): ?string
    {
        $address = $this->result['address'];

        if (isset($address['road'])) {
            return $address['road'];
        }

        if (isset($address['pedestrian'])) {
            return $address['pedestrian'];
        }

        return $address['industrial'] ?? null;
    }

    public function getLocality(): ?string
    {
        return $this->result['address']['town'];
    }

    public function getHouseNumber(): ?string
    {
        $address = $this->result['address'];

        return $address['house_number'] ?? null;
    }

    /*
     * {
     * "place_id":188259342,
     * "licence":"Data © OpenStreetMap contributors, ODbL 1.0. https://osm.org/copyright",
     * "osm_type":"way",
     * "osm_id":458163018,
     * "lat":"50.23603135598228",
     * "lon":"5.36188848497033",
     * "display_name":"Chaussée de l'Ourthe, Marche-en-Famenne, Luxembourg, Wallonie, 6900, België - Belgique - Belgien",
     * "address":{
     * "road":"Chaussée de l'Ourthe",
     * "town":"Marche-en-Famenne",
     * "county":"Luxembourg",
     * "state":"Wallonie",
     * "postcode":"6900",
     * "country":"België - Belgique - Belgien",
     * "country_code":"be"
     * },
     * "boundingbox":[
     * "50.23454",
     * "50.2394055",
     * "5.3576441",
     * "5.3723272"
     * ]
     * }
     */
}
