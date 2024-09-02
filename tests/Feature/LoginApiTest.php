<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_should_login_with_valid_credentials()
    {
        // Arrange: Create a test user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt($password = 'password123'),
        ]);

        // Act: Make a POST request to the login endpoint
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        // Assert: Check the response status and structure
        $response->assertStatus(200)
                 ->assertJsonStructure(['token']);
    }

    /** @test */
    public function it_should_fail_login_with_invalid_credentials()
    {
        // Arrange: Create a test user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Act: Make a POST request with incorrect password
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        // Assert: Check the response status and error message
        $response->assertStatus(401)
                 ->assertJson(['message' => 'Invalid credentials.']);
    }

    /** @test */
    public function it_should_fail_login_with_missing_fields()
    {
        // Act: Make a POST request with missing fields
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            // 'password' is missing
        ]);

        // Assert: Check the response status and validation errors
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['password']);
    }
}