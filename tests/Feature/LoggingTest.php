<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoggingTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'sanctum');
        Log::shouldReceive('info');
    }

    public function test_logging_post_creation()
    {
        $category = Category::factory()->create();

        $this->postJson('/api/posts', [
            'Title' => 'Test Post',
            'Descreption' => 'This is a test post.',
            'category_id' => $category->id,
            'user_id' => $this->user->id,
        ]);

        Log::shouldHaveReceived('info')
           ->once()
           ->with('Post created: ', \Mockery::on(function ($data) {
               return $data['post']['Title'] === 'Test Post';
           }));
    }

    public function test_logging_post_update()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
        $category = Category::factory()->create();

        $this->putJson("/api/posts/{$post->id}", [
            'Title' => 'Updated Title',
            'Descreption' => 'Updated content.',
            'category_id' => $category->id,
        ]);

        Log::shouldHaveReceived('info')
           ->once()
           ->with('Post updated: ', \Mockery::on(function ($data) {
               return  $data['post']['Title'] === 'Updated Title';
           }));
    }

    public function test_logging_post_deletion()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);
    
        $this->deleteJson("/api/posts/{$post->id}");
    
        Log::shouldHaveReceived('info')
           ->once()
           ->with('Post deleted: ', \Mockery::on(function ($data) use ($post) {
               return $data['post']->id === $post->id;
           }));
    }
}
