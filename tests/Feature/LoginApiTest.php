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
        
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt($password = 'password123'),
        ]);

        // Act: Make a POST request to the login endpoint
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        
        $response->assertStatus(200)
                 ->assertJsonStructure(['token', 'user']);
    }

    /** @test */
    public function it_should_fail_login_with_invalid_credentials()
    {
        
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

       
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        
        $response->assertStatus(401)
                 ->assertJson(['message' => 'The provided credentials are incorrect.']);
    }

    /** @test */
    public function it_should_fail_login_with_missing_fields()
    {
        
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            
        ]);

        
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['password']);
    }
}