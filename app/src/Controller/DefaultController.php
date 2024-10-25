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
    public function __construct(private readonly QueryHelper $queryHelper, private readonly GraphQLClient $client)
    {
    }

    /**
     * @throws Exception|TransportExceptionInterface
     */
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $characterId = Random::getRandomNumber(1, 826);

        return $this->render(
            'default/index.html.twig',
            $this->getCharacterData($characterId)
        );
    }

    /**
     * @throws Exception|TransportExceptionInterface
     */
    #[Route('/character/{characterId}', name: 'character')]
    public function character(string $characterId): Response
    {
        $characterId = (int) $characterId;
        if (($characterId < 1) || ($characterId > 826)) {
            throw $this->createNotFoundException();
        }

        return $this->render(
            'default/index.html.twig',
            $this->getCharacterData($characterId)
        );
    }

    /**
     * @throws Exception|TransportExceptionInterface
     */
    #[Route('/show/{type}/{query}', name: 'show')]
    public function show(string $type, string $query, DataCollector $collector): Response
    {
        if (! in_array($type, ['episode', 'location', 'dimension'])) {
            throw new Exception(sprintf('Unknown type: "%s"', $type));
        }

        $characterCollection = $collector->collect($type, $query);

        return $this->render(
            'default/overview.html.twig',
            [
                'description' => $characterCollection->getDescription(),
                'info' => $characterCollection->getInfo(),
                'results' => $characterCollection->getData(),
            ]
        );
    }

    /**
     * @param int $characterId
     * @return array<string, array<int|string, mixed>>
     * @throws TransportExceptionInterface
     */
    private function getCharacterData(int $characterId): array
    {
        $query = $this->queryHelper->getCharacterInfo($characterId);

        $info = $this->client->request('https://rickandmortyapi.com/graphql', $query, 'charactersByIds');
        $data = current($info);

        if (!$data) {
            throw $this->createNotFoundException();
        }

        return $data;
    }
}
