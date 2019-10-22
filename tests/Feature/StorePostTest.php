<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StorePostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_admin_can_create_post()
    {
        //$this->withoutExceptionHandling();
        $admin = $this->createAdmin();

        $this->actingAs($admin)->post("admin/posts/", [
            'title'     =>  'Post Title',
            'user_id'   => $admin->id,
        ])->assertStatus(201)->assertSee('Post Created!');

        $this->assertDatabaseHas('posts', [
            'title' =>  'Post Title'
        ]);
    }

    public function test_authors_can_create_post()
    {
        $user = $this->createUser(['role' => 'author']);

        $this->actingAs($user)->post("admin/posts/", [
            'title'     =>  'Post Title',
            'user_id'   => $user->id,
        ])->assertStatus(201)->assertSee('Post Created!');

        $this->assertDatabaseHas('posts', [
            'title' =>  'Post Title'
        ]);
    }

    public function test_unauthorize_users_cannot_create_post()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $this->post("admin/posts/", [
            'title'     =>  'Post Title'
        ])->assertStatus(403);

        $this->assertDatabaseMissing('posts', [
            'title' =>  'Post Title'
        ]);
    }
}
