<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

use App\Models\ShortLink;

class ShortUrlTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test get all shorten url
     * @return void
     */
    public function testGetUrls()
    {
        $url = ShortLink::factory()->create();

        $response = $this->json('GET', '/api/url/short');
        $response->assertJson([
            'data' => [
                [
                    'short_url' => $url->code,
                ]
            ]
        ]);
    }

    /**
     * Test get shorten url details using the short url code
     * @return void
     */
    public function testGetUrlDetailUsingCode()
    {
        $url = ShortLink::factory()->create();

        $response = $this->json('GET', '/api/url/' . $url->code);
        $response->assertJson([
            'short_url' => $url->code,

        ]);
    }

    /**
     * Test code does not exist get shorten url details using the short url code
     * @return void
     */
    public function testCodeDoesNotExist()
    {
        $url = ShortLink::factory()->create();
        $code = '7624';

        $response = $this->json('GET', '/api/url/' . $code);
        $response->assertJson([
            'error' => true,
            'msg' => 'Entered code does not exist'
        ]);
    }

    /**
     * Test link is required
     * @return void
     */
    public function testLinkIsRequired()
    {
        $data = [];

        $response = $this->json('POST', '/api/url/generate', $data);
        $response->assertJson([
            'error' => true,
            'msg' => [
                'link' => [
                    'Enter a valid url'
                ]
            ]
        ]);
    }
    /**
     * Test link is unique
     * @return void
     */
    public function testLinkIsUnique()
    {
        ShortLink::factory()->create(
            [
                'link' => 'https://github.com/Kusnap/kusnap-marketing-api/compare/develop...zeefola:develop'
            ]
        );

        $response = $this->json('POST', '/api/url/generate', [
            'link' => 'https://github.com/Kusnap/kusnap-marketing-api/compare/develop...zeefola:develop'
        ]);
        $response->assertJson([
            'error' => true,
            'msg' => [
                'link' => [
                    'Link already shortened'
                ]
            ]
        ]);
    }

    /**
     * Test generate short url
     * @return void
     */
    public function testGenerateShortUrl()
    {
        $data = [
            'link' => $this->faker->url(),
            'code' => Str::random(8)
        ];

        $response = $this->json('POST', '/api/url/generate', $data);
        $response->assertJson([
            'error' => false,
            'msg' => 'Url Shortened successfully'
        ]);

        $this->assertDatabaseHas('short_links', [
            'link' => $data['link'],
            'code' => $data['code']
        ]);
    }
}