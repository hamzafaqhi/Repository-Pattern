<?php

namespace App\Http\Repositories\Api;

use App\Http\Interfaces\Api\UserInterface;
use App\Models\User;

class UserRepository implements UserInterface
{
    protected $model;

    public function __construct(User $userModel)
    {
        $this->model = $userModel;
    }
    
    public function create($request) {
        extract($request);
        $user = $this->model->create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);
        return $user;
    }

    public function fetch($id) {
        $user = $this->model->find($id);
        return $user;
    }
}