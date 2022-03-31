<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_index_return_200()
    {
        $response = $this->get('/users');
        $response->assertStatus(200);
    }

    public function test_users_index_show_an_user()
    {
        $user = User::factory()->create();

        $response = $this->get('/users');
        $response->assertStatus(200)
            ->assertSee($user->username);
    }
}
