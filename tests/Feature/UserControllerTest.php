<?php

namespace Tests\Feature;

use App\Models\User;
use Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Storage;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    // Index test

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

    // Edit User Test

    public function test_edit_user_return_200()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->get('/users/settings');
        $response->assertStatus(200)
            ->assertSee($user->username);
    }

    public function test_update_user()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        Auth::login($user);
        $data = [
            'name' => $this->faker->name(),
            'username' => $this->faker()->unique()->userName(),
            'avatar' => UploadedFile::fake()->image('test.png'),
        ];

        $response = $this->put('/users/settings', $data);
        $response->assertRedirect('/users/settings');

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'username' => $data['username'],
            'avatar' => 'avatars/' . $data['avatar']->hashName(),
        ]);
    }

    public function test_validate_update_user()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->put('/users/settings', []);
        $response->assertStatus(302)
            ->assertSessionHasErrors(['username', 'name']);
    }
}
