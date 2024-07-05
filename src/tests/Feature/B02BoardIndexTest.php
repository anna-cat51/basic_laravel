<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Board;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class B02BoardIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_indexSuccess()
    {
        $user = User::factory()->create();
        $board = Board::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->get('/boards');

        $response->assertStatus(200);
        $response->assertViewIs('boards.index');
        $response->assertSee($board->title);
    }

    public function test_indexFail()
    {
        $response = $this->get('/boards');

        $response->assertRedirect('/login');
    }
}
