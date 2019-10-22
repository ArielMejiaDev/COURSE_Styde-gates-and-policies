<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function update(PostRequest $request, Post $post)
    {
        //if you not use form request the way above is the best way in controllers
        //you can also use a middleware in routes
        //or use a formrequest and in this method use the function authorize to use the Gate allows method
        //$this->authorize('update', $post);
        $post->update($request->all());
        return 'Post Updated!';
    }

    public function store(Request $request)
    {
        $this->authorize('create', Post::class);
        (new Post)->create($request->all());
        return response('Post Created!', 201);
    }
}
