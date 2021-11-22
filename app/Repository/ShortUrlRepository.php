<?php

namespace App\Repository;

use App\Repository\Actors\ShortUrlActor;
use App\Http\Resources\ShortUrl;
use App\Http\Resources\ShortUrls;
use Illuminate\Support\Str;

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

    /**
     * Generate a shorten url
     * @param $input
     * @return array
     */
    public function generateUrl($input)
    {
        $input = request()->all();

        $code = Str::random(8);

        $this->shortUrl->create([
            'link' => $input['link'],
            'code' => $code
        ]);

        $url = $this->shortUrl->findBy('link', $input['link']);

        ShortUrl::withoutWrapping();

        return [
            'error' => false,
            'msg' => 'Url Shortened successfully',
            'data' => new ShortUrl($url)
        ];
    }

    /**
     * Get informaton for a shortened url
     * @param $code
     * @return ShortUrl|array
     */
    public function shortenUrl($code)
    {
        $url = $this->shortUrl->findBy('code', $code);
        if ($url) {
            ShortUrl::withoutWrapping();
            return new ShortUrl($url);
        }

        return [
            'error' => true,
            'msg' => 'Entered code does not exist'
        ];
    }
}