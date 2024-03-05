<?php

namespace App\Http\Interfaces\Api;

interface UserInterface
{
    public function create($request);
    public function fetch($id);
}