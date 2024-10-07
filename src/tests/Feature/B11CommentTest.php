<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Board;
use App\Models\Comment;

class CommentViewTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     * @return void
     */
    public function testCommentIsDisplayedOnBoardPage()
    {
        $user = User::factory()->create();
        $board = Board::factory()->create(['user_id' => $user->id]);
        $comment = Comment::factory()->create(['board_id' => $board->id, 'user_id' => $user->id, 'body' => 'Test Comment']);

        $response = $this->actingAs($user)->get(route('boards.show', $board->id));

        $response->assertStatus(200)
                 ->assertSee($comment->body);
    }
}
