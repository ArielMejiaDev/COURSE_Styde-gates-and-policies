<?php

namespace App\Policies;

use App\{Post, User};
use Illuminate\Auth\Access\HandlesAuthorization;

class OldPostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Post $post)
    {
        return $user->isAdmin() || $user->owns($post);
    }

    public function delete(User $user, Post $post)
    {
        return $user->owns($post) && ! $post->isPublished();
    }
}
