<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Api\UserInterface;
use App\Http\Requests\Api\{Login,Register};
use App\Http\Resources\User;
use Illuminate\Http\Request;
use App\Http\Traits\ResponseTrait;
use Illuminate\Support\Facades\{Auth,Log};

class AuthController extends Controller
{
    use ResponseTrait;

    protected $repository;

    public function __construct(UserInterface $authRepository)
    {
        $this->repository = $authRepository;
    }

    public function login(Login $request)
    {
        $validated = $request->validated();
        $data = array();
        $error = false;
        $message = null;

        try {
            if(Auth::attempt($validated)){
                $record = $this->repository->fetch(Auth::id());
                $data = new User($record);
                $message = 'Successfully logged in';
            }
            else {
                $message =  'Unauthorized';
                $error = 401;
            }
        } catch (\Exception $e) {
            throw $e;
            $error = true;
            Log::error($e);
            
        }
        return $this->response(!$error, $data, $message, $error ? $error : null);
    }

    public function register(Register $request)
    {
        $validated = $request->validated();
        $data = array();
        $error = false;
        $message = 'User Created Successfully';
        try {
            $user = $this->repository->create($validated);
            $data = new User($user);
           
        } catch (\Exception $e) {
            $error = true;
            throw $e;
            Log::error($e);
        }
        return $this->response(!$error, $data, $message, $error ? $error : null);
    }

    public function logout(Request $request)
    {
        $error   = false;
        $message = 'Successfully logged out!';
        $user = Auth::user();
        $user->tokens()->delete();
        return $this->response(!$error, [], $message, $error ? $error : null);
    }
}
