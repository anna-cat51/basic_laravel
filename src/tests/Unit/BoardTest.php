<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Board;

class BoardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function board_belongs_to_user()
    {
        $user = User::factory()->create();
        $board = Board::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $board->user);
    }
}
