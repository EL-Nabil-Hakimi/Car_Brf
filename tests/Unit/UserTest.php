<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;


class UserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void {
        parent::setUp();
        Artisan::call('migrate:fresh');
    }
    
    public function test_user_can_be_created()
    {
        $response = $this->post('/api/users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(201);
        $this->assertCount(1, User::all());
    }
    public function test_user_can_be_updated()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);
        $response = $this->putJson('/api/users/' . $user->id, [
            "name" => "Test2 User"
        ]);
        $response->assertStatus(202);
        $this->assertEquals("Test2 User", $response['data']['name']);
    }

    

}
