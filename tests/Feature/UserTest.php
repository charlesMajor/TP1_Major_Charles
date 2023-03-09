<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPostUser()
    {
        $this->seed();
        
        $json = ["login"=> "testUser", "password"=>"test", "email"=>"testUser@hotmail.com", "last_name"=>"User", 
        "first_name"=>"Test"];
        $response = $this->postJson('/api/users', $json);

        $response->assertJsonFragment($json);
        $response->assertStatus(CREATED);
        $this->assertDatabaseHas('users', $json);
    }

    public function testPostUserShouldReturn422WhenMissingField()
    {
        $this->seed();

        $json = ["password"=>"test", "email"=>"testUser@hotmail.com", "last_name"=>"User", "first_name"=>"Test"];
        $response = $this->postJson('/api/users', $json);

        $response->assertStatus(INVALID_DATA);
    }

    public function testPutUser()
    {
        $this->seed();

        $users = User::all();

        $json = ["login"=> "testUser", "password"=>"test", "email"=>"testUser@hotmail.com", "last_name"=>"User", 
        "first_name"=>"Test"];
        $response = $this->putJson('/api/users/'.$users[0]->id, $json);

        $response->assertStatus(OK);
        $this->assertDatabaseHas('users', $json);
    }

    public function testPutUserShouldReturn422WhenMissingField()
    {
        $this->seed();

        $users = User::all();

        $json = ["password"=>"test", "email"=>"testUser@hotmail.com", "last_name"=>"User", "first_name"=>"Test"];
        $response = $this->putJson('/api/users/'.$users[0]->id, $json);

        $response->assertStatus(INVALID_DATA);
    }

    public function testPutUserSouldReturn404WhenIdNotFound()
    {
        $this->seed();

        $users = User::all();

        $json = ["password"=>"test", "email"=>"testUser@hotmail.com", "last_name"=>"User", "first_name"=>"Test"];
        $response = $this->putJson('/api/users/10000', $json);

        $response->assertStatus(NOT_FOUND);
    }

}
