<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Critic;

class CriticTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeleteCritic()
    {
        $this->seed();
        $critics = Critic::all();

        $response = $this->delete('/api/critics/'.$critics[0]->id);
    
        $response->assertStatus(OK);
        $this->assertDatabaseMissing('critics', ['id' => $critics[0]->id]);
    }
   
    public function testDeleteCriticReturn404WhenIdNotFound()
    {
        $this->seed();

        $response = $this->delete('/api/critics/10000');
    
        $response->assertStatus(NOT_FOUND);
    }
}
