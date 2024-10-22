<?php

namespace App\Controller;

use App\Helpers\QueryHelper;
use App\Services\GraphQLClient;
use App\Services\Random;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/test', name: 'test_')]
class TestController extends AbstractController 
{
    #[Route('/', name: 'index')]
    public function index(GraphQLClient $client, QueryHelper $queryHelper): Response
    {
        $characterId = Random::getRandomNumber(1, 826);
        $query = $queryHelper->getCharacterInfo($characterId);

        $info = $client->request('https://rickandmortyapi.com/graphql', $query, 'charactersByIds');

        return $this->render(
            'test/index.html.twig',
            current($info)
        );
    }

    #[Route('/show', name: 'show')]
    public function show(GraphQLClient $client, QueryHelper $queryHelper): Response
    {
        $type = 'location';

        switch ($type) {
            case 'episode':
                // $episode = 'Pilot';
                $episode = 'Interdimensional Cable 2: Tempting Fate';
                $query = $queryHelper->getEpisode($episode);
                $description = sprintf('Characters in episode "%s"', $episode);

                $data = $client->request('https://rickandmortyapi.com/graphql', $query, 'episodes');

                $results = current($data['results'])['characters'];

                break;
            case 'location':
                $location = "Citadel of Ricks";
                $query = $queryHelper->getLocation($location);
                $description = sprintf('Characters @ "%s"', $location);
        
                $data = $client->request('https://rickandmortyapi.com/graphql', $query, 'locations');

                $results = current($data['results'])['residents'];
                break;
                    
            }



        return $this->render(
            'test/overview.html.twig',
            [
                'description' => $description,
                'info' => $data['info'],
                'results' => $results,
            ]
        );
    }
}
