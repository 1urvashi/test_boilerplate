<?php
namespace App\Service;

use GuzzleHttp\Client;

class GooglePlacesService
{
    private $client;
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->client = new Client([
            'base_uri' => 'https://maps.googleapis.com/maps/api/place/',
        ]);
        $this->apiKey = $apiKey;
    }

    public function getNearbyLocations(float $latitude, float $longitude)
    {
        $response = $this->client->request('GET', 'nearbysearch/json', [
            'query' => [
                'key' => $this->apiKey,
                'location' => $latitude . ',' . $longitude,
                'radius' => 1000, // 1km radius
                // You can add more parameters as needed
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);

        if (!isset($data['results'])) {
            return []; // Return empty array if no results found
        }

        $nearbyLocations = [];

        foreach ($data['results'] as $result) {
            $location = [
                'name' => $result['name'],
                'address' => $result['vicinity']
            ];
            $nearbyLocations[] = $location;
        }

        return $nearbyLocations;
    }
}
