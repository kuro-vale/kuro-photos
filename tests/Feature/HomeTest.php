<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    public function test_redirect_to_home()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    public function test_home_return_200()
    {
        $response = $this->get('/home');

        $response->assertStatus(200);
    }
}
