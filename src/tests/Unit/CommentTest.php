<?php

namespace Tests\Unit;

use App\Models\Board;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_comment_belongs_to_user()
    {
        $user = User::factory()->create();
        $board = Board::factory()->create(['user_id' => $user->id]);
        $comment = Comment::factory()->create(['user_id' => $user->id, 'board_id' => $board->id]);

        $this->assertInstanceOf('App\Models\User', $comment->user);
    }

    /** @test */
    public function a_comment_belongs_to_board()
    {
        $user = User::factory()->create();
        $board = Board::factory()->create(['user_id' => $user->id]);
        $comment = Comment::factory()->create(['user_id' => $user->id, 'board_id' => $board->id]);

        $this->assertInstanceOf('App\Models\Board', $comment->board);
    }
}
