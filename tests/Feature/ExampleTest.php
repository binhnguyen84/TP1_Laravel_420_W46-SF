<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_get_user()
    {
        //Create a user
        $user = User::factory()-create();
        
        // Authenticate the user using Sanctum
        Sanctum::actingAs($user);

        // Make an authenticated request
        $response = $this->get('/api/user');

        // Assert that the request was successful and returned the expected user data
        $response->assertOk();
        $response->assertJson([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}
