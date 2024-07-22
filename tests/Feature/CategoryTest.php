<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    // public function test_example(): void
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }


    public function test_create_category()
    {
        $response = $this->postJson('/api/categories', [
            'Name' => 'Test Category',
        ]);
        $response->assertStatus(200) 
        ->assertJson([
            'message' => 'Category created successfully',
            'Categories' => Category::all()->toArray() 
        ]);
    }

    public function test_get_all_categories()
    {
        Category::factory()->count(3)->create();

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_update_category()
    {
        $category = Category::factory()->create();

        $response = $this->putJson("/api/categories/{$category->id}", [
            'Name' => 'Updated Category',
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Category updated successfully' ]);
    }

    public function test_delete_category()
    {
        $category = Category::factory()->create();

        $response = $this->deleteJson("/api/categories/{$category->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Category deleted successfully']);
    }

}
