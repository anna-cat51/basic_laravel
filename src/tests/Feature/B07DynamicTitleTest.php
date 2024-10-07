<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Board;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class B07DynamicTitleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider pagesProvider
     */
    public function testMetaTags($url, $expectedTitle, $needLogin)
    {
        $user = \App\Models\User::factory()->create();
        if($needLogin) {
            $this->actingAs($user);
        }

        $response = $this->get($url);
        $response->assertStatus(200);
        $response->assertSee("<title>RUNTEQ BOARD | {$expectedTitle}</title>", false);
    }

    public function pagesProvider()
    {
        return [
            ['/login', 'ログイン', false],
            ['/register', 'ユーザー登録', false],
            ['/boards/create', '掲示板作成', true],
            ['/boards', '掲示板一覧', true],
            ['/', 'ダッシュボード', true],
            ['/profile', 'プロフィール編集', true],
        ];
    }
}
