<?php

namespace Tests\Feature;

use App\Models\{Movie,User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MovieControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(
            User::factory()->create()
        );
    }

    /** @test */
    public function it_returns_all_movies()
    {
        Movie::factory(5)->create();
        $response = $this->json('GET', '/api/movies');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'overview',
                        'release_date',
                        'popularity',
                        'vote_average',
                        'vote_count',
                        'image',
                        'created_at',
                    ],
                ],
                'message',
            ]);
    }

    /** @test */
    public function it_returns_a_single_movie()
    {
        $movie = Movie::factory()->create();
        $response = $this->json('GET', "/api/movies/{$movie->id}");
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'title',
                    'overview',
                    'release_date',
                    'popularity',
                    'vote_average',
                    'vote_count',
                    'image',
                    'created_at',
                ],
                'message',
            ]);
    }

    /** @test */
    public function it_updates_a_movie()
    {
        $movie = Movie::factory()->create();
        $updatedData = [
            'title' => 'Updated Title',
        ];
        $response = $this->json('PUT', "/api/movies/{$movie->id}", $updatedData);
        $response->assertStatus(200)->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'title',
                    'overview',
                    'release_date',
                    'popularity',
                    'vote_average',
                    'vote_count',
                    'image',
                    'created_at',
                ],
                'message',
            ]);

        $this->assertDatabaseHas('movies', ['id' => $movie->id, 'title' => 'Updated Title']);
    }

    /** @test */
    public function it_deletes_a_movie()
    {
        $movie = Movie::factory()->create();
        $response = $this->json('DELETE', "/api/movies/{$movie->id}");
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
                'message',
            ]);
    
        $this->assertDatabaseMissing('movies', ['id' => $movie->id]);
    }

    public function it_retrieves_movies_from_cache_if_available()
    {
        Cache::shouldReceive('remember')->once()->andReturn(['mocked', 'movie', 'data']);
        $response = $this->json('GET', '/api/movies');
        $response->assertStatus(200)->assertJsonStructure([
            'success',
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'overview',
                    'release_date',
                    'popularity',
                    'vote_average',
                    'vote_count',
                    'image',
                    'created_at',
                ],
            ],
            'message',
        ]);
    }
}
