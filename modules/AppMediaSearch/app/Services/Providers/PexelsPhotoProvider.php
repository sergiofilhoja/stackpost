<?php

namespace Modules\AppMediaSearch\Services\Providers;

use Illuminate\Support\Facades\Http;
use Modules\AppMediaSearch\Services\Providers\ProviderInterface;

class PexelsPhotoProvider implements ProviderInterface
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = get_option("file_pexels_api_key", "");
    }

    public function search(string $query, string $type = 'photo', int $page = 1): array
    {
        if ($type !== 'photo') return [];

        $response = Http::withHeaders([
            'Authorization' => $this->apiKey,
        ])->get('https://api.pexels.com/v1/search', [
            'query' => $query,
            'per_page' => 20,
            'page' => $page,
        ]);

        if ($response->failed()) return [];

        $results = $response->json('photos');

        return collect($results)->map(function ($item) {
            return [
                'id'        => $item['id'],
                'thumbnail' => $item['src']['medium'],
                'full'      => $item['src']['original'],
                'source'    => 'pexels',
                'link'      => $item['url'],
                'author'    => $item['photographer'],
            ];
        })->toArray();
    }
}
