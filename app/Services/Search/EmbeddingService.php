<?php

namespace App\Services\Search;
use Illuminate\Support\Facades\Http;
class EmbeddingService
{
    public function embed(string $text){
        $response = Http::withToken(env('OPEN_API_KEY'))
            ->post(env('OPEN_AI_URL'), [
                'model' => env('EMBEDDING_MODEL'),
                'input' => $text,
                'dimensions' => 3072, // Example
            ]);
        $response->throw();
        // dd($response->status(), $response->json());
        return $response->json('data.0.embedding');
    }
}