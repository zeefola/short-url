<?php

namespace App\Repository\Actors;

use App\Repository\Contracts\Repository;
use App\Models\ShortLink;

class ShortUrlActor extends Repository
{

    public function __construct(ShortLink $shortLink)
    {
        $this->model = $shortLink;
    }
}