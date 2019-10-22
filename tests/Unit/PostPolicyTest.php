<?php

namespace Tests\Unit;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class PostPolicyTest extends TestCase
{
    use RefreshDatabase;
    /**
     * It tests an admin can update a policy
     *
     * @test
     *
     * @return void
     */
    public function test_admin_can_update_post()
    {
        // $admin = $this->createAdmin();

        // $post = new Post;

        //commond way to connect a user as admin
        //$this->be($admin);
        //$result = Gate::allows('update-post', $post);


        //impersonate another user to test certain role
        //$result = Gate::forUser($admin)->allows('update-post', $post);

        //to test if a specific model with policies you can use
        //$result = $admin->can('update-post', $post);

        //to test a policy from the model of specific user authenticated
        //$this->be($admin);
        //$result = auth()->user()->can('update-post', $post);

        // $this->be($admin);
        // $result = $admin->can('update-post', $post);

        // $this->assertTrue($result);

        $admin = $this->createAdmin();
        $this->be($admin);
        $post = new Post;
        $result = Gate::allows('update', $post);
        $this->assertTrue($result);
    }

    public function test_guest_cannot_update_post()
    {
        $post = factory(Post::class)->create();
        $result = Gate::allows('update', $post);
        $this->assertFalse($result);
    }

    public function test_post_author_can_update_post()
    {
        $user = $this->createUser();
        $post = factory(Post::class)->create(['user_id' => $user->id]);
        $result = Gate::forUser($user)->allows('update', $post);
        $this->assertTrue($result);
    }


    public function test_admin_can_delete_post()
    {
        $admin = $this->createAdmin();
        $post = factory(Post::class)->create();
        $result = Gate::forUser($admin)->allows('delete', $post);
        $this->assertTrue($result);
    }

    public function test_author_cannot_delete_published_post()
    {
        $user = $this->createUser();
        $post = factory(Post::class)->state('published')->create(['user_id' => $user->id]);
        $result = Gate::forUser($user)->allows('delete', $post);
        $this->assertFalse($result);
    }

    public function test_author_can_delete_draft_post()
    {
        $user = $this->createUser();
        $post = factory(Post::class)->state('draft')->create(['user_id' => $user->id]);
        $result = Gate::forUser($user)->allows('delete', $post);
        $this->assertTrue($result);
    }

}
