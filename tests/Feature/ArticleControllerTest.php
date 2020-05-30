<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * articles.indexにアクセスした時の
     * 返却するステータスとViewが正しいかをテスト
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get(route('articles.index'));

        $response->assertStatus(200)
                 ->assertViewIs('articles.index');
    }

    /**
     * articles.create(記事作成画面)
     * 未ログインユーザーの場合に
     * ログイン画面にリダイレクトされるかをテスト
     * @return void
     */
    public function testGuestCreate()
    {
      $response = $this->get(route('articles.create'));
      $response->assertRedirect(route('login'));
    }

    /**
     * articles.create(記事作成画面)
     * ログインユーザーの場合に正しいViewが返却されるかをテスト
     * @return void
     */
    public function testAuthCreate()
    {
      // テスト用にユーザーインスタンスを作成
      $user = factory(User::class)->create();

      // actingAsでログインした状態を作ってアクセス
      $response = $this->actingAs($user)
                       ->get(route('articles.create'));

      $response->assertStatus(200)
               ->assertViewIs('articles.create');
    }
}
