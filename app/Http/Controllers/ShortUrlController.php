<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Repository\ShortUrlRepository;
use App\Http\Resources\ShortUrls;

class ShortUrlController extends Controller
{
    /**
     * @var ShortUrlRepository
     */
    private $url;

    /**
     * ShortUrlController constructor
     * @param ShortUrlRepository $url
     */
    public function __construct(ShortUrlRepository $url)
    {
        $this->url = $url;
    }

    /** Get all generated url
     * @return ShortUrls
     */
    public function index(): ShortUrls
    {
        return $this->url->index();
    }

    /**
     * Shorten a url
     * @param Request $request
     * @return JsonResponse
     */
    public function generateUrl(Request $request)
    {
        $input = $request->all();
        $validatedData = Validator::make($input, [
            'link' => 'bail|required|url|unique:short_links'
        ], [
            'link.required' => 'Enter a valid url',
            'link.unique' => 'Link already shortened'
        ]);

        if ($validatedData->fails()) {
            $message = $validatedData->messages();
            return response()->json(['error' => true, 'msg' => $message]);
        }

        return response()->json($this->url->generateUrl($input));
    }

    /**
     * Get information for a shorten url
     * @param $code
     * @return JsonResponse
     */
    public function shortenUrl($code): jsonResponse
    {
        return response()->json($this->url->shortenUrl($code));
    }
}