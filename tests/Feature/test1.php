<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class test1 extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function test_user_can_be_created()
    {
        $response = $this->postJson('/api/users', [
            'username' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(201);
        $this->assertCount(1, User::all());
    }

    public function test_user_can_be_updated()
    {
        $user = User::create([
            'username' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);
        $response = $this->putJson('/api/users/' . $user->id, [
            "username" => "Test2 User"
        ]);
        $response->assertStatus(202);
        $this->assertEquals("Test2 User", $response['data']['username']);
    }
}
