<?php

namespace Tests\Feature;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdatePostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * It tests an admin can update a post
     *
     * @return void
     */
    public function test_admin_can_update_post()
    {
        $this->markTestIncomplete();
        $this->withoutExceptionHandling();
        $post = factory(Post::class)->create();
        $admin = $this->createAdmin();
        $result = $this->actingAs($admin)->put("admin/posts/{$post->id}", [
            'title' =>  'Updated Post'
        ])->assertStatus(200)->assertSee('Post Updated!');
        $this->assertDatabaseHas('posts', [
            'id'    =>  $post->id,
            'title' =>  'Updated Post'
        ]);
    }

    public function test_guest_cannot_update_post()
    {
        $post = factory(Post::class)->create();

        $result = $this->put("admin/posts/{$post->id}", [
            'title' =>  'Updated Post by guest'
        ])->assertRedirect('login');

        $this->assertDatabaseMissing('posts', [
            'id'    =>  $post->id,
            'title' =>  'Updated Post by guest'
        ]);
    }

    public function test_author_can_update_post()
    {
        $this->markTestIncomplete();
        $user = $this->createUser();

        $post = factory(Post::class)->create(['user_id' => $user->id]);

        $result = $this->actingAs($user)->put("admin/posts/{$post->id}", [
            'title' =>  'Updated Post'
        ])->assertStatus(200)->assertSee('Post Updated!');

        $this->assertDatabaseHas('posts', [
            'id'    =>  $post->id,
            'title' =>  'Updated Post'
        ]);
    }
}
