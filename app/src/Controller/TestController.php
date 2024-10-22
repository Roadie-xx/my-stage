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
        // $episode = 'Pilot';
        $episode = 'Interdimensional Cable 2: Tempting Fate';

        $query = $queryHelper->getEpisode($episode);

        $data = $client->request('https://rickandmortyapi.com/graphql', $query, 'episodes');

        return $this->render(
            'test/overview.html.twig',
            [
                'description' => sprintf('Characters in episode "%s"', $episode),
                'info' => $data['info'],
                'results' => current($data['results'])['characters'],
            ]
        );
    }
}
