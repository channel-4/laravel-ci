<?php

namespace Tests\Feature;

use App\Article;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * isLikedByはnullを引数としたときは
     * falseを返すことを検証
     * @return void
     */
    public function testIsLikedByNull()
    {
        $article = factory(Article::class)->create();

        $result = $article->isLikedBy(null);
        $this->assertFalse($result);
    }

    /**
     * いいねをしている場合のテスト
     * @return void
     */
    public function testIsLikedByTheUser()
    {
      $article = factory(Article::class)->create();
      $user = factory(User::class)->create();

      // 記事に「いいね」をする処理
      $article->likes()->attach($user);

      $result = $article->isLikedBy($user);

      $this->assertTrue($result);
    }

    /**
     * いいねをしていない場合のテスト
     * @return void
     */
    public function testIsLikedByAnother()
    {
      $article = factory(Article::class)->create();

      $user = factory(User::class)->create();
      $another = factory(User::class)->create();

      // 自分とは違う他人がいいねをする
      // = 自分はいいねしていないことになるのでfalseを返す
      $article->likes()->attach($another);
      $result = $article->isLikedBy($user);

      $this->assertFalse($result);
    }
}
