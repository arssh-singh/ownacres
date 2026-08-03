<?php

namespace App\Services\Search;

use Illuminate\Support\Facades\Http;

class QdrantService
{
    private string $url;
    private string $apiKey;
    private string $collection;

    public function __construct()
    {
        $this->url = rtrim(config('services.qdrant.url'), '/');
        $this->apiKey = config('services.qdrant.api_key');
        $this->collection = config('services.qdrant.collection');
    }

    public function upsert(int $id, array $vector, array $payload = []): array
    {
        $response = Http::withHeaders([
            'api-key' => $this->apiKey,
        ])->put(
            "{$this->url}/collections/{$this->collection}/points",
            [
                'points' => [
                    [
                        'id' => $id,
                        'vector' => $vector,
                        'payload' => $payload,
                    ],
                ],
            ]
        );

        $response->throw();

        return $response->json();
    }
    public function search(array $vector, int $limit = 2)
    {
        $response =  Http::withHeaders([
                        'api-key' => $this->apiKey,
                    ])->post(
                        "{$this->url}/collections/properties/points/query",
                        [
                            'query' => $vector,
                            'limit' => $limit,
                            'with_payload' => true,
                        ]
                    );

        $response->throw();

        return $response->json()['result'];
    }
    public function deletePoint(int $id)
    {
        $response = Http::withHeaders([
            'api-key' => $this->apiKey,
        ])->post(
            "{$this->url}/collections/{$this->collection}/points/delete",
            [
                'points' => [$id],
            ]
        );

        $response->throw();

        return $response->json();
    }
}