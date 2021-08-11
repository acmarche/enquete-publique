<?php


namespace AcMarche\EnquetePublique\Location;


use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class LocationOpenStreetMap implements LocationInterface
{
    private string $baseUrl;
    private HttpClientInterface $client;

    public function __construct()
    {
        $this->baseUrl = 'https://nominatim.openstreetmap.org/search';
        $this->client = HttpClient::create();
    }

    /**
     * @param string $query
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function search(string $query): string
    {
        $response = $this->client->request(
            'GET',
            $this->baseUrl,
            [
                'query' => [
                    'format' => 'json',
                    'q' => $query.' Belgium',
                    'addressdetails' => 1,
                ],
            ]
        );

        return $response->getContent();
    }

}
