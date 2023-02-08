<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    function index()
    {
        $posts = Post::select('posts.*', 'users.username')
            ->join('users', 'users.id', '=', 'posts.userId')
            ->orderBy('posts.id', 'desc')
            ->get();

        return $posts;
    }

    function store(Request $request)
    {
        $post = new Post;

        if ($request['pathMedia']) {
            $imageName = time() . '.' . $request['pathMedia']->extension();
            $request['pathMedia']->move(public_path('media'), $imageName);
            $post->pathMedia = $imageName;
        }

        $post->content = $request['content'];
        $post->publishDate = date("Y-m-d H:i:s");
        $post->published = 0;
        $post->userId = 1;

        $post->save();
        return $post;
    }

    public function show($id)
    {
        $post = Post::find($id);
        return $post;
    }
}
