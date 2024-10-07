<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Board;
use App\Models\Comment;

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

    /** @test */
    public function board_has_many_comments()
    {
        $user = User::factory()->create();
        $board = Board::factory()->create(['user_id' => $user->id]);

        for ($i = 0; $i < 2; $i++) {
            Comment::factory()->create(['user_id' => $user->id, 'board_id' => $board->id]);
        }

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $board->comments);
        $this->assertInstanceOf('App\Models\Comment', $board->comments->first());
        $this->assertCount(2, $board->comments);
    }
}
