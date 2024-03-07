<?php

namespace App\Http\Interfaces\Api;

interface MovieInterface
{
    public function create($request);
    public function fetch($id);
    public function update($id,$requets);
    public function delete($id);
    public function syncMoviesData($data);
    public function all($keyword = null,$relations = [],$perPage = 10);
}