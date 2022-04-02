<?php

namespace Tests\Feature;

use App\Models\Photo;
use App\Models\User;
use Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_store_comment()
    {
        $user = User::factory()->create();
        $photo = Photo::factory()->create();
        Auth::login($user);
        $data = [
            'body' => $this->faker()->text(),
        ];

        $response = $this->post("/photos/{$photo->id}/comments", $data);
        $response->assertStatus(302);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'photo_id' => $photo->id,
            'body' => $data['body'],
        ]);
    }
}
