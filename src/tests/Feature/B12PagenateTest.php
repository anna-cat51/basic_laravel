<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Board;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class B12PagenateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test pagination of boards.
     *
     * @return void
     */
    public function testBoardPagination()
    {
        $user = User::factory()->create();

        Board::factory(50)->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)
             ->get('/boards')
             ->assertStatus(200)
             ->assertSee('<span aria-current="page">', false);
    }
}
