<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Film;
use App\Models\Actor;

class FilmTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetFilms()
    {
        $this->seed();
        $films = Film::all();

        $response = $this->get('/api/films');
        $response->assertJsonCount(PAGINATION, "data");

        for($i = 0; $i < PAGINATION; $i++)
        {
            $response->assertJsonFragment(['title' => $films[$i]->title, 'release_year' => $films[$i]->release_year, 
            'length' => $films[$i]->length, 'description' => $films[$i]->description, 'rating' => $films[$i]->rating,
            'language_id' => $films[$i]->language_id, 'special_features' => $films[$i]->special_features, 
            'image' => $films[$i]->image]);
        }
        $response->assertStatus(OK);
    }

    public function testGetActorsForFilm()
    {
        $this->seed();
        $films = Film::all();
        $actors = $films[0]->actors()->get();

        $response = $this->get('/api/films/'.$films[0]->id.'/actors');
        $response->assertJsonCount(count($actors), "data");

        $response->assertJsonFragment(['last_name' => $actors[0]->last_name, 'first_name' => $actors[0]->first_name, 
            'birthdate' => $actors[0]->birthdate]);

        $response->assertStatus(OK);
    }

    public function testGetActorsForFilmSouldReturn404WhenIdNotFound()
    {
        $this->seed();

        $response= $this->get('/api/films/10000/films');

        $response->assertStatus(NOT_FOUND);
    }

    public function testGetCriticsForFilm()
    {
        $this->seed();
        $films = Film::all();
        $critics = $films[0]->critics()->get();

        $response = $this->get('/api/films/'.$films[0]->id.'/critics');
        $response->assertJsonCount(count($critics), "data");

        $response->assertJsonFragment(['user_id' => $critics[0]->user_id, 'film_id' => $critics[0]->film_id, 
            'score' => $critics[0]->score, 'comment' => $critics[0]->comment]);

        $response->assertStatus(OK);
    }

    public function testGetCriticsForFilmSouldReturn404WhenIdNotFound()
    {
        $this->seed();

        $response= $this->get('/api/films/10000/critics');

        $response->assertStatus(NOT_FOUND);
    }
}
