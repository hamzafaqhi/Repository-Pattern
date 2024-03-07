<?php

namespace App\Http\Repositories\Api;

use App\Http\Interfaces\Api\MovieInterface;
use App\Models\Movie;

class MovieRepository implements MovieInterface
{
    protected $model;

    public function __construct(Movie $movieModel)
    {
        $this->model = $movieModel;
    }
    
    public function create($request) {
        extract($request);
        $movie = $this->model->create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);
        return $movie;
    }

    public function fetch($id) {
        $movie = $this->model->findOrFail($id);
        return $movie;
    }

    public function update($id, $request) {
        $movie = $this->model->where('id', $id)->update($request);
        return $movie;
    }

    public function delete($id) {
        return $this->model->destroy($id);
    }

    public function all($keyword = null,$relations = [],$perPage = 10) {
        $query = $this->model->with($relations);
        if(isset($keyword)) {
            $query->where('title', 'like', '%' . $keyword . '%');
        } 
        return $query->paginate($perPage);
    }


    public function syncMoviesData($data)
    {
        foreach($data as $movieData) {
            $this->model->updateOrCreate(['title' => $movieData['title']], [
                'overview' => $movieData['overview'],
                'release_date' => $movieData['release_date'],
                'popularity' => $movieData['popularity'],
                'vote_average' => $movieData['vote_average'],
                'vote_count' => $movieData['vote_count'],
                'image' => $movieData['poster_path'],
                'title' => $movieData['title']
            ]);
        }
        return $this->model->paginate(10);
    }
}