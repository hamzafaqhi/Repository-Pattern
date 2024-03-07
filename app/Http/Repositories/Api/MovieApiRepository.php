<?php

namespace App\Http\Repositories\Api;

use App\Http\Interfaces\Api\ExternalApiInterface;
use Illuminate\Support\Facades\Http;

class MovieApiRepository implements ExternalApiInterface
{
    protected $url, $timeout, $token;

    public function __construct()
    {
        $this->url = config('app.movie_url').'/3/search/movie?query=star wars';
        $this->timeout = config('app.movie_timeout');
        $this->token = config('app.movie_api_access_token');
    }

    public function fetchData()
    {
        $response = Http::timeout($this->timeout)->withToken($this->token)->get($this->url);
        return $response;
    }
}