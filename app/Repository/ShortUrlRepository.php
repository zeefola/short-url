<?php

namespace App\Repository;

use App\Repository\Actors\ShortUrlActor;
use App\Http\Resources\ShortUrl;
use App\Http\Resources\ShortUrls;

/** Class ShortUrlRepository
 */

class ShortUrlRepository
{
    /**
     * @var ShortUrlActor
     */
    private $shortUrl;

    /**
     * ShortUrlRepository constaructor
     * @param ShortUrlActor $shortUrl
     */

    public function __construct(ShortUrlActor $shortUrl)
    {
        $this->shortUrl = $shortUrl;
    }

    /**
     * Get all generated short urls
     * @return ShortUrls
     */
    public function index(): ShortUrls
    {
        $limit = request()->input('limit') ?? 20;

        $urls = $this->shortUrl->paginate($limit);

        return new ShortUrls($urls);
    }
}