<?php

namespace App\Helpers;

use App\Services\GraphQLClient;

class DataCollector
{
    private CharacterCollection $collection;

    public function __construct(private GraphQLClient $client, private QueryHelper $queryHelper)
    {
        $this->collection = new CharacterCollection();
    }

    public function collect(string $type, string $query): CharacterCollection
    {
        $this->collection->setType($type);
        $this->collection->setDescription($query);

        switch ($type) {
            case 'episode':
                $this->getEpisode($query);

                break;
            case 'location':
                $this->getLocation($query);

                break;

            case 'dimension':
                $this->getDimension($query);
                break;
                        
            }
        
        return $this->collection;
    }

    private function getEpisode(string $query): void
    {
        $query = $this->queryHelper->getEpisode($query);

        $data = $this->client->request('https://rickandmortyapi.com/graphql', $query, 'episodes');

        $this->collection->setData(current($data['results'])['characters']);
        $this->collection->setInfo($data['info']);
    }

    private function getLocation(string $query): void
    {
        $query = $this->queryHelper->getLocation($query);

        $data = $this->client->request('https://rickandmortyapi.com/graphql', $query, 'locations');

        $this->collection->setData(current($data['results'])['residents']);
        $this->collection->setInfo($data['info']);
    }

    private function getDimension(string $query): void
    {
        $query = $this->queryHelper->getDimension($query);

        $data = $this->client->request('https://rickandmortyapi.com/graphql', $query, 'locations');

        // Flatten resulting array
        $results = [];
        foreach($data['results'] as $part) {
            $results += $part['residents'];
        }

        $this->collection->setData($results);
        $this->collection->setInfo($data['info']);
    }
}
