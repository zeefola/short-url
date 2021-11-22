<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Repository\ShortUrlRepository;

class ShortUrlController extends Controller
{
    /**
     * @var ShortUrlRepository
     */
    private $url;
}