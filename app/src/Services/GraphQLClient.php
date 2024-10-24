<?php

namespace App\Services;

use Exception;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpClient\HttpOptions;

readonly class GraphQLClient
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    /**
     * @return array<string, array<int|string, mixed>>
     * @throws Exception|TransportExceptionInterface
     */
    public function request(string $endpoint, string $query, string $property): array
    {
        $options = (new HttpOptions())
            ->setJson(['query' => $query])
            ->setHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'User-Agent' => 'Symfony GraphQL client',
            ])
        ;

        $response = $this->client->request(
            'POST',
            $endpoint,
            $options->toArray()
        );

        $content = $response->getContent();
        $json = json_decode($content, true, JSON_THROW_ON_ERROR);

        if (! is_array($json) || ! key_exists('data', $json)) {
            throw new Exception('Something went wrong, no usable data returned');
        }

        return $json['data'][$property];
    }
}
