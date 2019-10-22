<?php

namespace App\Providers;

use App\Policies\OldPostPolicy;
use App\Policies\PostPolicy;
use App\Post;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{

    //laravel docs recommend to use a class associated with models and regiter it on array policies

    //if you have a gate that is not associated with any model you can use Gate::define

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\Post'  => 'App\Policies\PostPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function(User $user){
            if ($user->isAdmin()) {
                return true;
            }
        });



        //set policies with class and a resource method as resource route
        //it supports view, create, update, delete

        //this works if you use the convention
        //Gate::resource('post', OldPostPolicy::class);

        //if you do now want to follow the convention you can change the name
        //of your methods in PostPolicy class, and add a third param in resource method as

        //in this example it works if the methods as convention delete is changed to deletePost
        //and update convention to named the method change to updatePost
        // Gate::resource('post', PostPolicy::class, [
        //     'update'    =>  'updatePost',
        //     'delete'    =>  'deletePost'
        // ]);

        //set policies as classes a good way if only need some policies

        // Gate::define('update-post', 'App\Policies\PostPolicy@update');

        // Gate::define('delete-post', 'App\Policies\PostPolicy@delete');

        //set policies as callbacks

        // Gate::define('update-post', function(User $user, Post $post) {
        //     return $user->isAdmin() || $user->owns($post);
        // });

        // Gate::define('delete-post', function(User $user, Post $post) {
        //     return $user->owns($post) && ! $post->isPublished() ;
        // });
    }
}
