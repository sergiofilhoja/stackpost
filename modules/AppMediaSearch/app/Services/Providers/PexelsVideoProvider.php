<?php

namespace Modules\AppMediaSearch\Services\Providers;

use Illuminate\Support\Facades\Http;
use Modules\AppMediaSearch\Services\Providers\ProviderInterface;

class PexelsVideoProvider implements ProviderInterface
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = get_option("file_pexels_api_key", "");
    }

    public function search(string $query, string $type = 'video', int $page = 1): array
    {
        if ($type !== 'video') return [];

        $response = Http::withHeaders([
            'Authorization' => $this->apiKey,
        ])->get('https://api.pexels.com/videos/search', [
            'query' => $query,
            'per_page' => 20,
            'page' => $page,
        ]);

        if ($response->failed()) return [];

        $results = $response->json('videos');

        return collect($results)->map(function ($item) {
            return [
                'id'        => $item['id'],
                'thumbnail' => $item['image'], // Thumbnail preview
                'full'      => $item['video_files'][0]['link'], // Best-effort first quality
                'source'    => 'pexels',
                'link'      => $item['url'],
                'author'    => $item['user']['name'],
            ];
        })->toArray();
    }
}
