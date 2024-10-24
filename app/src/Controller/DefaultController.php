<?php

namespace App\Controller;

use App\Helpers\DataCollector;
use App\Helpers\QueryHelper;
use App\Services\GraphQLClient;
use App\Services\Random;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[Route('/', name: 'default_')]
class DefaultController extends AbstractController
{
    /**
     * @throws Exception|TransportExceptionInterface
     */
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

    /**
     * @throws Exception
     */
    #[Route('/show/{type}/{query}', name: 'show')]
    public function show(string $type, string $query, DataCollector $collector): Response
    {
        if (! in_array($type, ['episode', 'location', 'dimension'])) {
            throw new Exception(sprintf('Unknown type: "%s"', $type));
        }
//        $type = 'episode';
//        $query = 'Interdimensional Cable 2: Tempting Fate';
//
//        $type = 'location';
//        $query = 'Citadel of Ricks';
//
//        $type = 'dimension';
//        $query = 'Unknown';

        $characterCollection = $collector->collect($type, $query);

        return $this->render(
            'test/overview.html.twig',
            [
                'description' => $characterCollection->getDescription(),
                'info' => $characterCollection->getInfo(),
                'results' => $characterCollection->getData(),
            ]
        );
    }
}
