<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\Api\{ExternalApiInterface,MovieInterface};
use App\Http\Requests\Api\MovieUpdate;
use App\Http\Resources\Movie;
use App\Http\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    use ResponseTrait;
    protected $repository,$movieApiRepository;

    public function __construct(MovieInterface $movieRepository, ExternalApiInterface $movieApiRepository)
    {
        $this->repository = $movieRepository;
        $this->movieApiRepository = $movieApiRepository;
    }

    public function index(Request $request)
    {
        $data = array();
        $error = false;
        $message = 'Movies Retrieved Successfully';
        try {
            $title = $request->title ?? null;
            if ($title) {
                $data = $this->repository->all($title);
            } 
            else {
                $movies = Cache::remember('movies', now()->addHour(), function () {
                    $movieResponse = $this->movieApiRepository->fetchData();
                    if ($movieResponse->successful()) {
                        $movieResponse = $movieResponse->json();
                        if (isset($movieResponse['results'])) {
                            return $movieResponse['results'];
                        }
                    }
                });
                $data = $this->repository->syncMoviesData($movies);
            }
            $data = Movie::collection($data);
        } catch (Exception $e) {
            Log::error($e);
            $error   = true;
            $message = $e->getMessage();
        }
        return $this->response(!$error, $data, $message, $error && is_numeric($error) ? $error : null);
    }

    public function show($id)
    {
        $data    = array();
        $error   = false;
        $message = 'Movie Retrieved succesfully.';
        try {
            $data = $this->repository->fetch($id);
            $data = new Movie($data);
        } catch (Exception $e) {
            Log::error($e);
            $error   = true;
            $message = $e->getMessage();
        }
        return $this->response(!$error, $data, $message, $error && is_numeric($error) ? $error : null);

    }

    public function update(MovieUpdate $request, $id)
    {   
        $data    = $request->validated();
        $error   = false;
        $message = 'Movies Updated successfully.';
        try {
            $this->repository->update($id,$data);
            $data = $this->repository->fetch($id);
            $data = new Movie($data);
        } catch (Exception $e) {
            Log::error($e);
            $error   = true;
            $message = $e->getMessage();
        }
        return $this->response(!$error, $data, $message, $error && is_numeric($error) ? $error : null);
    }

    public function destroy($id)
    {
        $data    = array();
        $error   = false;
        $message = 'Movie Deleted successfully.';

        try {
            $this->repository->fetch($id);
            $this->repository->delete($id);
        } catch (Exception $e) {
            Log::error($e);
            $error   = true;
            $message = $e->getMessage();
        }
        return $this->response(!$error, $data, $message, $error && is_numeric($error) ? $error : null);
    }
}
