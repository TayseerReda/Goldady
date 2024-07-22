<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
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
    }

    public function test_create_post()
    {
        $category = Category::factory()->create();

        $response = $this->postJson('/api/posts', [
            'Title' => 'Test Post',
            'Descreption' => 'This is a test post.',
            'category_id' => $category->id,
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Post created successfully', 'Post' => Post::all()->toArray()]);
    }

    public function test_get_all_posts()
    {
        Post::factory()->count(3)->create(['user_id' => $this->user->id]);

        $response = $this->getJson('/api/posts');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_update_post()
    {
        $category = Category::factory()->create();
        $post = Post::factory()->create([
        'user_id' => $this->user->id,
        
    ]);

        $response = $this->putJson("/api/posts/{$post->id}", [
            'Title' => 'Updated Title',
            'Descreption' => 'Updated content.',
            'category_id' => $category->id,
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Post updated successfully']);
    }

    public function test_delete_post()
    {
        $post = Post::factory()->create(['user_id' => $this->user->id]);

        $response = $this->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Post deleted successfully']);
    }

    // public function test_get_post_with_user_info()
    // {
    //     $post = Post::factory()->create(['user_id' => $this->user->id]);

    //     $response = $this->getJson('/api/posts');

    //     $response->assertStatus(200)
    //              ->assertJsonFragment(['user' => ['id' => $this->user->id]]);
    // }
}
