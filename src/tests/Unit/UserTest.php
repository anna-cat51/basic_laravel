<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Board;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_has_many_boards()
    {
        $user = User::factory()->create();
        $board1 = Board::factory()->create(['user_id' => $user->id]);
        $board2 = Board::factory()->create(['user_id' => $user->id]);

        $this->assertEquals(2, $user->boards()->count());
        $this->assertInstanceOf(Board::class, $user->boards()->first());
    }
}
